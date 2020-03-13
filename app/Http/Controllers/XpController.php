<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Progression;
use App\Kratespace;
use Auth;
use Log;

class XpController extends Controller
{
    public function awardUser(Request $request) { 
        $user = User::find($request->user_id);
        $kratespace = Kratespace::find($request->space_id);
        if($kratespace->space_xp - $request->amount >= 0){

            $kratespace->distributeFromBank($request->amount);

            $user->progression->awardExperience($request->amount);
            return response()->json(['success' => 'award processed'], 200);
        } else {
            
            return response()->json(['error' => 'insufficient funds'], 422);
        }

    }

    public function addToBank(Request $request){
        $user = Auth::user();
        Log::info($request->all());
        $kratespace = $user->mykratespace->addToBank($request->amount); 
        return $kratespace;


    }
}
