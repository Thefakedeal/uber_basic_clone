<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'mobile' =>'nullable|digits:10',
            'rate' => 'numeric|required|min:0'
        ]);
        $user = $request->user();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->rate = $request->rate;
        $user->update();
        return redirect()->back()->with('message','Profile Updated');
    }
}
