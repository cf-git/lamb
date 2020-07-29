<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Building;

/**
 * TODO: Split Tramsformer methods to preFilters, Transforms and postFilters
 */
class Generator
{
    protected $name = null;
    protected $transformers = null;
    protected $items = [];

    /**
     * Generator constructor.
     * @param $name
     * @param TransformerInterface[] $transformers
     */
    public function __construct($name, $transformers)
    {
        $this->name = $name;
        array_map(function ($i) {
            if (!is_a($i, TransformerInterface::class)) {
                throw new \ErrorException(get_class($i) . " is not " . TransformerInterface::class);
            }
        }, $transformers);
        $this->transformers = $transformers;
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
        foreach ($this->transformers as $transformer) {
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

    public static function make($name, $transformers)
    {
        return new static($name, $transformers);
    }
}
