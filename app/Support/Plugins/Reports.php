<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class Reports extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Reports'))
            ->route('reports.index')
            ->icon('fas fa-wallet')
            ->active("reports*")
            ->permissions(['reports.manage']);
    }
}