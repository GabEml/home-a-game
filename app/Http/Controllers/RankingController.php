<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sessiongame;
use DateTime;

class RankingController extends Controller
{
    /**
     * ranking
     *
     * @return \Illuminate\Http\Response
     */
    public function ranking()
    {
        $session = DB::table('sessiongames')
        ->where('start_date','<',date('Y-m-d'))
        ->where('type','Home a Game')
        ->orderByDesc('start_date')
        ->first();

        if($session!=NULL){
            $ranking= DB::table('users')
            ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$session->id)
            ->groupBy ('user_id')
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->orderByDesc('points')
            ->get();
        }
        else {
            $ranking=NULL;
        }

        $position=0;

        $dateNow = new DateTime;

        $sessiongames = Sessiongame::where('type','Home a Game')->where("end_date" , '<' ,$dateNow)->get();
        
        return view('ranking', ['users'=>$ranking, "position"=>$position, "session"=>$session, "sessionCurrent"=>$session, "sessiongames"=>$sessiongames]);
    }

    /**
     * ranking previous
     *
     * @return \Illuminate\Http\Response
     */
    public function rankingPrevious(Sessiongame $sessiongame)
    {
        $sessionCurrent = DB::table('sessiongames')
        ->where('start_date','<',date('Y-m-d'))
        ->where('type','Home a Game')
        ->orderByDesc('start_date')
        ->first();

        if($sessiongame!=NULL){
            $ranking= DB::table('users')
            ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$sessiongame->id)
            ->groupBy ('user_id')
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->orderByDesc('points')
            ->get();
        }
        else {
            $ranking=NULL;
        }

        $position=0;

        $dateNow = new DateTime;

        $sessiongames = Sessiongame::where('type','Home a Game')->where("end_date" , '<' ,$dateNow)->get();
        
        return view('ranking', ['users'=>$ranking, "position"=>$position, "session"=>$sessiongame, "sessiongames"=>$sessiongames, "sessionCurrent"=>$sessionCurrent]);
    }

    /**
     * ranking otr
     *
     * @return \Illuminate\Http\Response
     */
    public function rankingOTR()
    {
        $session = DB::table('sessiongames')
        ->where('start_date','<',date('Y-m-d'))
        ->where('type','On The Road a Game')
        ->orderByDesc('start_date')
        ->first();

        if($session!=NULL){
            $ranking= DB::table('users')
            ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$session->id)
            ->groupBy ('user_id')
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->orderByDesc('points')
            ->get();
        }
        else {
            $ranking=NULL;
        }

        $dateNow = new DateTime;

        $sessiongames = Sessiongame::where('type','On The Road a Game')->where("end_date" , '<' ,$dateNow)->get();

        $position=0;
        return view('rankingOTR', ['users'=>$ranking, "position"=>$position, "session"=>$session,"sessionCurrent"=>$session, "sessiongames"=>$sessiongames]);
    }

    /**
     * ranking otr previous
     *
     * @return \Illuminate\Http\Response
     */
    public function rankingOTRPrevious(Sessiongame $sessiongame)
    {
        $sessionCurrent = DB::table('sessiongames')
        ->where('start_date','<',date('Y-m-d'))
        ->where('type','On The Road a Game')
        ->orderByDesc('start_date')
        ->first();

        if($sessiongame!=NULL){
            $ranking= DB::table('users')
            ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$sessiongame->id)
            ->groupBy ('user_id')
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->orderByDesc('points')
            ->get();
        }
        else {
            $ranking=NULL;
        }

        $position=0;

        $dateNow = new DateTime;

        $sessiongames = Sessiongame::where('type','On The Road a Game')->where("end_date" , '<' ,$dateNow)->get();
        
        return view('rankingOTR', ['users'=>$ranking, "position"=>$position, "session"=>$sessiongame, "sessiongames"=>$sessiongames, "sessionCurrent"=>$sessionCurrent]);
    }

    /**
     * Create Draw
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('draw', Sessiongame::class);
        $sessiongames = Sessiongame::where("type" ,"Home a Game")->get();
        $winner="";
        

        return view('draw', ["sessiongames"=>$sessiongames, "winner"=>$winner]);
    }

    /**
     * Store Draw
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('draw', Sessiongame::class);
        $sessiongames = Sessiongame::where("type" ,"Home a Game")->get();

        $potentialWinners=array();

        $validateData=$request->validate([
            'sessiongames' => 'required|exists:sessiongames,id',
        ]);

        for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
            $winnerSession = DB::table('users')
            ->select('users.firstname','users.lastname', 'users.email', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$validateData["sessiongames"][$i])
            ->groupBy ('user_id')
            ->join('posts','users.id', '=', 'posts.user_id')
            ->join('challenges','challenges.id', '=', 'posts.challenge_id')
            ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->orderByDesc('points')
            ->first();
            
            
            if(!empty($winnerSession)){
                array_push($potentialWinners, $winnerSession->firstname . " " . $winnerSession->lastname . " ( " . $winnerSession->email . " ) ");
            }
        }

        $indexWinner = array_rand ($potentialWinners , 1);
        $winner = $potentialWinners[$indexWinner];
        

        return view('draw', ["sessiongames"=>$sessiongames, "winner"=>$winner]);
    }
}
