<?php

namespace Vanguard\Repositories\Settings;

interface SettingsRepository
{
    /**
     * Create $key => $value array for all available countries.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function create(array $data);

    /**
     * Get all available countries.
     * @return mixed
     */
    public function all();

    /**
     * Get all available countries.
     * @return mixed
     */
    public function truncate();
    
}
