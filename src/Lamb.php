<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license MIT
 * 05.02.2020 2020
 */

namespace CFGit\Lamb;


use CFGit\Lamb\Building\Generator;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class Lamb
 * @package CFGit\Lamb
 *
 * @property Container app
 * @property Repository config
 * @property Generator[] store
 */
class Lamb
{
    protected $app;
    protected $config;
    protected $store = [];

    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->config = $app['config'];
    }

    protected function trigger($event, Generator $generator)
    {
        $dispatch = "fire";
        if (method_exists($this->app->get('events'), "dispatch")) {
            $dispatch = "dispatch";
        }
        $this->app->get('events')->{$dispatch}($event, $generator);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function menu($name = "main")
    {
        $menu = "lamb.{$name}";
        if (!isset($this->store[$menu])) {
            $generator = Generator::make(
                $menu,
                array_map([$this->app, 'make'], $this->config->get("{$menu}.transformers"))
            );
            $this->trigger("lamb.menu.{$name}.before", $generator);

            $generator->append($this->config->get("{$menu}.menu"));

            $this->trigger("lamb.menu.{$name}", $generator);

            $this->trigger("lamb.menu", $generator);

            $this->trigger("lamb.menu.{$name}.after", $generator);
            $this->store[$menu] = $generator;
        }
        return $this->store[$menu]->get();
    }
}
