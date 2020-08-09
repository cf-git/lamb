<?php
/**
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 20.02.2020 2020
 */

namespace CFGit\Lamb\Transformers;


use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformerInterface;

class SubmenuTransformer implements TransformerInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        $item['has_childs'] = false;
        if (!isset($item['submenu']) && isset($item['children'])) {
            $item['submenu'] = $item['children'];
        }
        if (!isset($item['submenu']) && isset($item['childs'])) {
            $item['submenu'] = $item['childs'];
        }
        if (isset($item['submenu'])) {
            if (empty($item['submenu'])) {
                unset($item['submenu']);
            } else {
                $item['has_childs'] = true;
                foreach ($item['submenu'] as &$child) {
                    $generator->transform($child);
                }
            }
        }
        return $item;
    }
}
