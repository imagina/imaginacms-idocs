<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/documents'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    $router->get('/', [
        'as' => $locale.'.idocs.index',
        'uses' => 'PublicController@index',
        //'middleware' => 'can:idocs.categories.index'
    ]);
    $router->get('search', [
        'as' =>  'idocs.document.search',
        'uses' => 'PublicController@search'
    ]);
    $router->get('{categorySlug}', [
        'as' =>  $locale.'.idocs.category',
        'uses' => 'PublicController@index'
    ]);

    $router->get('{categorySlug}/{slug}', [
        'as' =>  $locale.'.idocs.document',
        'uses' => 'PublicController@show'
    ]);

    
});
