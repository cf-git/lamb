<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Building;

use Illuminate\Pipeline\Pipeline;

class Menu
{
    protected $name = null;
    protected $menu = null;
    protected $items = [];
    protected $pipeline = null;
    protected $handlers = [];

    /**
     * Generator constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->pipeline = new Pipeline(app());
    }

    public function get()
    {
        if (is_null($this->menu)) {
            $this->menu = array_map([$this, 'transform'], $this->items);
        }
        return $this->menu;
    }

    public function getName()
    {
        return $this->name;
    }

    public function append($items = [])
    {
        if (func_num_args() < 2) {
            $items = [$items];
        }
        foreach ($items as $list) {
            array_map([$this, 'add'], $list);
        }
        return $this;
    }

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function transform($item)
    {
        return $this->pipeline
            ->through($this->handlers)
            ->send($item)
            ->then(function ($item) {
                return app()->makeWith(\CFGit\Lamb\Contracts\MenuItemContract::class, $item);
            });
    }

    public static function make($name)
    {
        return new static($name);
    }

    public function addHandler(callable $callback) {
        $this->handlers[] = $callback;
    }
}
