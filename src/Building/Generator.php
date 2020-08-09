<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Building;

class Generator
{
    protected $name = null;
    protected $Transformations = null;
    protected $items = [];

    /**
     * Generator constructor.
     * @param $name
     * @param TransformationClassInterface[] $Transformations
     */
    public function __construct($name, $Transformations)
    {
        $this->name = $name;
        array_map(function ($i) {
            if (!is_a($i, TransformationClassInterface::class)) {
                throw new \ErrorException(get_class($i) . " is not " . TransformationClassInterface::class);
            }
        }, $Transformations);
        $this->Transformations = $Transformations;
    }

    public function get()
    {
        return $this->items;
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
        return $this->build($item);
    }

    public function transform(&$item)
    {
        foreach ($this->Transformations as $transformer) {
            $transformer->transform($item, $this);
        }
    }

    protected function build($item)
    {
        $this->transform($item);
        if ($item) {
            $this->items[] = $item;
        }
        return $this;
    }

    public static function make($name, $Transformations)
    {
        return new static($name, $Transformations);
    }
}
