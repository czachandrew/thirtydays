<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Log;
use Hash;

class SignupController extends Controller
{
   
	public function signup(Request $request){
		Log::info($request->all());
		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email; 
		$user->password = Hash::make($request->password);
		$user->save();
		$progression = new Progression();
		$user->progression()->save($progression);
		return $user;
	}
}
