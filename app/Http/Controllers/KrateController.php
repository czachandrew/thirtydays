<?php

namespace App\Http\Controllers;

use App\Krate;
use App\UserKrate;
use App\Reward;
use Illuminate\Http\Request;
use Auth;
use Log;

class KrateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Krate  $krate
     * @return \Illuminate\Http\Response
     */
    public function show(Krate $krate)
    {
        //
    }

    public function list(){
        return Krate::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Krate  $krate
     * @return \Illuminate\Http\Response
     */
    public function edit(Krate $krate)
    {
        //
    }

    public function getMyKrates(){
        $user = Auth::user(); 
        $user->load('krates');
        $myKrates = $user->openableKrates->groupBy('krate.title');
        return $myKrates;
    }

    public function open(UserKrate $krate){
        $user = Auth::user(); 
        if($user->id !== $krate->user_id){
            return "error";
        }
        //generate the roll
        $roll = mt_rand(1, 100);
        $krate->load('krate');
        $roll += $krate->krate->influence;
        //now get the appropriate reward
        switch (true) {
            case $roll >= 95:
                //get a premium reward 0
                $reward = $this->getReward(0);
                break;
            case 94 <= $roll && $roll >= 79:
                //get a high tier 1
                $reward = $this->getReward(1);
                break;
            case 78 <= $roll && $roll >= 53:
                //get a standard 2
                $reward = $this->getReward(2);
                break; 
            default:
                #give a tier 3 reward
                $reward = $this->getReward(3);
                break;
        }
        $krate->open();
        $krate->save();
        return $reward; 
    }

    public function getReward($rank, $type = 'all', $space_id = null){
        $user = Auth::user();
        $rewards = Reward::available()->get();
        Log::info($rewards);
        $total = $rewards->count();
        $select = (mt_rand(1, $total) -1 );
        $reward = $rewards[$select];
        $obj = Reward::find($reward['id']);
        $obj->awardTo($user);
        return $obj;
    }

    public function buy(Krate $krate){
        $user = Auth::user(); 
        $user->load('progression');
        Log::info($user->progression->current_xp);
        Log::info($krate->cost);
        if($user->progression->current_xp >= $krate->cost){
            $user->progression->buyKrate($krate);
            return $user->latestKrate;
        } else {
            return "Not enough funds";
        }
        

    }

    public function buyAndOpen( Request $request){
        Log::info($request->all());
        Log::info($request->id);
       

        $myKrate = $this->buy(Krate::find($request->id));
        Log::info("Here is the krate collection");
        Log::info($myKrate);
        
        Log::info("here is the userkrate");
        Log::info($myKrate);
        if($myKrate === 'Not enough funds'){
            return "Not enough funds";
        }
        $myKrate = UserKrate::find($myKrate[0]['id']);

        $reward = $this->open($myKrate);
        return $reward;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Krate  $krate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Krate $krate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Krate  $krate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Krate $krate)
    {
        //
    }
}
