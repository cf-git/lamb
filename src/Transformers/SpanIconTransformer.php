<?php
/**
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 20.02.2020 2020
 */
namespace CFGit\Lamb\Transformers;

use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformerInterface;

class SpanIconTransformer implements TransformerInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        $item['icon'] = isset($item['icon']) ? "<span class=\"icon icon-{$item['icon']}\"></span> " : "";
        return $item;
    }
}
