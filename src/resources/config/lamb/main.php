<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 05.02.2020 2020
 */

use CFGit\Lamb\Transformations\LinkTransformation;
use CFGit\Lamb\Transformations\SubmenuTransformation;

return [
    'transformations' => [
        LinkTransformation::class,
        SubmenuTransformation::class,
    ],
    'menu' => [
    ],
];
