<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Goodie;
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
        return $goodies;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goodie  $goodie
     * @return \Illuminate\Http\Response
     */
    public function show(Goodie $goodie)
    {
        return $goodie;
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
            ]);

            $goodie=new Goodie();
            $goodie->name = $validateData["name"];
            $goodie->save();
        

            return [$goodie, response()->json([
                "message" => "Goodie créé"])];
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
        

            return [$goodie, response()->json([
                "message" => "Goodie modifié"])];
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
        $goodie->delete();
        return [$goodie, response()->json([
            "message" => "Goodie supprimé"])];
    }
}
