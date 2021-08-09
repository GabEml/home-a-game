<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPending()
    {
        $this->authorize('viewAny', Post::class);
        $postsPending = Post::where('state', 'pending')->get();
        
        return view('validationchallenge.pending', ['postsPending'=>$postsPending]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexValidated()
    {
        $this->authorize('viewAny', Post::class);
        $postsValidated = Post::where('state', '!=', 'pending')->orderByDesc("id")->get();
        return view('validationchallenge.validated', ['postsValidated'=>$postsValidated ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Challenge $challenge)
    {
        $this->authorize('create', Post::class);
        if($challenge->type_of_file=="picture"){

            $validateData=$request->validate([
                'file_path'=>'required|image|max:100000',
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file_path->store('images', 'public');
            $path ="/".$request->file('file_path')->store('images');
            }

            if($challenge->type_of_file=="video"){

                $validateData=$request->validate([
                    'file_path'=>'required|mimes:mp4|max:100000',
                ]);
    
                // Save the file locally in the storage/public/ folder under a new folder named /product
                $request->file_path->store('videos', 'public');
                $path ="/".$request->file('file_path')->store('videos');
                }
    
    
            $post=new Post();
            $post->file_path=$path;
            $post->user_id=Auth::user()->id;
            $post->challenge_id=$challenge->id;
            $post->state="pending";
            $post->save();
        

            return redirect()->route('challenges.show', ['challenge'=>$challenge]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        if($post->state==="pending"){
            $test=1;
        }
        else{
            $test=32;
        }
        $maxPoints = $post->challenge->points;

        $validateData=$request->validate([
            'state' => 'required|in:validated,partly_validated,not_validated', 
            'user_point'=>"required|min:0|max:$maxPoints",
            'comment'=>'required|max:255|min:4'
        ]);
        
        $post->state = $validateData["state"];
        $post->user_point = $validateData["user_point"];
        $post->comment = $validateData["comment"];
        $post->update();

        $postsPending = Post::where('state', 'pending')->get();
        $postsValidated = Post::where('state', '!=', 'pending')->get();

        if($test==1){
            return redirect()->route('posts.indexPending', ['posts'=>$postsPending]);
        }
        else{
            return redirect()->route('posts.indexValidated', ['posts'=>$postsValidated]);
        }

 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $path = $post->image_path;

            //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
            $path = substr($path,1);
            
            if(is_file($path))
            {
            //Supprimer l'image du dossier
            unlink(public_path($post->image_path));
        }
        $post->delete();
        $challenge=$post->challenge;

        $postsPending = Post::where('state', 'pending')->get();
        $postsValidated = Post::where('state', '!=', 'pending')->get();


        if (Auth::user()->role->role==="User"){
            return redirect()->route('challenges.show', ['challenge'=>$challenge]);
        }
        else{
            if($post->state==="pending"){
                return redirect()->route('posts.indexPending', ['posts'=>$postsPending]);
            }
            else{
                return redirect()->route('posts.indexValidated', ['posts'=>$postsValidated]);
            }
        }
    }
}
