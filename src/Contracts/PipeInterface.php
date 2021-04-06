<?php


namespace CFGit\Lamb\Contracts;


interface PipeInterface
{
    /**
     * @param array $item
     * @param \Closure $next
     * @return mixed
     */
    public function handler(MenuItemContract $item, \Closure $next);
}
