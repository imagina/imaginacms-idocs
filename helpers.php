<?php


if (!function_exists('get_document')) {
    function get_document($options=array()){
        $document=app('Modules\Idocs\Repositories\DocumentRepository');
        $params=json_decode(json_encode(["filter"=>$options,'include'=>['user', 'categories', 'category'],'take'=>$options['take'],'skip'=>$options['skip']]));

    }
}
if (!function_exists('get_idocs_category')) {
    function get_idocs_category($options=array())
    {
        $category=app('Modules\Idocs\Repositories\CategoryRepository');
        $params=json_decode(json_encode(["filter"=>$options,'include'=>['user', 'categories', 'category'],'take'=>$options['take'],'skip'=>$options['skip']]));

    }
}