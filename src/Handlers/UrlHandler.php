<?php


namespace CFGit\Lamb\Handlers;


use CFGit\Lamb\Contracts\MenuItemContract;
use CFGit\Lamb\Contracts\PipeInterface;

class UrlHandler implements PipeInterface
{

    public function handle(MenuItemContract $item, \Closure $next)
    {
        if (!is_null($item->href)) {
            $item->url = $item->href;
        }
        if (!is_null($item->route)) {
            $item->url = call_user_func_array(
                'route',
                is_array($item->route) ? $item->route : [$item->route]
            );
        }
        return $next($item);
    }
}
