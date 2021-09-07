<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Sessiongame $sessiongame)
    {
        $this->authorize('create', Challenge::class);
        return view('challenge.create',['sessiongame'=>$sessiongame]);
    }

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
            'points' => 'required_if:unlimited_points,|nullable|integer|min:1', 
            'filenames'=>'required|max:100000',
            'filenames.*' => 'mimes:png,jpg,bmp,jpeg',
            'editable'=> 'integer|in:0,1',
            'unlimited_points'=> 'integer|in:0,1',
            'type_of_file'=>'required|in:picture,video,both',
        ]);

        $challenge=new Challenge();
        $challenge->title = $validateData["title"];
        $challenge->points = $validateData["points"];
        $challenge->type_of_file = $validateData["type_of_file"];
        if ($request->filled('editable')){
            $challenge->editable = $validateData["editable"];
        }
        if ($request->filled('unlimited_points')){
            $challenge->unlimited_points = $validateData["unlimited_points"];
        }
        $challenge->sessiongame_id=$sessiongame->id;
        
        $challenge->save();

        if($request->hasfile('filenames'))
         {
            for ($i = 0; $i < sizeof($validateData["filenames"]); $i++) {
                $request->filenames[$i]->store('images', 'public'); 
            }
            foreach ($request->file('filenames') as $image) {
                $path ="/".$image->store('images');
                $image=new Image();
                $image->image_path = $path;
                $image->challenge_id=$challenge->id;
                $image->save();
            }
         }
    
        return redirect()->route('sessiongames.show', ['sessiongame'=>$sessiongame]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        $this->authorize('view',$challenge->sessiongame);
        $sessiongame=$challenge->sessiongame;
        $countImage= DB::table('images')
        ->select(DB::raw('COUNT(*) as number'))
        ->where ('challenge_id', $challenge->id)
        ->groupBy ('challenge_id')
        ->get();

        foreach ($countImage as $image){
            $numberImages = $image->number;
        }

        $post= DB::table('posts')
        ->select("*")
        ->where ('challenge_id', $challenge->id)
        ->where ('user_id', Auth::user()->id)
        ->first();


        return view('challenge.show',['sessiongame'=>$sessiongame, 'challenge'=>$challenge,'numberImages'=>$numberImages,'post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        $this->authorize('update', Challenge::class);
        $countImage= DB::table('images')
        ->select(DB::raw('COUNT(*) as number'))
        ->where ('challenge_id', $challenge->id)
        ->groupBy ('challenge_id')
        ->get();

        foreach ($countImage as $image){
                $numberImage = $image->number;
        }

        return view('challenge.edit',['challenge'=>$challenge, 'countImage'=>$countImage,'numberImage'=>$numberImage]);
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
            'points' => 'required_if:unlimited_points,|nullable|integer|min:1', 
            'editable'=> 'integer|in:0,1',
            'unlimited_points'=> 'integer|in:0,1',
            'filenames'=>'max:100000',
            'filenames.*' => 'mimes:png,jpg,bmp,jpeg',
            'type_of_file'=>'required|in:picture,video,both',
        ]);

        $challenge->title = $validateData["title"];
        $challenge->points = $validateData["points"];

        if ($request->filled('editable')){
            $challenge->editable = $validateData["editable"];
        }
        else{
            $challenge->editable = 0;
        }

        if ($request->filled('unlimited_points')){
            $challenge->unlimited_points = $validateData["unlimited_points"];
        }
        else{
            $challenge->unlimited_points = 0;
        }

        $challenge->type_of_file = $validateData["type_of_file"];
        
        $challenge->update();

        if($request->hasfile('filenames'))
         {
            for ($i = 0; $i < sizeof($validateData["filenames"]); $i++) {
                $request->filenames[$i]->store('images', 'public'); 
            }
            foreach ($request->file('filenames') as $image) {
                $path ="/".$image->store('images');
                $image=new Image();
                $image->image_path = $path;
                $image->challenge_id=$challenge->id;
                $image->save();
            }
         }

         $sessiongame = $challenge->sessiongame;
    
        return redirect()->route('sessiongames.show', ['sessiongame'=>$sessiongame]);
        
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

        foreach ($challenge->images as $image){
            $path = $image->image_path;

            //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
            $path = substr($path,1);
                
            if(is_file($path))
            {
                //Supprimer l'image du dossier
                unlink(public_path($image->image_path));
            }
        }

        $session = $challenge->sessiongame;
        $challenge->delete();
        return redirect()->route('sessiongames.show', ['sessiongame'=>$session]);
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

        $path = $image->image_path;

        //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
        $path = substr($path,1);
            
        if(is_file($path))
        {
            //Supprimer l'image du dossier
            unlink(public_path($image->image_path));
        }

        $challenge = $image->challenge;
        $image->delete();
        return redirect()->route('challenges.edit', ['challenge'=>$challenge]);
        
    }
}
