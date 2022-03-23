<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', SessiongameUser::class);
        $validateData=$request->validate([
            'sessiongames' => 'required|integer|exists:sessiongames,id',
        ]);

        $test = DB::table('sessiongame_user')
        ->where('sessiongame_id',$validateData["sessiongames"])
        ->where('user_id',Auth::user()->id)
        ->get();

        if($test->isEmpty()){
            $sessiongame=new SessiongameUser();
            $sessiongame->sessiongame_id = $validateData["sessiongames"];
            $sessiongame->user_id = Auth::user()->id;
            $sessiongame->save();

            return $this->sendResponse($sessiongame, 'Vous vous êtes bien inscrit à la session');
            // return response()->json([
            //     "message" => "Vous vous êtes bien inscrit à la session"]);
        }
        else {
            return $this->sendError($sessiongame, 'Vous êtes déjà inscrit à cette session');
            // return response()->json([
            //     "message" => "Vous êtes déjà inscrit à cette session"]);
        }
    }

}
