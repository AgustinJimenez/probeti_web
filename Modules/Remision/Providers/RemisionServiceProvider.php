<?php namespace Modules\Remision\Providers;

use Illuminate\Support\ServiceProvider;

class RemisionServiceProvider extends ServiceProvider
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
            'Modules\Remision\Repositories\RemisionRepository',
            function () {
                $repository = new \Modules\Remision\Repositories\Eloquent\EloquentRemisionRepository(new \Modules\Remision\Entities\Remision());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Remision\Repositories\Cache\CacheRemisionDecorator($repository);
            }
        );
// add bindings

    }
}
