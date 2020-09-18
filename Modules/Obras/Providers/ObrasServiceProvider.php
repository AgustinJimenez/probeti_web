<?php namespace Modules\Obras\Providers;

use Illuminate\Support\ServiceProvider;

class ObrasServiceProvider extends ServiceProvider
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
            'Modules\Obras\Repositories\ObrasRepository',
            function () {
                $repository = new \Modules\Obras\Repositories\Eloquent\EloquentObrasRepository(new \Modules\Obras\Entities\Obras());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Obras\Repositories\Cache\CacheObrasDecorator($repository);
            }
        );
// add bindings

    }
}
