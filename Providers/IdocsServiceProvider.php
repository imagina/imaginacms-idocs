<?php

namespace Modules\Idocs\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Idocs\Events\Handlers\RegisterIdocsSidebar;

class IdocsServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIdocsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', array_dot(trans('idocs::categories')));
            $event->load('documents', array_dot(trans('idocs::documents')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('idocs', 'permissions');
        $this->publishConfig('idocs', 'config');
        $this->publishConfig('idocs', 'settings');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
            'Modules\Idocs\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Idocs\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Idocs\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idocs\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Idocs\Repositories\DocumentRepository',
            function () {
                $repository = new \Modules\Idocs\Repositories\Eloquent\EloquentDocumentRepository(new \Modules\Idocs\Entities\Document());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Idocs\Repositories\Cache\CacheDocumentDecorator($repository);
            }
        );
// add bindings


    }
}
