<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Courses extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Courses'))
            ->route('course.index')
            ->icon('fa fa-book')
            ->active("course*")
            ->permissions('course.manage');
    }
}
