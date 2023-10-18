<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;
use Vanguard\User;

class FeeManage extends Plugin
{
    public function sidebar()
    {
        $feehead = Item::create(__('Fee Heads'))
            ->route('feehead.index')
            ->active("feehead*")
            ->permissions('feeHead.manage');

        $feeplan = Item::create(__('Fee Plan'))
            ->route('feePlan.index')
            ->active("feemanage/auth")
            ->permissions('feeplan.manage');

        $feeplandetail = Item::create(__('Fee Plan Details'))
            ->route('feemanagement.index')
            ->active("feemanage*")
            ->permissions(function (User $user) {
                return $user->hasPermission('feeplan.manage');
            });

        return Item::create(__('Fee Management'))
            ->href('#feedetails-dropdown')
            ->icon('fas fa-wallet')
            ->permissions(['feeHead.manage','feeplan.manage'])
            ->addChildren([
                $feehead,
                $feeplandetail,
            ]);
    }
}
