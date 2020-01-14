<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Goods;
use App\Mail\sendCode;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    public function send(){
        Mail::to('1309755315@qq.com')->send(new sendCode());
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = config('app.pageSize');
        
        $data = Goods::select('goods.*','brand.brand_name','category.cate_name')
                ->leftjoin('brand','goods.brand_id','=','brand.brand_id')
                ->leftjoin('category','goods.cate_id','=','category.cate_id')
                ->orderBy('goods_id','desc')
                ->paginate($pageSize);
        foreach( $data as $v){
            if($v->goods_imgs){
                $v->goods_imgs = explode('|', $v->goods_imgs);
            }
        }
       // dd($data);
        return view('admin.goods.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取品牌数据
        $brand = Brand::get();
      //  dd($brand);
        //获取分类数据
        $category = Category::get();
        $category = createTree($category);
        //dd($category);
        return view('admin.goods.create',['brand'=>$brand,'category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
       // dd($post);
        //单个文件上传
         if(request()->hasFile('goods_img')){
            $post['goods_img'] =uploads('goods_img');
        }
        //多文件文件
        if( isset($post['goods_imgs'] )){
           $post['goods_imgs'] = moreuploads('goods_imgs');
           $post['goods_imgs'] = implode('|', $post['goods_imgs']);
        }
        $post['add_time'] = time();
        $post['update_time'] = time();
        $res = Goods::insert($post);
        if(  $res ){
            return redirect('/goods');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //访问量
        $res = Redis::setnx('show_'.$id,1);//之前没有访问过 初始化1
        if(!$res){
             Redis::incr('show_'.$id);
        }
        $current = Redis::get('show_'.$id);
        
        $goods = Goods::find($id);
        return view('admin.goods.show',['goods'=>$goods,'current'=>$current]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * 添加购物车
     */
    public function addcart()
    {
        $goods_id = request()->goods_id;
        $buy_number = 1;
       //判断用户是否登录
       if(!$this->isLogin()){
          // echo json_encode(['code'=>'00001','msg'=>'未登录，请登录']);die;
          // 未登录存入cookie
           return $this->addCookiecart($goods_id,$buy_number);
       }
        //登录存入db
       return $this->addDBcart($goods_id,$buy_number);
        
    }
    public function addCookiecart($goods_id,$buy_number){
        //求商品信息
        $goods = Goods::where('goods_id',$goods_id)->first();
        //判断库存
        if($goods->goods_number<$buy_number){
            echo json_encode(['code'=>'00002','msg'=>'库存不足']);die;
        }
        //判断之前cookie是否添加过此商品
        $data = json_decode(Cookie::get('cart'),true);
        
        if(array_key_exists('cart_'.$goods_id, $data)){
            //更新购买数量
            $data['cart_'.$goods_id]['buy_number']+=$buy_number;
            //判断库存
            if($goods->goods_number<$data['cart_'.$goods_id]['buy_number']){
                echo json_encode(['code'=>'00002','msg'=>'库存不足']);die;
            }
            return response()->json(['code' => '00000', 'msg' => '加入购物车成功'])->cookie('cart',json_encode($data),30);
        }
        //正常添加
        $data['cart_'.$goods_id] = [
            'goods_id'=>$goods_id,
            'buy_number'=>$buy_number,
            'goods_price'=>$goods->goods_price,
            'addtime'=>time(),
        ];
        return response()->json(['code' => '00000', 'msg' => '加入购物车成功'])->cookie('cart',json_encode($data),30);
        
    }
    
    
    public function addDBcart($goods_id,$buy_number){
        //求商品信息
        $goods = Goods::where('goods_id',$goods_id)->first();
         //判断库存
        if($goods->goods_number<$buy_number){
            echo json_encode(['code'=>'00002','msg'=>'库存不足']);die;
        }
        $user_id = session('admin')->admin_id;
        //判断用户是否之前购买过
        $cart = DB::table('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->first();
        if( $cart ){
            //更新购买数量
                //判断库存
           if($cart->buy_number+$buy_number>$goods->goods_number){
               echo json_encode(['code'=>'00002','msg'=>'库存不足']);die;
           }
            $res = DB::table('cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->increment('buy_number');
            if($res) {echo json_encode(['code'=>'00000','msg'=>'加入购物车成功']);die;}
        }
        //没有购买 则 正常添加数据
        $data = [
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
            'buy_number'=>1,
            'goods_price'=>$goods->goods_price,
            'addtime'=>time(),
        ];
        $res = DB::table('cart')->insert($data);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'加入购物车成功']);die;
        }
    }
    
    
    public function isLogin(){
        $user = session('admin');
        if(!$user){
            return false;
        }
        return true;
    }
    
    public function cart(){
       //判断用户是否登录 
       if(!$this->isLogin()){
          // echo json_encode(['code'=>'00001','msg'=>'未登录，请登录']);die;
          // 未登录cookie取值
           $data = Cookie::get('cart');
           $data = json_decode($data,true);
          
       }else{ 
           //登录DB取值
           $data =  DB::table('cart')->get()->toArray();
           $data = json_encode($data);
           $data = json_decode($data,true);
       }
        //根据商品id获取商品名称
       foreach( $data as $k=>$v){
           $data[$k]['goods_name'] = Goods::where('goods_id',$v['goods_id'])->value('goods_name');
       }
      
       
      // dd($data);
       return view('admin.goods.cart',['data'=>$data]);
    }
    
    
}
