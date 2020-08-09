<?php


namespace CFGit\Lamb\Transformers;


use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformerInterface;

class FontawesomeIconTransformer implements TransformerInterface
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
