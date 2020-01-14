<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LoginController extends Controller
{
    public function dologin(Request $request) {
        $post = $request->except('_token');
        
        $user = DB::table('admin')->where($post)->first();
        
        if( $user ){
            session(['admin'=>$user]);
            request()->session()->save();
            return redirect('/brand');
        }
        return redirect('/login')->with('msg','没有此用户！请联系管理员');
    }
    
    
    public function logout(){
        
        session(['admin'=>null]);
        request()->session()->save();
        
        return redirect('/login');
    }
}
