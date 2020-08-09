<?php
namespace App\Partials\Lamb\Transformers;

use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformerInterface;
use Illuminate\Support\Str;

/**
 * @author Shubin Sergei <is.captain.fail@gmail.com>
 * @license MIT
 * 06.08.2020 2020
 */

class MenuTranslateTransformer implements TransformerInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        if (Str::contains($item['title'], "::")) {
            $item['title'] = trans($item['title']);
        } else {
            $item['title'] = __($item['title']);
        }
        return $item;
    }
}
