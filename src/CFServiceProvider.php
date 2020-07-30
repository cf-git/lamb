<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 05.02.2020 2020
 */

namespace CFGit\Lamb;


use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class CFServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            ( __DIR__ . '/resources/config/lamb') => config_path('lamb'),
        ], ['lamb-config', 'config']);

        $this->app->singleton('lamb', function (Container $app) {
            return new Lamb($app);
        });
        parent::register();
    }

    public function boot(Factory $view)
    {
        $view->composer('*', ViewComposer::class);
    }
}
