<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        //全局辅助函数
//        //session 存
//        session(['name'=>'zhangsan']);
//        request()->session()->save();
//        //session 取
//        $name = session('name');
//        //dd($name);
//        //session 删除
//        // session(['name'=>null]);
//         
//         //request()实例
//        //存储
//         request()->session()->put('age',18);
//         request()->session()->save();
//         
//         $age = request()->session()->get('age');
//         //删除单个
//          request()->session()->forget('age');
//         request()->session()->flush();
//         //删除所有
//         $all = request()->session()->all();
//         dd($all);
         
         
        $data = Category::get();
        //无限极分类
        $data = createTree( $data );
         return view('admin.cate.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::get();
        //无限极分类
        $data = createTree( $data );
       // dd($data);
        return view('admin.cate.create',['data'=>$data]);
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
        $res = Category::create($post);
        if( $res ){
            return redirect('/cate');
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
        //
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
}
