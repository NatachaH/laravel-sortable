<?php
namespace Nh\Sortable;

use Illuminate\Support\ServiceProvider;

class SortableServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // COMMANDES
        if ($this->app->runningInConsole())
        {
            $this->commands([
                \Nh\Sortable\Commands\AddSortableCommand::class
            ]);
        }

        // ROUTES
        $this->loadRoutesFrom(__DIR__ . '/../routes/sortable.php');

        // TRANSLATIONS
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'sortable');

    }
}
