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
        $item['fa-icon'] = isset($item['fa-icon']) ? "<i class=\"fa fa-{$item['fa-icon']}\"></i> " : "";
        return $item;
    }
}