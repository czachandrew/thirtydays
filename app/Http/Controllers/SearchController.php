<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Log;
use App\User;

class SearchController extends Controller
{
    //
	public function __construct(){
		$this->middleware('auth:api');
	}

	public function searchUsers(Request $request){
		Log::info($request->term);
		//return $request->all();
		if($request->has('term')) {
			$users = User::where('name','like','%'. $request->term . '%')->get();
			Log::info($users);
			return $users;
		} else {
			return ['error' => 'missing the term'];
		}
	}
}
