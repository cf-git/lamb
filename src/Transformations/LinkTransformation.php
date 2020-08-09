<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Transformations;


use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformationClassInterface;

class LinkTransformation implements TransformationClassInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        if (isset($item['header'])) return $item;

        if (!isset($item['type']) || $item['type'] === 'link') {
            if (isset($item['route'])) {
                if (!isset($item['route_args'])) {
                    $item['route_args'] = [];
                }
                $item['url'] = route($item['route'], $item['route_args']);
                return $item;
            }
            if (isset($item['href'])) {
                $item['url'] = $item['href'];
                return  $item;
            }
            if (!isset($item['url'])) {
                $item['url'] = "#";
                return  $item;
            }
        }
    }
}
