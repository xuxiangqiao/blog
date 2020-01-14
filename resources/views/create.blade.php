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
        <form action="{{url('/store')}}" method="post">
          @csrf
            <input type="text" name="name">
            <input type="password" name="password">
            <button> 提交</button>
        </form>
    </body>
</html>
