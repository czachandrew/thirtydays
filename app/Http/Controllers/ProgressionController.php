<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Progression;
use App\Reward;
use App\Krate;
use App\ExperienceEvent;
use Auth;
use Log;

class ProgressionController extends Controller
{

	public function __construct(){
		$this->middleware('auth:api')->except(['index','dashboard']);
	}
    //
	public function index(){
		//This is just to show the test progression page 
		$user = Auth::user();
		$user->load('progression','rewards','krates', 'kratespaces');
		$myKrates = $user->openableKrates;
		$myKrates = $myKrates->groupBy('krate.title'); 
		return view('progression.index', compact('user', 'myKrates'));
	}

	public function superdata(){
		$user = Auth::user();
		$user->load('progression','rewards', 'krates','kratespaces', 'kratespaces.groups', 'kratespaces.groups.tasks','usertasks', 'requests');
		$user->myKrates = $user->openableKrates->groupBy('krate.title');
		$user->rewards()->orderBy('user_reward.id', 'desc')->get();
		$friends = $user->getFriends();
		$user->friends = $friends;
		$requests = $user->getFriendRequests()->load('sender');
		$user->requests = $requests;
		return $user;
	}

	public function dashboard(){
		$user = Auth::user(); 
		$user->load('providedRewards');
		$users = User::with('progression')->get();
		$krates = Krate::all();
		return view('progression.dashboard', compact(['user','users']));
	}

	public function getProgression(){
		$user = Auth::user();
		$user->load('progression', 'rewards', 'krates');
		$user->myKrates = $user->openableKrates->groupBy('krate.title');
		$user->rewards()->orderBy('user_reward.id', 'desc')->get();
		// $sorted = $user->rewards()->available()->get();
		// $user->rewards = $sorted;
		return $user;
	}

	public function createExperienceEvent(Request $request) {

	}


	public function awardExperience(Request $request){
		//maybe request has the event and the amount of xp? 
		$from = Auth::user();
		$amount = $request->amount;
		$user = User::find($request->user['id']);

		$user->load('progression'); 
		$user->progression->awardExperience($amount);

		return $user;
	}

	public function buyBox(Request $request){
		$user = Auth::user(); 
		$points = request('points');
		$type = request('type');
		$user->load('progression');
		$user->progression->buyBox($points, $type); 
		$user->load('progression');
		return $user;
	}

	public function redeemGift(Request $request){
		//contains the user and how many gifts they are trying to redeem 
		$user = Auth::user();
		$user->load(['progression', 'rewards']); 
		$reward_id = request('reward');
		$pivot_id = request('pivot');
		Log::info("here we go");
		$info = $request->all();
		Log::info($info);
		Log::info($reward_id);
		Log::info($request->all());
		if($reward_id === 5){
			$user->progression->awardExperience(500);
			//announce
		}
		$reward = Reward::find($reward_id);
		//$user->rewards()->having('id', $reward_id)->update(['status' => 'redeemed']);
		$user->rewards()->wherePivot('id', $pivot_id)->updateExistingPivot($reward_id, ['status' => 'redeemed']);
		$return = User::find($user->id); 
		$return->load(['progression', 'rewards']);
		return $return;

	}

	public function openGift(Request $request){
		//contains the user, verifies opens, rolls, and returns a reward
		$user = Auth::user();
		$user->load('progression');
		$roll = request('roll');
		$type = request('type');
		if($type === 'premium'){
			//automatic best
			$user->progression->openBox(99);
		} else {
			$user->progression->openBox($roll);
		}
		//fires an event that says that a user has redeemed an award.
		$user->load(['progression','rewards']);
		return $user;
	}
}
