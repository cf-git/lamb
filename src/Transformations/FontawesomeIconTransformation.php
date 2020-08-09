<?php

namespace CFGit\Lamb\Transformations;


use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformationClassInterface;

class FontawesomeIconTransformation implements TransformationClassInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        if (isset($item['fa-icon'])) {
            $item['icon'] = "<i class=\"fa fa-{$item['fa-icon']}\"></i>";
        }
        return $item;
    }
}