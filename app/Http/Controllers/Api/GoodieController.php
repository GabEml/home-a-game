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
        
        return $this->sendResponse($goodies, 'Goodies list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goodie  $goodie
     * @return \Illuminate\Http\Response
     */
    public function show(Goodie $goodie)
    {
        return $this->sendResponse($goodie, 'Goodie selected');
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
        

            return $this->sendResponse($goodie, 'Goodie created successfully');
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
        

            return $this->sendResponse($goodie, 'Goodie updated successfully');
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

        return $this->sendResponse($goodie, 'Goodie deleted successfully');
    }
}
