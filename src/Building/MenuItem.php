<?php


namespace CFGit\Lamb\Building;


use CFGit\Lamb\Contracts\MenuItemContract;
use Illuminate\Support\Traits\Macroable;

class MenuItem implements MenuItemContract
{
    use Macroable;

    protected $item = null;

    public function __construct(array $item)
    {
        $this->item = $item;
    }

    public function __get($key)
    {
        if (isset($this->item[$key])) {
            return $this->item[$key];
        }
        return null;
    }

    public function __set($key, $value)
    {
        $this->item[$key] = $value;
    }
}
