<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
        
        return $postsPending;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexValidated()
    {
        $this->authorize('viewAny', Post::class);
        $postsValidated = Post::where('state', '!=', 'pending')->get();
        return $postsValidated;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
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
                'file_path'=>'required|image|max:5000',
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file_path->store('images', 'public');
            $path ="/".$request->file('file_path')->store('images');
            }

            if($challenge->type_of_file=="video"){

                $validateData=$request->validate([
                    'file_path'=>'required|mimes:mp4|max:5000',
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
        

            return [$post, response()->json([
                "message" => "Post créé"])];
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

        $maxPoints = $post->challenge->points;

        $validateData=$request->validate([
            'state' => 'required|in:validated,partly_validated,not_validated', 
            'user_point'=>"required|min:0|max:$maxPoints",
            'comment'=>'required|max:255|min:5'
        ]);
        
        $post->state = $validateData["state"];
        $post->user_point = $validateData["user_point"];
        $post->comment = $validateData["comment"];
        $post->update();

        return [$post, response()->json([
            "message" => "Post modifié"])];

 
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
        $post->delete();
        return [$post, response()->json([
            "message" => "Post supprimé"])];
    }
}
