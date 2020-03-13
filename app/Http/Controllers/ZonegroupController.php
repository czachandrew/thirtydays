<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zonegroup;
use App\Kratespace;
use Auth;

class ZonegroupController extends Controller
{
    public function save(Request $request, Kratespace $kratespace){
        $user = Auth::user();
        $kratespace->addGroup($request->toArray());
        $kratespace->load('groups.tasks');
        return $kratespace->groups;

    }

    public function delete(Zonegroup $zonegroup){
        $zonegroup->delete();
        return;
    }
}
