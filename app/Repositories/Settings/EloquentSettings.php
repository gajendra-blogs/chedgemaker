<?php

namespace Vanguard\Repositories\Settings;

use Vanguard\Events\Settings\Created;
// use Vanguard\Events\Settings\Deleted;
use Vanguard\Events\Settings\Updated;
use Vanguard\Settings;

class EloquentSettings implements SettingsRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Settings::all();
    }

    

    

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        
        $Settings = Settings::create($data);
        
        event(new Created($Settings));

        return $Settings;
    }

    public function truncate()
    {
        $result= Settings::truncate();
        
        return $result;
    }

    
}

    