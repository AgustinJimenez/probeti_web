<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/obras'], function (Router $router) {
    $router->bind('obras', function ($id) {
        return app('Modules\Obras\Repositories\ObrasRepository')->find($id);
    });
    $router->get('obras', [
        'as' => 'admin.obras.obras.index',
        'uses' => 'ObrasController@index',
        'middleware' => 'can:obras.obras.index'
    ]);
    $router->get('obras/create', [
        'as' => 'admin.obras.obras.create',
        'uses' => 'ObrasController@create',
        'middleware' => 'can:obras.obras.create'
    ]);
    $router->post('obras', [
        'as' => 'admin.obras.obras.store',
        'uses' => 'ObrasController@store',
        'middleware' => 'can:obras.obras.store'
    ]);
    $router->get('obras/{obras}/edit', [
        'as' => 'admin.obras.obras.edit',
        'uses' => 'ObrasController@edit',
        'middleware' => 'can:obras.obras.edit'
    ]);
    $router->put('obras/{obras}', [
        'as' => 'admin.obras.obras.update',
        'uses' => 'ObrasController@update',
        'middleware' => 'can:obras.obras.update'
    ]);
    $router->delete('obras/{obras}', [
        'as' => 'admin.obras.obras.destroy',
        'uses' => 'ObrasController@destroy',
        'middleware' => 'can:obras.obras.destroy'
    ]);
// append

});
