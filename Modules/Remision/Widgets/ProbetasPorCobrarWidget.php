<?php namespace Modules\Remision\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class ProbetasPorCobrarWidget extends BaseWidget
{
	/**
     * @var CategoryRepository
     */
    

    public function __construct()
    {
        
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'ProbetasPorCobrarWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'remision::admin.widgets.widget-probetas-por-cobrar';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        $detalles_factura = \FacturaDetalle::with(['factura' => function($query_factura)
                                {
                                    $query_factura->where('anulado', false);
                                }])
                                ->get()
                                ->filter(function($detalle)
                                    {
                                        if($detalle->factura)
                                            return true;
                                    });
        $probetas = \RemisionDetalle::get();

        $cantidad_total_probetas = $probetas->count();


        $cantidad_probetas_chicas = $probetas->filter(function($probeta)
                                                    {
                                                        return $probeta->size_clasification == "Chica";
                                                    })->count();
        $cantidad_probetas_medianas = $probetas->filter(function($probeta)
                                                    {
                                                        return $probeta->size_clasification == "Mediana";
                                                    })->count();
        $cantidad_probetas_grandes = $probetas->filter(function($probeta)
                                                    {
                                                        return $probeta->size_clasification == "Grande";
                                                    })->count();



        $cantidad_probetas = $cantidad_total_probetas - $detalles_factura->sum('cantidad');

        $cantidad_probetas_chicas = $cantidad_probetas_chicas - $detalles_factura->filter(function($detalle)
                                                                                    {
                                                                                        return $detalle->probeta_tipo == "chica";
                                                                                    })->sum('cantidad');

        $cantidad_probetas_medianas = $cantidad_probetas_medianas - $detalles_factura->filter(function($detalle)
                                                                                    {
                                                                                        return $detalle->probeta_tipo == "mediana";
                                                                                    })->sum('cantidad');

        $cantidad_probetas_grandes = $cantidad_probetas_grandes - $detalles_factura->filter(function($detalle)
                                                                                    {
                                                                                        return $detalle->probeta_tipo == "grande";
                                                                                    })->sum('cantidad');

        return [
        		'cantidad_probetas' => $cantidad_probetas,
                'cantidad_probetas_chicas' => $cantidad_probetas_chicas,
                "cantidad_probetas_medianas" => $cantidad_probetas_medianas,
                "cantidad_probetas_grandes" => $cantidad_probetas_grandes
        		];
    }

    /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {

        return [
            'width' => '4',
            'height' => '1',
            'x' => '2',
            "y" => "4"
        ];
    }
}