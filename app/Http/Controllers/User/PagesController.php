<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function nearByDrivers(Request $request){
        $drivers = User::nearbyDrivers($request->latitude, $request->longitude, 2000)->get()->each->append('last_seen');
        return view('users.pages.drivers',compact('drivers'));
    }
}
