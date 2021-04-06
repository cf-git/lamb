<?php


namespace CFGit\Lamb\Contracts;


interface PipeInterface
{
    /**
     * @param array $item
     * @param \Closure $next
     * @return mixed
     */
    public function handle(MenuItemContract $item, \Closure $next);
}
