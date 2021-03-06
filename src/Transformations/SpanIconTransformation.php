<?php
/**
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 20.02.2020 2020
 */
namespace CFGit\Lamb\Transformations;

use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformationClassInterface;

class SpanIconTransformation implements TransformationClassInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {

        if (isset($item['span-icon'])) {
            $item['icon'] = "<span class=\"icon icon-{$item['span-icon']}\"></span>";
        }
        return $item;
    }
}
