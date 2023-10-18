<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;

class LoggingController extends Controller
{
    public function show()
    {
        $file =  \File::get(storage_path('logs/laravel-'. now()->format('Y-m-d') .'.log'));
        return view('logs.index' , compact('file'));
    }
}
