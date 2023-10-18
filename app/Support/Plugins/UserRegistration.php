<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class userRegistration extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Student Registrations'))
            ->route('userRegistrations.index')
            ->icon('fa fa-th')
            ->active("userRegistrations*")
            ->permissions('userRegistration.manage');
    }
}
