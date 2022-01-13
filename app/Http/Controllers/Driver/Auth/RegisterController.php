<?php

namespace App\Http\Controllers\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.driver.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rate' => ['required', 'numeric', 'min:0']
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rate = $request->rate;
        $user->role = User::ROLE_DRIVER;
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user, true);
        return redirect(route('driver.home'))->with('message', "Welcome," . $user->name . ". :)");
    }
}
