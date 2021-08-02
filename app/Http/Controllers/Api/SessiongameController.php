<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Sessiongame;
use App\Models\Goodie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Datetime;
use phpDocumentor\Reflection\Types\Object_;

class SessiongameController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        $user=User::where('id', Auth::user()->id)->first();
        $sessiongamesUser = $user->sessiongames;

        return $sessiongamesUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessiongamesAll= Sessiongame::orderBy('start_date')->get();

        return $sessiongamesAll;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Sessiongame::class);
        

        $sessiongame=new Sessiongame();
        if ($request->filled('price')){
            $validateData=$request->validate([
                'price' => 'numeric',
                'start_date' => 'required|date|after_or_equal:tomorrow', 
                'end_date'=>'required|date|after:start_date',
                'goodie'=>'required|integer|exists:goodies,id'
            ]);

            $sessiongame->price = $validateData["price"];
        }
        else {
            $validateData=$request->validate([
                'start_date' => 'required|date|after_or_equal:tomorrow', 
                'end_date'=>'required|date|after:start_date',
                'goodie'=>'required|integer|exists:goodies,id'
            ]);
        }
        
        $sessiongame->start_date = $validateData["start_date"];
        $sessiongame->end_date = $validateData["end_date"];
        $sessiongame->goodie_id = $validateData["goodie"];
        $sessiongame->save();
    

        return [$sessiongame, response()->json([
            "message" => "Session de jeu créée"])];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SessionGame  $sessionGame
     * @return \Illuminate\Http\Response
     */
    public function show(SessionGame $sessiongame)
    {
        $this->authorize('view', $sessiongame);
        return [$sessiongame, $sessiongame->challenges];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SessionGame  $sessionGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SessionGame $sessiongame)
    {
        $this->authorize('update', Sessiongame::class);
        $validateData=$request->validate([
            'start_date' => 'required|date|', 
            'end_date'=>'required|date|after:start_date',
            'goodie'=>'required|integer|exists:goodies,id'
        ]);

        
        if ($request->filled('price')){
            $validateData=$request->validate([
                'price' => 'numeric',
                'start_date' => 'required|date|', 
                'end_date'=>'required|date|after:start_date',
                'goodie'=>'required|integer|exists:goodies,id'
            ]);

            $sessiongame->price = $validateData["price"];
        }
        
        $sessiongame->start_date = $validateData["start_date"];
        $sessiongame->end_date = $validateData["end_date"];
        $sessiongame->goodie_id = $validateData["goodie"];
        $sessiongame->update();
    

        return [$sessiongame, response()->json([
            "message" => "Session de jeu modifiée"])];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SessionGame  $sessionGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(SessionGame $sessiongame)
    {
        $this->authorize('delete', Sessiongame::class);
        $sessiongame->delete();
        return [$sessiongame, response()->json([
            "message" => "Session de jeu suprimée"])];
    }
}
