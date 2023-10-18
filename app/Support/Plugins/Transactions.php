<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Transactions extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Transactions'))
            ->route('alltransactions')
            ->icon('fa fa-exchange')
            ->active("alltransactions*")
            ->permissions('alltransactions.manage');
    }
}
