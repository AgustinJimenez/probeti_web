<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/factura'], function (Router $router) {
    $router->bind('factura', function ($id) {
        return app('Modules\Factura\Repositories\FacturaRepository')->find($id);
    });
    $router->get('facturas', [
        'as' => 'admin.factura.factura.index',
        'uses' => 'FacturaController@index',
        'middleware' => 'can:factura.facturas.index'
    ]);

    $router->post('facturas/indexAjax', [
        'as' => 'admin.factura.factura.indexAjax',
        'uses' => 'FacturaController@indexAjax',
        'middleware' => 'can:factura.facturas.indexAjax'
    ]);

    $router->get('facturas/create', [
        'as' => 'admin.factura.factura.create',
        'uses' => 'FacturaController@create',
        'middleware' => 'can:factura.facturas.create'
    ]);
    $router->get('facturas/index_excel', 
    [
        'as' => 'admin.factura.factura.index_excel',
        'uses' => 'FacturaController@index_excel',
        'middleware' => 'can:factura.facturas.index_excel'
    ]);
    
    $router->post('facturas', [
        'as' => 'admin.factura.factura.store',
        'uses' => 'FacturaController@store',
        'middleware' => 'can:factura.facturas.store'
    ]);
    $router->get('facturas/{factura}/edit', [
        'as' => 'admin.factura.factura.edit',
        'uses' => 'FacturaController@edit',
        'middleware' => 'can:factura.facturas.edit'
    ]);
    $router->put('facturas/{factura}', [
        'as' => 'admin.factura.factura.update',
        'uses' => 'FacturaController@update',
        'middleware' => 'can:factura.facturas.update'
    ]);
    $router->put('facturas/update_from_show/{factura}', [
        'as' => 'admin.factura.factura.update_from_show',
        'uses' => 'FacturaController@update_from_show',
        'middleware' => 'can:factura.facturas.update_from_show'
    ]);
    
    $router->delete('facturas/{factura}', [
        'as' => 'admin.factura.factura.destroy',
        'uses' => 'FacturaController@destroy',
        'middleware' => 'can:factura.facturas.destroy'
    ]);

    $router->get('facturas/impresion/{factura}', [
        'as' => 'admin.factura.factura.invoice',
        'uses' => 'FacturaController@printFactura',
        'middleware' => 'can:factura.facturas.printFactura'
    ]);
    $router->get('facturas/editarNroFactura', [
        'as' => 'admin.factura.factura.editNroFactura',
        'uses' => 'FacturaController@editNroFactura',
        'middleware' => 'can:factura.facturas.editNroFactura'
    ]);
    $router->post('facturas/NroFactura', [
        'as' => 'admin.factura.factura.updateNroFactura',
        'uses' => 'FacturaController@updateNroFactura',
        'middleware' => 'can:factura.facturas.updateNroFactura'
    ]);
    $router->get('facturas/seleccionar_remisiones', [
        'as' => 'admin.factura.factura.index_seleccionar_remisiones_a_facturar',
        'uses' => 'FacturaController@index_seleccionar_remisiones_a_facturar',
        'middleware' => 'can:factura.facturas.index_seleccionar_remisiones_a_facturar'
    ]);
    

});
