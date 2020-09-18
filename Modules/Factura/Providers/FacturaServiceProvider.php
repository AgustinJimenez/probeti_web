<?php namespace Modules\Factura\Providers;

use Illuminate\Support\ServiceProvider;

class FacturaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Factura\Repositories\FacturaRepository',
            function () {
                $repository = new \Modules\Factura\Repositories\Eloquent\EloquentFacturaRepository(new \Modules\Factura\Entities\Factura());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Factura\Repositories\Cache\CacheFacturaDecorator($repository);
            }
        );
// add bindings

    }
}
