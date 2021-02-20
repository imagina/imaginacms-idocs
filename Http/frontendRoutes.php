<?php

use Illuminate\Routing\Router;
/** @var Router $router */



$router->group(['prefix' => LaravelLocalization::setLocale(),
  'middleware' => ['localize']], function (Router $router) {
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get(trans('idocs::routes.documents.index.publicDocuments'), [
        'as' => $locale.'.idocs.index.public',
        'uses' => 'PublicController@index',
    ]);
    
    $router->get(trans('idocs::routes.documents.index.privateDocuments'), [
        'as' => $locale.'.idocs.index.private',
        'uses' => 'PublicController@indexPrivate',
        'middleware' => 'logged.in'
    ]);

    $router->get(trans('idocs::routes.documents.show.document'), [
        'as' =>  $locale.'.idocs.show.document',
        'uses' => 'PublicController@show',
        'middleware' => 'logged.in'
    ]);
    $router->get(trans('idocs::routes.documents.show.documentByKey'), [
        'as' =>  $locale.'.idocs.show.documentByKey',
        'uses' => 'PublicController@showByKey'
    ]);
    
});
