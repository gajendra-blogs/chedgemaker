<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Students extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Students'))
            ->route('students.index')
            ->icon('fa fa-graduation-cap')
            ->active("students*")
            ->permissions('students.manage');
    }
}
