<?php
use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/api'], function (Router $router) {
    $router->post('remisions/probetas/search', [
        'as' => 'admin.remision.remision.probeta.search',
        'uses' => 'Admin\RemisionController@probetaSearch',
    ]);
});