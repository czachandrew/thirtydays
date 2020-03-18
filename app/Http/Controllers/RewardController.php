<?php

namespace App\Http\Controllers;
use App\Reward;
use Auth;
use App\User;
use Log;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:api')->except('index');
    }

    public function index(){
    	//return some dedicated rewards template page 
    }

    public function get(){
    	$user = Auth::user();
    	$user->load('providedRewards');
    	return $user->providedRewards;
    }

    public function save(Request $request){
        $data = $request->all();
        
        Log::info($data);
        $reward = Reward::create($data['reward']);
        
        
        if($request->media){

            $reward->media()->create($data['media']);
        }

        return $reward;
    }

    public function create(Request $request){
    	$user = Auth::user();
    	$reward = $request->reward;
    	$reward['provider_id'] = $user->mykratespace->id;
    	$reward = Reward::create($reward);
    	return $reward;
    }

    public function update(Request $request){
        //$reward->update($request->reward);
        Reward::where('id', $request->reward)->update($request->data);
        $reward = Reward::find($request->reward);
        return $reward;
    }

    public function addStock(Reward $reward){
    	$adding = request("add_stock");
    	$reward->addStock($adding);
    	return $reward;
    }

    public function disable(Reward $reward){
        $reward->status = "disabled";
        $reward->save();
        return $reward;
    }
}
