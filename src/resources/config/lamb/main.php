<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license MIT
 * 05.02.2020 2020
 */

use CFGit\Lamb\Transformers\LinkTransformer;
use CFGit\Lamb\Transformers\SubmenuTransformer;

return [
    'transformers' => [
        LinkTransformer::class,
        SubmenuTransformer::class,
    ],
    'menu' => [
    ],
];
