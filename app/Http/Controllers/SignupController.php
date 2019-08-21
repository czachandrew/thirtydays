<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Log;

class SignupController extends Controller
{
    //

	public function signup(Request $request){
		Log::info($request->all());
		$user = User::create($request->all());
		return $user;
	}
}
