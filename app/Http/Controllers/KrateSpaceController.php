<?php

namespace App\Http\Controllers;

use App\Kratespace;
use App\JoinRequest;
use Auth;

use Illuminate\Http\Request;

class KrateSpaceController extends Controller
{
    public function save(Request $request){
        $kratespace = Kratespace::create($request->all());
        return $kratespace;
    }

    public function search(Request $request){
        if($request->term){
            //search
        } else {
            return Kratespace::all();
        }
    }

    public function update(Request $request, Kratespace $kratespace){}

    public function details(Request $request){
        $kratespace = Kratespace::find($request->space);
        return $kratespace->load('groups.tasks.usertasks', 'users' );
    }

    public function join(Kratespace $kratespace){
        $user = Auth::user(); 
        //we should check the type of the kratespace to see if it requires approval 
        if($kratespace->visibility === 'private' && $kratespace->joinable === 1){
            //create an a joinRequest 
            $data = ['user_id' => $user->id, 'kratespace_id' => $kratespace->id, 'status' => 'pending'];
            $joinRequest = JoinRequest::create($data);
            return $joinRequest;

            //return the joinRequest to the user
        } else if($kratespace->visibility === 'private' && $kratespace->joinable !== 0) {
            //return an error
            return response()->json(['error' => 'This space is not accepting new members at this time'], 422);
        } else {
            $user = $user->joinKratespace($kratespace->id);
            return $user;
        }
        
        
    }
}
