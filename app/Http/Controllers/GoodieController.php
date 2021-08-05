<?php

namespace App\Http\Controllers;

use App\Models\Goodie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GoodieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Goodie::class);
        $goodies= Goodie::all();
        return view('goodie.index', ['goodies'=>$goodies]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Goodie::class);
            $validateData=$request->validate([
                'name' => 'required|max:60|min:3|unique:goodies',
                'image_path'=>'required|image|max:5000',
            ]);

            // Save the file locally in the storage/public/ folder under a new folder named /product
            $request->image_path->store('images', 'public');
            $path ="/".$request->file('image_path')->store('images');

            $goodie=new Goodie();
            $goodie->name = $validateData["name"];
            $goodie->image_path=$path;
            $goodie->save();
        

        return redirect('/goodies');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goodie  $goodie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goodie $goodie)
    {
        $this->authorize('update', Goodie::class);
            $validateData=$request->validate([
                'name' => 'required|max:60|min:3|unique:goodies',
            ]);

            $goodie->name = $validateData["name"];
            $goodie->update();
        

        return redirect('/goodies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goodie  $goodie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goodie $goodie)
    {
        $this->authorize('delete', Goodie::class);
        if(is_file($goodie->image_path))
        {
            //Supprimer l'image du dossier
            unlink(public_path($goodie->image_path));
        }
        $goodie->delete();
        
        return redirect('/goodies');
    }
}
