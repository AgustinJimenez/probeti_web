<?php namespace Modules\Clientes\Providers;

use Illuminate\Support\ServiceProvider;

class ClientesServiceProvider extends ServiceProvider
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
            'Modules\Clientes\Repositories\ClientesRepository',
            function () {
                $repository = new \Modules\Clientes\Repositories\Eloquent\EloquentClientesRepository(new \Modules\Clientes\Entities\Clientes());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Clientes\Repositories\Cache\CacheClientesDecorator($repository);
            }
        );
// add bindings

    }
}
