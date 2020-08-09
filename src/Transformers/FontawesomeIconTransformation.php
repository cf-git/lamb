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
        $item['icon'] = isset($item['icon']) ? "<i class=\"fa fa-{$item['icon']}\"></i> " : "";
        return $item;
    }
}