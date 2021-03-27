<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Events\NewUserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class UserRegisterController extends Controller
{
    public function registerUser(Request $request) {
        // return $request->all();
        $validator = $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|digits:10',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if($validator->fails())
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->street_address = $request->street;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zipcode;
        $user->county = $request->county;
        $user->password = Hash::make($request->password);
        $user->save();
        // Event::fire(new NewUserRegistered($user));
    
        return redirect('/')->with('flash_message_success','Registered Successfully!!');

    }
}
