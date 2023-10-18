<?php

namespace Vanguard\Support\Plugins\Dashboard\Widgets;

use Vanguard\Plugins\Widget;
use Vanguard\Repositories\User\UserRepository;
use DB;

class TotalBookedRegistration extends Widget
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
            'count' => DB::table('user_registrations')->where('registration_status','booked')->count(),
            'heading' => 'Total Booking',
            'icon' => 'fa-book',
        ]);
    }
}
