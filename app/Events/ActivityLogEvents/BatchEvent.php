<?php

namespace Vanguard\Events\ActivityLogEvents;

use Vanguard\Models\Batch;
class BatchEvent {
    public function __construct($message)
    {
        $this->message = $message ;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

