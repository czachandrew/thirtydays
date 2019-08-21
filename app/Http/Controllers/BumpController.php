<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Submission; 
use App\Bump;
use Auth;

class BumpController extends Controller
{
    //

	public function bumpScore(Submission $submission){
		$user = Auth::user();
		$submission->bump($user->id);
		$submission->load('bumps');
		return $submission;
	}
}
