<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use Auth;
use Log;

class MediaController extends Controller
{
    public function save(Request $request){
        //$files = $request->file('media');
        $objects = [];
        $payload = $request->all();
        $data = [];
        Log::info($payload);
        $files = $request->file('media');
        Log::info($files);
        
        $destinationPath = 'useruploads';
    
        foreach($files as $file){
            $data['type'] = $request->type;
       
            $data['user_id'] = Auth::user()->id;

            $file->move($destinationPath, $file->getClientOriginalName());
            $data['link'] = $destinationPath . '/'. $file->getClientOriginalName();
            $objects[] = $data;
        }

        // $mediaModel = Media::create($data);
        
        return $objects;

    }
}
