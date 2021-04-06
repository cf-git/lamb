<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Building;

use CFGit\Lamb\Contracts\MenuItemContract;
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
        $this->pipeline;
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

    public function submenu($item)
    {
        $item->has_childs = false;
        if ($item->submenu) {
            $item->has_childs = true;
            $item->submenu = (new Menu($this->getName().".submenu"))
                ->append($item->submenu)
                ->addHandlers($this->handlers)
                ->get();
        }
        return $item;
    }

    public function transform(array $item)
    {
        $this->handlers[] = [$this, 'submenu'];
        return $this->pipeline
            ->through($this->handlers)
            ->send(app()->make(MenuItemContract::class, $item))
            ->via('handle')
            ->thenReturn();
    }

    public static function make($name)
    {
        return new static($name);
    }

    public function addHandlers(array $callbacks) {
        array_map([$this, 'addHandler'], $callbacks);
        return $this;
    }

    public function addHandler($callback) {
        $this->handlers[] = $callback;
        return $this;
    }
}
