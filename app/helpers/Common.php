<?php
/**
 * 无限极分类
 * @staticvar array $new_array
 * @param type $data
 * @param type $parent_id
 * @param type $level
 * @return type
 */
function createTree( $data, $parent_id=0, $level=0){
    static $new_array = [];
    if(!$data){
        return;
    }
    foreach( $data as $k=>$v){
        if($v->parent_id==$parent_id){
           
            $v->level = $level;
            $new_array[] = $v;
            createTree( $data, $v->cate_id, $level+1);
        }
    }
    return $new_array;
}


  function uploads($filename){
        if ( request()->file($filename)->isValid()) {
            $photo = request()->file($filename);
           
            $store_result = $photo->store('uploads');
            //$store_result = $photo->storeAs('photo', 'test.jpg');
            return $store_result;
         }
         exit('未获取到上传文件或上传过程出错');
    }

    
 function moreuploads($filename){
     if(!$filename ){
         return;
     }
     $imgs = request()->file($filename);
    
     $result = [];
     foreach($imgs as $v){
         $result[] = $v->store('uploads');
     }
     return $result;
 }   
    