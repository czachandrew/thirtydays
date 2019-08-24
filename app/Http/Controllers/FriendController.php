<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Events\UserRequestedFriendship;
use App\Events\UserAcceptedFriendship;
use Log;

class FriendController extends Controller
{
    //

	public function __construct(){
		$this->middleware('auth:api');
	}
	public function get(){
		$user = Auth::user();
		$friends = $user->getFriends();
		$friendRequests = $user->getFriendRequests()->load('sender');
		return ['friends' => $friends, 'requests' => $friendRequests];
	}

	public function sendRequest(){
		$user = Auth::user();
		$friend = User::find(request('id'));
		$user->befriend($friend);
		UserRequestedFriendship::dispatch($user, $friend);
		return ['status' => 'success'];
	}

	public function qrCodeBefriend(User $friend){
		$user = Auth::user();
		//$friend = User::find($request->friendId);
		Log::info($friend); 
		// Log::info($request->friendId);
		$user->befriend($friend); 
		$friend->acceptFriendRequest($user);
		UserAcceptedFriendship::dispatch($friend, $user); 
		UserAcceptedFriendship::dispatch($user, $friend);
		return ['status' => 'success'];
	}

	public function acceptRequest(User $sender){
		$user = Auth::user();
		$user->acceptFriendRequest($sender);
		UserAcceptedFriendship::dispatch($sender, $user);
		return ['status' => 'success'];
	}

	public function denyRequest(User $sender){
		$user = Auth::user();
		$user->denyFriendRequest($sender);
		return ['status' => 'success'];
	}

	public function listUsers(){
		$users = User::all();
		return $users;
	}


}
