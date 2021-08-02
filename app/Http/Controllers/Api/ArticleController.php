<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        return $articles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles= Article::orderBy('created_at', 'desc')->get();
        return $articles;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Article::class);
            $validateData=$request->validate([
                'title' => 'required|max:60|min:5|unique:articles',
                'description' => 'required|min:10', // Only allow .jpg, .bmp and .png file types.
                'image_path'=>'required|image|max:5000',
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->image_path->store('images', 'public');
            $path ="/".$request->file('image_path')->store('images');

    
    
            $article=new Article();
            $article->title = $validateData["title"];
            $article->description = $validateData["description"];
            $article->image_path=$path;
            $article->user_id=Auth::user()->id;
            $article->save();
        

         return [$article, response()->json([
            "message" => "Article créé"])];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', Article::class);
        $validateData=$request->validate([
            'title' => 'required|max:60|min:5',
            'description' => 'required|min:10', // Only allow .jpg, .bmp and .png file types.
            'image_path'=>'image|max:5000',
        ]);

        if ($request->hasFile('image_path')) {
        // Save the file locally in the storage/public/ folder under a new folder named /product
        $request->image_path->store('images', 'public');
        $path ="/".$request->file('image_path')->store('images');

        $article->image_path=$path;
        }

        $article->title = $validateData["title"];
        $article->description = $validateData["description"];
        $article->update();
        
        return [$article, response()->json([
            "message" => "Article modifié"])];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', Article::class);
        $article->delete();
        return [$article, response()->json([
            "message" => "Article supprimé"])];
    }
}
