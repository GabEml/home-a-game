<?php

namespace App\Http\Controllers;

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
    public function index(Sessiongame $sessiongame)
    {
        $this->authorize('viewAny', $sessiongame);
        $sessiongamesAll= Sessiongame::orderBy('start_date')->get();
        $user=User::where('id', Auth::user()->id)->first();
        $sessiongamesUser = $user->sessiongames;

        // $dateNow = new DateTime;
        // $dateNow= $dateNow['date'];
        $dateNow = date('Y-m-d');

        return view('sessiongame.index',['sessiongames'=>$sessiongamesAll, 'sessiongamesUser'=>$sessiongamesUser, 'dateNow'=>$dateNow]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Sessiongame::class);
        $goodies= Goodie::all();
        return view('sessiongame.create',['goodies'=>$goodies]);
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
    

    return redirect('/sessions');
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
        return view('sessiongame.show', compact('sessiongame'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SessionGame  $sessionGame
     * @return \Illuminate\Http\Response
     */
    public function edit(SessionGame $sessiongame)
    {
        $this->authorize('update', Sessiongame::class);
        $goodies= Goodie::all();
        return view('sessiongame.edit',['goodies'=>$goodies, 'sessiongame'=>$sessiongame]);
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
    

    return redirect('/sessions');
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
        return redirect('/sessions');
    }
}
