<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Centers extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Centers'))
            ->route('center.index')
            ->icon('fa fa-university')
            ->active("center*")
            ->permissions('centers.manage');
    }
}
