<?php

namespace Vanguard\Support\Plugins\Dashboard\Widgets;

use Vanguard\Plugins\Widget;
use Vanguard\Repositories\User\UserRepository;
use DB;

class TotalAmountPaid extends Widget
{
    /**
     * {@inheritdoc}
     */
    public $width = '3';

    /**
     * {@inheritdoc}
     */
    protected $permissions = 'users.manage';

    
    public function render()
    {
        return view('plugins.dashboard.widgets.registrations', [
            'count' => DB::table('user_registrations')->sum('amount_paid'),
            'heading' => 'Total Amount Paid',
            'icon' => 'fa-money',
        ]);
    }
}
