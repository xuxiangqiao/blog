<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function test(){
        $name = "吴晓东";
        return view('hello',['name'=>$name]);
    }
    public function login(){
         $post = request()->all();
          dump($post);
        return view('login');
    }
    
    public function dologin(){
        $post = request()->all();
        
        dd($post);
    }
    public function goods($goods_id){
        echo 'Id是：'.$goods_id;
    }
    public function getgoods($goods_id,$goods_name=''){
        echo 'Id是：'.$goods_id;
        echo '名称是：'.$goods_name;
    }
    
}
