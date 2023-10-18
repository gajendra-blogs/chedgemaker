<?php

namespace Vanguard\Events\ActivityLogEvents;

use Vanguard\Models\Center;
class Created {
    public function __construct($message)
    {
        $this->message = $message ;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

