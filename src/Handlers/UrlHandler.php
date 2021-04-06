<?php


namespace CFGit\Lamb\Handlers;


use CFGit\Lamb\Contracts\MenuItemContract;
use CFGit\Lamb\Contracts\PipeInterface;

class UrlHandler implements PipeInterface
{

    public function handler(MenuItemContract $item, \Closure $next)
    {
        if (isset($item->href)) {
            $item->url = $item->href;
        }
        if (isset($item->route)) {
            $item->url = call_user_func(
                'route',
                is_array($item->route) ? $item->route : [$item->route]
            );
        }
        return $next($item);
    }
}
