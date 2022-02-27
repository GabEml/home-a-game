<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Challenge;
use App\Models\Image;
use App\Models\Sessiongame;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sessiongame $sessiongame)
    {
        $this->authorize('create', Challenge::class);
        $validateData=$request->validate([
            'title' => 'required|max:255|min:5',
            'points' => 'required|integer|min:1', 
            'filenames'=>'required|max:5000',
            'filenames.*' => 'mimes:png,jpg,bmp,jpeg',
            'type_of_file'=>'required|in:picture,video',
        ]);

        $challenge=new Challenge();
        $challenge->title = $validateData["title"];
        $challenge->points = $validateData["points"];
        $challenge->type_of_file = $validateData["type_of_file"];
        $challenge->sessiongame_id=$sessiongame->id;
        
        $challenge->save();

        if($request->hasfile('filenames'))
         {
            
            $request->filenames->store('images', 'public'); 
            
            $path ="/".$request->file('filenames')->store('images');
            $image=new Image();
            $image->image_path = $path;
            $image->challenge_id=$challenge->id;
            $image->save();  
         }
    
         return $this->sendResponse($challenge, 'Challenge created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        $this->authorize('view', $challenge->sessiongame);
        $sessiongame=$challenge->sessiongame;
    
        return $this->sendResponse($challenge, 'Challenge selected');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        $this->authorize('update', Challenge::class);
        $validateData=$request->validate([
            'title' => 'required|max:255|min:5',
            'points' => 'required|integer|min:1', 
            'filenames'=>'max:5000',
            'filenames.*' => 'mimes:png,jpg,bmp,jpeg',
            'type_of_file'=>'required|in:picture,video',
        ]);

        $challenge->title = $validateData["title"];
        $challenge->points = $validateData["points"];
        $challenge->type_of_file = $validateData["type_of_file"];
        
        $challenge->update();

        // if($request->hasfile('filenames'))
        //  {
        //     for ($i = 0; $i < sizeof($validateData["filenames"]); $i++) {
        //         $request->filenames[$i]->store('images', 'public'); 
        //     }
        //     foreach ($request->file('filenames') as $image) {
        //         $path ="/".$image->store('images');
        //         $image=new Image();
        //         $image->image_path = $path;
        //         $image->challenge_id=$challenge->id;
        //         $image->save();
        //     }
        //  }

         $sessiongame = $challenge->sessiongame;
    
         return $this->sendResponse($challenge, 'Challenge updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        $this->authorize('delete', Challenge::class);
        $session = $challenge->sessiongame;
        $challenge->delete();

        return $this->sendResponse($challenge, 'Challenge deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Image $image)
    {
        $this->authorize('delete', Challenge::class);
        $challenge = $image->challenge;
        $image->delete();

        return $this->sendResponse($image, 'Image Challenge deleted successfully');
    }
}
