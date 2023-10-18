<?php

namespace Vanguard\Providers;

use Vanguard\Plugins\VanguardServiceProvider as BaseVanguardServiceProvider;
use Vanguard\Support\Plugins\Dashboard\Widgets\BannedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\LatestRegistrations;
use Vanguard\Support\Plugins\Dashboard\Widgets\NewUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\RegistrationHistory;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UnconfirmedUsers;
use Vanguard\Support\Plugins\Dashboard\Widgets\UserActions;
use \Vanguard\UserActivity\Widgets\ActivityWidget;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalRegistrations;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalBookedRegistration;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalFeeAmount;
use Vanguard\Support\Plugins\Dashboard\Widgets\TotalAmountPaid;

class VanguardServiceProvider extends BaseVanguardServiceProvider
{
    /**
     * List of registered plugins.
     *
     * @return array
     */
    protected function plugins()
    {
        return [
                \Vanguard\Support\Plugins\Dashboard\Dashboard::class,
                \Vanguard\Support\Plugins\Users::class,
                \Vanguard\UserActivity\UserActivity::class,
                \Vanguard\Support\Plugins\RolesAndPermissions::class,
                \Vanguard\Support\Plugins\Centers::class,
                \Vanguard\Support\Plugins\FeeManage::class,
                \Vanguard\Support\Plugins\Courses::class,
                \Vanguard\Support\Plugins\ErrorLog::class,
                \Vanguard\Support\Plugins\Students::class,
                \Vanguard\Support\Plugins\UserRegistration::class,
                \Vanguard\Support\Plugins\Transactions::class,
                \Vanguard\Support\Plugins\Module::class,
                \Vanguard\Support\Plugins\Batches::class,
                \Vanguard\Support\Plugins\Settings::class,
                \Vanguard\Announcements\Announcements::class,
        ];
    }

    /**
     * Dashboard widgets.
     *
     * @return array
     */
    protected function widgets()
    {
        return [
            UserActions::class,
            TotalUsers::class,
            NewUsers::class,
            BannedUsers::class,
            UnconfirmedUsers::class,
            TotalRegistrations::class,
            TotalBookedRegistration::class,
            TotalAmountPaid::class,
            TotalFeeAmount::class,
            RegistrationHistory::class,
            LatestRegistrations::class,
            ActivityWidget::class,
        ];
    }
}