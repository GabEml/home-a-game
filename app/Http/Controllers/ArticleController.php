<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles= Article::orderBy('created_at', 'desc')->get();
        return view('article.index', ['articles'=>$articles]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        return view('home', ['articles'=>$articles]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Article::class);
        return view('article.create');
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
                'description' => 'required|min:10', 
                'image_path'=>'required|image|max:5000',// Only allow .jpg, .bmp and .png file types.
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
        

        return redirect('/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', Article::class);
        return view('article.edit',compact('article'));
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
            'title' => 'required|max:60|min:5',Rule::unique('users')->ignore($article->id),
            'description' => 'required|min:10', // Only allow .jpg, .bmp and .png file types.
            'image_path'=>'image|max:5000',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $article->image_path;

            //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
            $path = substr($path,1);
            
            if(is_file($path))
            {
                //Supprimer l'image du dossier
                unlink(public_path($article->image_path));
        

                // Save the file locally in the storage/public/ folder under a new folder named /product
                $request->image_path->store('images', 'public');
                $path ="/".$request->file('image_path')->store('images');

                $article->image_path=$path;
            }
        }

        $article->title = $validateData["title"];
        $article->description = $validateData["description"];
        $article->update();
        
        return redirect('/articles');
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
        $path = $article->image_path;

        //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
        $path = substr($path,1);

        if(is_file($path))
        {
        //Supprimer l'image du dossier
        unlink(public_path($article->image_path));
        }
        $article->delete();
        return redirect('/articles');
    }
}
