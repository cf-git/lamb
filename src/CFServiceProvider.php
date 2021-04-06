<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 05.02.2020 2020
 */

namespace CFGit\Lamb;


use CFGit\Lamb\Building\MenuItem;
use CFGit\Lamb\Contracts\MenuItemContract;
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

        $this->app->bind(MenuItemContract::class, function (Container $app, array $item = [], array $handlers = []) {
            return new MenuItem($item);
        });

        $this->app->singleton('lamb', function (Container $app) {
            return new Lamb($app, $app->get('config'), $app->get('events'));
        });
    }

    public function boot(Factory $view)
    {
        $view->composer('*', ViewComposer::class);
    }
}
