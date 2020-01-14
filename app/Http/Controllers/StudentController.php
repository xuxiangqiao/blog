<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function lists(){
        echo "学生列表";
    }
    
    public function create(){
        return view('create');
    }
    
   public function store(){
       $post = request()->all();
       dd($post);
    }
}
