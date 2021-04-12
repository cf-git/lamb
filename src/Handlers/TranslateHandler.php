<?php


namespace CFGit\Lamb\Handlers;


use CFGit\Lamb\Contracts\MenuItemContract;
use CFGit\Lamb\Contracts\PipeInterface;

class TranslateHandler implements PipeInterface
{

    public function handle(MenuItemContract $item, \Closure $next)
    {
        foreach (['title', 'text', 'label'] as $key) {
            if (!is_null($item->{$key})) {
                if (is_array($item->{$key})) {
                    $item->{$key} = call_user_func_array('trans', $item->{$key});
                } else {
                    $item->{$key} = trans($item->{$key});
                }
            }
        }
        return $next($item);
    }
}