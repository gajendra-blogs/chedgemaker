<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ErrorLog extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Logs'))
            ->route('log.show')
            ->icon('fa-solid fa-bug')
            ->active("log*")
            ->permissions('manage.error.log');
    }
}