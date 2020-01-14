<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="{{url('/login')}}" method="post">
            @csrf
            {{csrf_field()}}
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="text" name="name">
            <input type="password" name="password">
            <button> 提交</button>
        </form>
    </body>
</html>
