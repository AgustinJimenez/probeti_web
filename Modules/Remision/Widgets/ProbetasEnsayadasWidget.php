<?php namespace Modules\Remision\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class ProbetasEnsayadasWidget extends BaseWidget
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
        return 'ProbetasEnsayadasWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'remision::admin.widgets.widget-probetas-ensayadas';
    }
    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        $probetas = \RemisionDetalle::get()->filter(function($probeta)
                                        {
                                            return ($probeta->resistencia && $probeta->resistencia > 0);
                                        });
        $cantidad_probetas = $probetas->count();

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
            'x' => '4',
        ];
        
        
    }
}