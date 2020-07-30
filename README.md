# LAMB
## Laravel Menu Builder v1
### Intro

### Fast start
- Add package to project with ```composer require cf-git/lamb```
- Publish configuration folder ```./artisan vendor:publish --tag=lamb-config``` or ```./artisan vendor:publish --tag=config``` 
- Edit config main section in config/lamb/main.php file to be 
```php
return [
    //...
    'menu' => [
        // menu items
        [
            'title' => 'Docs',
            'href' => 'https://laravel.com/docs',
        ],
        [
            'title' => 'Laracasts',
            'href' => 'https://laracasts.com',
        ],
        //...
        [
            'title' => 'GitHub',
            'href' => 'https://github.com/laravel/laravel',
        ],
    ],
];
``` 
- Then reset config cache ```./artisan config:cache```
- Then you can output your menu in templates, like in welcome.blade.php
```blade
    <div class="links">
        @foreach($lamb->menu('main') as $item)
            <a href="{{ $item['href'] }}">{{ $item['title'] }}</a>
        @endforeach
    </div>
```

### Add new menu type
You can make any menus as you need with making config file in config/lamb directory with same structure.
For example, we can make profile menu for user with custom menu parameters
```php
<?php
// config/lamb/profile.php
use CFGit\Lamb\Transformers\LinkTransformer;
use CFGit\Lamb\Transformers\SubmenuTransformer;
return [
    'transformers' => [
        LinkTransformer::class,
        SubmenuTransformer::class,
        // ... you can append Transformer of menu
    ],
    'menu' => [
        [
            'title' => 'Messages',
            'icon' => 'envelope',
            'href' => 'http://localhost/en/messages',
        ],
        [
            'title' => 'My Profile',
            'icon' => 'user',
            'submenu' => [
                [
                    'title' => 'Profile Info',
                    'icon' => 'key',
                    'href' => 'http://localhost/en/profile/edit',
                ],
                [
                    'title' => 'Change Password',
                    'icon' => 'key',
                    'href' => 'http://localhost/en/profile/password',
                ],
                [
                    'title' => 'Customization',
                    'icon' => 'cogs',
                    'href' => 'http://localhost/en/profile/settings',
                ],
                [
                    'title' => 'Logout',
                    'icon' => 'exit',
                    'href' => 'http://localhost/fast-logout-link'
                ],
            ]
        ],
    ],
];
```  

Then we can call new menu in templates like
```blade
<ul class="menu">
    @each('menu.item', $lamb->menu('profile'), 'item')
</ul>
```
and
```blade
{{-- menu.item --}}
<li>
    <a href="{{ $item['href'] }}"><span class="icon icon-{{ $item['icon'] }}"></span> {{ $item['title'] }}</a>
    @if($item['has_childs'])
        <ul>
            @each('menu.item', $item['submenu'], 'item')
        </ul>
    @endif
</li> 
```

### Make transformation rules
For more flexibility You can make your custom Transformation class
For example we can make Transformation for icons of profile menu
```php
<?php
/**
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 20.02.2020 2020
 */

namespace App\MenuItemTransformations;


use CFGit\Lamb\Building\Generator;
use CFGit\Lamb\Building\TransformerInterface;

class IconTransformer implements TransformerInterface
{

    /**
     * @param array|mixed &$item
     * @param Generator $generator
     * @return array|mixed|bool
     */
    public function transform(&$item, Generator $generator)
    {
        $item['icon'] = isset($item['icon']) ? "<span class=\"icon icon-{$item['icon']}\"></span> " : ""; 
        return $item;
    }
}
```
Then we can print in template like.
```blade
{{-- menu.item --}}
{{-- ... --}}
<a href="{{ $item['href'] }}">{!! $item['icon'] !!}{{ $item['title'] }}</a>
{{-- ... --}}
```
But, before need append new Transformation class to menu configuration in 'transformers' section,
And, don't forget to reset the cache ```./artisan config:cache```


### Dynamic menu filling
Some times we needs store menu structure in database or bind to some unstable services.
We can build menu dynamically at call moment. For this we can use AppServiceProvider or specify custom service provider for build it.
```php
<?php
namespace App\Providers;

use CFGit\Lamb\Building\Generator;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    //...
    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen("lamb.menu.profile.before", function (Generator $generator) {
            $headers = get_headers('http://localhost/api/status');
            if (strpos($headers[0], '200') === false) return;
            $generator->append([
                [
                    'title' => 'Api Service',
                    'submenu' => [
                        [
                            'title' => 'Api key settings',
                            'href' => 'http://localhost/api-service/settings',
                        ],
                        [
                            'title' => 'Api Logs',
                            'href' => 'http://localhost/api-service/loglist',
                        ],
                    ],
                ],
            ]);
        });
    }   
}
```

So if our service available, we append menu item before profile menu.
We can use event menu to any menu with "lamb.menu" event then check menu name with ```$generator->getName();``` 

## Licenses
GNU GPL v3
