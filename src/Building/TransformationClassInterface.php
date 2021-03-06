<?php
/**
 * Module created by request special for uamade.ua
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 06.02.2020 2020
 */

namespace CFGit\Lamb\Building;


interface TransformationClassInterface
{
    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator);
}
