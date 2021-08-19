<?php

namespace App\Http\Controllers;

use App\Models\Sessiongame;
use App\Models\SessiongameUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;


class SessiongameUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', SessiongameUser::class);
        $dateNow = new DateTime;
       $user = User::where('id', Auth::user()->id)->first();
        $sessionUser = $user->sessiongames->pluck('id');
        $sessionNotChosen = Sessiongame::whereNotIn('id', $sessionUser)->where("end_date" , '>' ,$dateNow)->get();

        return view('sessiongameuser.create',['sessiongames'=>$sessionNotChosen]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', SessiongameUser::class);
        $validateData=$request->validate([
            'sessiongames' => 'required|exists:sessiongames,id|unique:sessiongame_user,user_id,sessiongame_id',
        ]);

        for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
            $sessiongame=new SessiongameUser();
            $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
            $sessiongame->user_id = Auth::user()->id;
            $sessiongame->save();
        }
        return redirect()->route('sessiongames.index');

    }

}
