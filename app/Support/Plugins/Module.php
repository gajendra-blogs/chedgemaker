<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Module extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Module'))
            ->route('module.index')
            ->icon('fa fa-tasks')
            ->permissions('module.manage');
    }
}
