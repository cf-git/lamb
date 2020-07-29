<?php
/**
 * @author Shubin Sergie <is.captain.fail@gmail.com>
 * @license GNU General Public License v3.0
 * 20.02.2020 2020
 */

namespace CFGit\Lamb;


use Illuminate\View\View;

class ViewComposer
{
    /**
     * @var Lamb
     */
    private $lamb;

    public function __construct(
        Lamb $lamb
    ) {
        $this->lamb = $lamb;
    }

    public function compose(View $view)
    {
        $view->with('lamb', $this->lamb);
    }
}
