<?php

namespace Vanguard\Http\Controllers\web\frontend;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class countryStateCity extends Controller
{
    public function getStates()
    {

        $states = DB::table('states')->select('*')->where('country_id', $_GET['countryId'])->get();
        if ($states) {
            return json_encode(['success' => true, 'states' => $states]);
        } else {
            return json_encode(['success' => false, 'message' => "no state found"]);
        }

    }

    public function getCities()
    {
        $cities = DB::table('cities')->select('*')->where('state_id', $_GET['stateId'])->get();
        if ($cities) {
            return json_encode(['success' => true, 'cities' => $cities]);
        } else {
            return json_encode(['success' => false, 'message' => "no state found"]);
        }
    }
}