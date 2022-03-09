<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Models\Post;
use App\Models\User;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
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
<<<<<<< HEAD
        
        // dump($postsPending);
=======
>>>>>>> fd0cefc320bcd344a1ec7b47da43f2767ea78ab9

        return view('validationchallenge.pending', ['postsPending'=>$postsPending]);

    }

    /**
     * Search users posts
     *
     * @return \Illuminate\Http\Response
     */
    public function searchPending(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $key = $request->searchPost;

        $postsSearch = User::select("*",'posts.id as post_id')
        ->where('posts.state',"pending")
            ->where(function($query) use($key){
                $query->orWhere('lastname', 'like', "%{$key}%")
                    ->orWhere('firstname', 'like', "%{$key}%")
                    ->orWhere('email', 'like', "%{$key}%")
                    ->orWhere('challenges.title', 'like', "%{$key}%");
            })
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->get();

        return view('validationchallenge.searchPending', ['postsPending'=>$postsSearch]);
    }

    /**
     * Search users posts
     *
     * @return \Illuminate\Http\Response
     */
    public function searchValidated(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $key = $request->searchPost;

        $postsSearch = User::select("*",'posts.id as post_id')
            ->whereIn('posts.state', ['validated','partly_validated','not_validated'])
            ->where(function($query) use($key){
                $query->orWhere('lastname', 'like', "%{$key}%")
                    ->orWhere('firstname', 'like', "%{$key}%")
                    ->orWhere('email', 'like', "%{$key}%")
                    ->orWhere('challenges.title', 'like', "%{$key}%");
            })
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->get();

        return view('validationchallenge.searchValidated', ['postsValidated'=>$postsSearch]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexValidated()
    {
        $this->authorize('viewAny', Post::class);
        $postsValidated = Post::where('state', '!=', 'pending')->orderByDesc("id")->paginate(9);
        $postsPending = Post::where('state', '=', 'pending')->orderByDesc("id")->get();
        return view('validationchallenge.validated', ['postsValidated'=>$postsValidated ], ['postsPending'=>$postsPending]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Challenge $challenge)
    {
        $this->authorize('createPost', $challenge);
        if($challenge->type_of_file=="picture"){

            $validateData=$request->validate([
                'file_path'=>'required|image|max:100000',
            ],[
                'file_path.image'=>'Le fichier de preuve doit être une image.',
                'file_path.max'=>'Vous dépassez la taille maximale (100Mo).'
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file_path->store('images', 'public');
            $path ="/".$request->file('file_path')->store('images');
            }

        else if($challenge->type_of_file=="video"){

            $validateData=$request->validate([
                'file_path'=>'required|mimetypes:video/x-ms-wmv,video/webm,video/ogg,video/x-m4v,video/x-msvideo,video/3gpp,video/MP2T,application/x-mpegURL,video/x-flv,video/mp4,video/avi,video/mpeg,video/quicktime|max:100000',
            ],[
                'file_path.mimes'=>'Le fichier de preuve doit être une vidéo mp4',
                'file_path.max'=>'Vous dépassez la taille maximale (100Mo).'
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->file_path->store('videos', 'public');
            $path ="/".$request->file('file_path')->store('videos');
        }
        else {
            $validateData=$request->validate([
                'file_path'=>'required|mimetypes:image/png,image/svg+xml,image/bmp,image/jpeg,image/webp,image/gif,
                video/x-ms-wmv,video/webm,video/ogg,video/x-m4v,video/x-msvideo,video/3gpp,video/MP2T,application/x-mpegURL,video/x-flv,video/mp4,video/avi,video/mpeg,video/quicktime|max:100000',
            ],[
                'file_path.mimes'=>"Le fichier de preuve n'a pas le bon format",
                'file_path.max'=>'Vous dépassez la taille maximale (100Mo).'
            ]);

            //On vérifie si c'est une image
            if (false !== mb_strpos($validateData["file_path"]->getMimeType(), "image")) {
                $request->file_path->store('images', 'public');
                $path ="/".$request->file('file_path')->store('images');
            }
            else {
                $request->file_path->store('videos', 'public');
                $path ="/".$request->file('file_path')->store('videos');
            }
        }

        $date = new DateTime();
        $date->format('Y-m-d H:i:s');

        $post=new Post();
        $post->file_path=$path;
        $post->user_id=Auth::user()->id;
        $post->challenge_id=$challenge->id;
        $post->state="pending";
        $post->posted_at = $date;

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

        $validateDataBonus=$request->validate([
            'bonus' => 'integer|in:0,1',
        ]);

        $maxPointsPost = $post->challenge->points;

        if($post->challenge->unlimited_points==1 || $request->filled('bonus')){
            $validateData=$request->validate([
            'state' => 'required|in:validated,partly_validated,not_validated',
            'user_point'=>"required_if:state,partly_validated|numeric|nullable|min:0|max:2147483647",
            'comment'=>'nullable|max:255|min:2',
            'bonus' => 'integer|in:0,1',
        ]);
        $post->bonus = $validateData["bonus"];
        $post->state = $validateData["state"];
        $post->user_point = $validateData["user_point"];
        }

        else {
            $validateData=$request->validate([
            'state' => 'required|in:validated,partly_validated,not_validated',
            'user_point'=>"required_if:state,partly_validated|numeric|nullable|min:0|max:$maxPointsPost",
            'comment'=>'nullable|max:255|min:2',
            ]);

            $post->bonus = 0;

            $post->state = $validateData["state"];
            if($validateData["state"]==="validated"){
                $post->user_point =$maxPointsPost;
            }
            else if($validateData["state"]==="partly_validated"){
                $post->user_point = $validateData["user_point"];
            }
            else{
                $post->user_point =0;
            }
        }

        $post->comment = $validateData["comment"];
        // $date = Post::select('posted_at')->where('id', $post->id)->get();
        // $post->posted_at = $date;
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
        $path = $post->file_path;

            //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
            $path = substr($path,1);

            if(is_file($path))
            {
            //Supprimer l'image du dossier
            unlink(public_path($post->file_path));
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
