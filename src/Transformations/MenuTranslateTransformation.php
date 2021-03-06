<?php
namespace CFGit\Lamb\Transformations;

use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformationClassInterface;
use Illuminate\Support\Str;

/**
 * @author Shubin Sergei <is.captain.fail@gmail.com>
 * @license MIT
 * 06.08.2020 2020
 */

class MenuTranslateTransformation implements TransformationClassInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        if (!isset($item['translate_args'])) {
            $item['translate_args'] = [];
        }
        if (Str::contains($item['title'], "::")) {
            $item['title'] = trans($item['title'], $item['translate_args']);
        } else {
            $item['title'] = __($item['title'], $item['translate_args']);
        }
        return $item;
    }
}
