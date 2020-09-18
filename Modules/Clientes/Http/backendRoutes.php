<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/clientes'], function (Router $router) {
    $router->bind('clientes', function ($id) {
        return app('Modules\Clientes\Repositories\ClientesRepository')->find($id);
    });
    

    $router->get('clientes', [
        'as' => 'admin.clientes.clientes.index',
        'uses' => 'ClientesController@index',
        'middleware' => 'can:clientes.clientes.index'
    ]);

    $router->get('clientes/indexAjax', [
        'as' => 'admin.clientes.clientes.indexAjax',
        'uses' => 'ClientesController@indexAjax',
        'middleware' => 'can:clientes.clientes.indexAjax'
    ]);
    $router->get('clientes/search_cliente', [
        'as' => 'admin.clientes.clientes.search_cliente',
        'uses' => 'ClientesController@search_cliente',
        'middleware' => 'can:clientes.clientes.search_cliente'
    ]);

    $router->get('clientes/create', [
        'as' => 'admin.clientes.clientes.create',
        'uses' => 'ClientesController@create',
        'middleware' => 'can:clientes.clientes.create'
    ]);
    $router->post('clientes', [
        'as' => 'admin.clientes.clientes.store',
        'uses' => 'ClientesController@store',
        'middleware' => 'can:clientes.clientes.store'
    ]);
    $router->get('clientes/{clientes}/edit', [
        'as' => 'admin.clientes.clientes.edit',
        'uses' => 'ClientesController@edit',
        'middleware' => 'can:clientes.clientes.edit'
    ]);
    $router->put('clientes/{clientes}', [
        'as' => 'admin.clientes.clientes.update',
        'uses' => 'ClientesController@update',
        'middleware' => 'can:clientes.clientes.update'
    ]);
    $router->delete('clientes/{clientes}', [
        'as' => 'admin.clientes.clientes.destroy',
        'uses' => 'ClientesController@destroy',
        'middleware' => 'can:clientes.clientes.destroy'
    ]);
// append

});
