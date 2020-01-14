<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Brand;
use App\Http\Requests\StoreBrandPost;
use Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * 列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        Cookie::queue('test', 'aaa', 1);
//        echo Cookie::get('test');
        
        $word = request()->word??'' ;
        $desc = request()->desc??'' ;
       
//        echo 'data_'.$page;
//        dump($data);
        //Cache::flush();
        $page = request()->page?:1;
        //$data = Cache::get('brand_'.$page.'_'.$word.'_'.$desc); //获取
        $data = Redis::get('brand_'.$page.'_'.$word.'_'.$desc);
         //dump($data);
         if(!$data){
           //  echo "DB";
            $where = [];
            if($word){
                $where[]=['brand_name','like',"%$word%"];
            }
            
            if($desc){
                $where[]=['brand_desc','like',"%$desc%"];
            }
            //$data = DB::table('brand')->orderBy('brand_id','desc')->paginate(2);
           // DB::connection()->enableQueryLog();
            $data = Brand::where($where)->orderBy('brand_id','desc')->paginate(2);
            //dd($data);
           //  Cache::put('brand_'.$page.'_'.$word.'_'.$desc, $data, 60); //存储
            $data = serialize($data);
            Redis::setex('brand_'.$page.'_'.$word.'_'.$desc,20,$data );
        } 
        $data = unserialize($data);
//        $logs = DB::getQueryLog();
//        dump($logs);
        $query = request()->all();
       // dd($query);
        if(request()->ajax()){
            return view('admin.brand.ajaxindex',['data'=>$data,'query'=>$query]);
        }
        return view('admin.brand.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * 文件上传第一步：封装文件上传方法
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     * 执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    //第二种
    //public function store(StoreBrandPost $request)
    {
        
        //第一种验证
//        $validatedData = $request->validate([
//            'brand_name' => 'required|unique:brand|max:255',
//            'brand_url' => 'required', 
//        ],[
//            'brand_name.required'=>'品牌名称必填！',
//            'brand_name.unique'=>'品牌名称已存在！',
//            'brand_url.required'=>'品牌网址必填！',
//        ]);
        
        $post = $request->except(['_token']);
       
        //第三种
        $validator = Validator::make($post, [
           // 'brand_name' => 'required|unique:brand|max:255|regex:/^\w+$/',
            'brand_name' =>[
                'required',
                'unique:brand',
                'max:255',
                'regex:/^[\x{4e00}-\x{9fa5}\w]+$/u',
            ],
            'brand_url' => 'required', 
            ],[
            'brand_name.required'=>'品牌名称必填！',
            'brand_name.regex'=>'品牌名称需是中文字母数字下划线组成！',
            'brand_name.unique'=>'品牌名称已存在！',
            'brand_url.required'=>'品牌网址必填！',
        ]);
        if ($validator->fails()) {
            unset($post['brand_logo']);
            return redirect('brand/create')
                    ->with('data',$post)
                    ->withErrors($validator)
                    ->withInput();
        }
        
        //$post = $request->only(['_token','brand_name']);
        //dump($post);
       
        //文件上传
        if(request()->hasFile('brand_logo')){
            $post['brand_logo'] =uploads('brand_logo');
        }
        $post['addtime'] = time();
         //dd($post);
        //db操作
        //$res = DB::table('brand')->insert($post);
        //ORM操作
       // $res = Brand::create($post);
        $res = Brand::insert($post);
//        $brand = new Brand();
//        $brand->brand_name=$post['brand_name'];
//        $brand->brand_url=$post['brand_url'];
//        $brand->brand_logo=$post['brand_logo'];
//        $brand->brand_desc=$post['brand_desc'];
//        $res = $brand->save();
        //dd($res);
        if($res){
            return redirect('/brand');
        }
    }
    



    /**
     * Display the specified resource.
     * 详情页展示
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 编辑页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$data = DB::table('brand')->where('brand_id',$id)->first();
        $data = Brand::find($id);
        return view('admin.brand.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *执行编辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
       // $res = DB::table('brand')->where('brand_id',$id)->update($post);
        //$res = Brand::where('brand_id',$id)->update($post);
           //文件上传
        if(request()->hasFile('brand_logo')){
            $post['brand_logo'] =uploads('brand_logo');
        }
        
        $brand = Brand::find($id);
        $brand->brand_name=$post['brand_name'];
        $brand->brand_url=$post['brand_url'];
        $brand->brand_logo=$post['brand_logo'];
        $brand->brand_desc=$post['brand_desc'];
        $res = $brand->save();
        if( $res!==false){
            return redirect('/brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
       // $res = DB::table('brand')->where('brand_id',$id)->delete();
        $res = Brand::destroy($id);
        if( $res){
            if(request()->ajax()){
                echo json_encode(['code'=>'00000','msg'=>'删除成功']);die;
            }
            return redirect('/brand');
        }
    }
    
    public function checkOnly(){
        $brand_name = request()->brand_name;
        $where = [];
        if( $brand_name ){
            $where['brand_name'] = $brand_name;
        }
        
        $count = Brand::where($where)->count();
        echo intval($count);
    }
}
