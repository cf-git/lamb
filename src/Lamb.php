<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 05.02.2020 2020
 */

namespace CFGit\Lamb;


use CFGit\Lamb\Building\Menu;
use CFGit\Lamb\Handlers\TranslateHandler;
use CFGit\Lamb\Handlers\UrlHandler;
use \Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;

/**
 * Class Lamb
 * @package CFGit\Lamb
 *
 * @property Container app
 * @property Dispatcher events
 * @property Repository config
 * @property Menu[] store
 */
class Lamb
{
    protected $app;
    protected $config;
    protected $events;
    protected $store = [];

    /**
     * Lamb constructor.
     * @param Container $app
     * @param Repository $config
     * @param Dispatcher $events
     */
    public function __construct(Container $app, Repository $config, Dispatcher $events)
    {
        $this->app = $app;
        $this->events = $events;
        $this->config = $config;
    }

    protected function trigger($event, ...$payload)
    {
        $dispatch = "fire";
        if (method_exists($this->app->get('events'), "dispatch")) {
            $dispatch = "dispatch";
        }
        $this->app->get('events')->{$dispatch}($event, $payload);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function menu($name = "main")
    {
        $storeKey = "lamb.{$name}";
        if (!isset($this->store[$storeKey])) {
            $menu = Menu::make($name);
            $this->trigger("lamb.menu.{$name}.before", $menu);

            $this->injectHandlers($menu);

            $this->trigger("lamb.menu.{$name}", $menu);

            $menu->append($this->config->get("{$name}.menu", []));

            $this->trigger("lamb.menu", $menu);

            $this->trigger("lamb.menu.{$name}.after", $menu);
            $this->store[$storeKey] = $menu;
        }
        $this->app->bind($name, function() use ($menu) {
            return $menu;
        });
        return $this->store[$storeKey]->get();
    }

    public function injectHandlers(Menu $menu)
    {
        $menu->addHandlers([
            UrlHandler::class,
            TranslateHandler::class,
        ]);
    }
}
