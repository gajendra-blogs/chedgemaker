<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class Batches extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Assign Course To Center'))
            ->route('batches.index')
            ->icon('fa fa-tasks')
            ->active("batches*")
            ->permissions('assign.course');
    }
}
