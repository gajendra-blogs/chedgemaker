<?php

namespace Vanguard\Events\Settings;

use Vanguard\Settings;

abstract class SettingsEvent
{
    /**
     * @var Settings
     */
    protected $Settings;

    public function __construct(Settings $Settings)
    {
        $this->Settings = $Settings;
    }

    
}