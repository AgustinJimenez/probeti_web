<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/remision'], function (Router $router) {
    $router->bind('remision', function ($id) 
    {
        return app('Modules\Remision\Repositories\RemisionRepository')->find($id);
    });
    $router->bind('obra', function ($obra) 
    {
        return \Obra::find($obra);
    });
    $router->bind('cliente', function ($cliente) 
    {
        return \Cliente::find($cliente);
    });
    $router->get('remisions', [
        'as' => 'admin.remision.remision.index',
        'uses' => 'RemisionController@index',
        'middleware' => 'can:remision.remisions.index'
    ]);

    $router->get('remisions/indexAjax', [
        'as' => 'admin.remision.remision.indexAjax',
        'uses' => 'RemisionController@indexAjax',
        'middleware' => 'can:remision.remisions.indexAjax'
    ]);
    $router->get('remisions/search_remision', [
        'as' => 'admin.remision.remision.search_remision',
        'uses' => 'RemisionController@search_remision',
        'middleware' => 'can:remision.remisions.search_remision'
    ]);

    $router->get('remisions/create', [
        'as' => 'admin.remision.remision.create',
        'uses' => 'RemisionController@create',
        'middleware' => 'can:remision.remisions.create'
    ]);
    $router->post('remisions', [
        'as' => 'admin.remision.remision.store',
        'uses' => 'RemisionController@store',
        'middleware' => 'can:remision.remisions.store'
    ]);
    $router->get('remisions/{remision}/edit', [
        'as' => 'admin.remision.remision.edit',
        'uses' => 'RemisionController@edit',
        'middleware' => 'can:remision.remisions.edit'
    ]);
    $router->put('remisions/{remision}', [
        'as' => 'admin.remision.remision.update',
        'uses' => 'RemisionController@update',
        'middleware' => 'can:remision.remisions.update'
    ]);
    $router->delete('remisions/{remision}', [
        'as' => 'admin.remision.remision.destroy',
        'uses' => 'RemisionController@destroy',
        'middleware' => 'can:remision.remisions.destroy'
    ]);
    $router->get('remisions/{remision}/detalle', [
        'as' => 'admin.remision.remision.detalles',
        'uses' => 'RemisionController@detalles',
    ]);
    $router->get('remisions/{remision}/detalle/edit', [
        'as' => 'admin.remision.remision.detalle.edit',
        'uses' => 'RemisionController@detallesEdit',
    ]);
    $router->get('remisions/probetas/lista', [
        'as' => 'admin.remision.remision.probeta.lista',
        'uses' => 'RemisionController@probetas',
    ]);
    $router->get('remisions/probetas/{remisionDetalle}/editar', [
        'as' => 'admin.remision.remision.probeta.edit',
        'uses' => 'RemisionController@probetaEditar',
    ]);

    $router->put('remisions/probetas/update', [
        'as' => 'admin.remision.remision.probeta.update',
        'uses' => 'RemisionController@probetaUpdate',
    ]);

    $router->delete('remisions/probetas/eliminar/{detalle}', [
        'as' => 'admin.remision.remision.probeta.destroy',
        'uses' => 'RemisionController@probetaEliminar',
    ]);

    $router->get('remisions/probetas/remisiones', [
        'as' => 'admin.remision.remision.probeta.probetaVerDetalle',
        'uses' => 'RemisionController@probetaVerDetalle',
    ]);

    $router->get('remisions/probetas/editarTodas', [
    'as' => 'admin.remision.remision.probeta.probetaEditarAll',
    'uses' => 'RemisionController@probetaEditarAll',
    ]);

    $router->post('remisions/probetas/probetaUpdateAll', [
    'as' => 'admin.remision.remision.probeta.probetaUpdateAll',
    'uses' => 'RemisionController@probetaUpdateAll',
    ]);

    $router->get('remisions/crear_informe/{remision}', [
    'as' => 'admin.remision.remision.createInforme',
    'uses' => 'RemisionController@createInforme',
    ]);

    $router->get('remisions/searchProbetaInforme', [
    'as' => 'admin.remision.remision.searchProbetaInforme',
    'uses' => 'RemisionController@searchProbetaInforme',
    ]);

    $router->post('remisions/printInforme', [
    'as' => 'admin.remision.remision.printInforme',
    'uses' => 'RemisionController@printInforme',
    ]);

    $router->get('remisions/reporte/{obra}/obra/{cliente}/cliente', [
    'as' => 'admin.remision.remision.reporte_remision_obra_cliente',
    'uses' => 'RemisionController@reporte_remision_obra_cliente',
    ]);

    $router->post('remisions/reporte_remision_obra_cliente_ajax', [
    'as' => 'admin.remision.remision.reporte_remision_obra_cliente_ajax',
    'uses' => 'RemisionController@reporte_remision_obra_cliente_ajax',
    ]);

    $router->post('remisions/reporte/get_informe_caracteristicas', [
    'as' => 'admin.remision.remision.get_informe_caracteristicas',
    'uses' => 'RemisionController@get_informe_caracteristicas',
    ]);

    $router->get('remisions/probetas_status', [
    'as' => 'admin.remision.remision.probetas_status',
    'uses' => 'RemisionController@probetas_status',
    ]);
    
    $router->post('remisions/probetas_status_ajax', [
    'as' => 'admin.remision.remision.probetas_status_ajax',
    'uses' => 'RemisionController@probetas_status_ajax',
    ]);
});
