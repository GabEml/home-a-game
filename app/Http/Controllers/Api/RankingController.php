<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sessiongame;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

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
        ->select('id')
        ->where('start_date','<',date('Y-m-d'))
        ->where('end_date','>',date('Y-m-d'))
        ->first();

        $ranking= DB::table('users')
        ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
        ->where('sessiongames.id',$session->id)
        ->groupBy ('user_id')
        ->join('posts','users.id', '=', 'posts.user_id')
        ->join('challenges','challenges.id', '=', 'posts.challenge_id')
        ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
        ->orderByDesc('points')
        ->get();

        $position=0;
        $winner="";
        
        return $this->sendResponse($ranking, 'Session Rank selected');
    }

    /**
     * ranking
     *
     * @return \Illuminate\Http\Response
     */
    public function winnerDraw()
    {
        $this->authorize('draw', Sessiongame::class);

        $nb_session = DB::table('sessiongames')
        ->select (DB::raw('COUNT(*) as number'))
        ->where ('start_date','like',date('Y'))
        ->first();

        $potentialWinners=array();
        
        $years = date('Y');
        $sessions = SessionGame::where('start_date','like',"$years%")->get();

        
        foreach($sessions as $session) {
            $winnerSession = DB::table('users')
            ->select('users.firstname','users.lastname', 'users.email', DB::raw('SUM(user_point) as points'))
            ->where('sessiongames.id',$session->id)
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
        $potentialWinners = array_unique($potentialWinners);

        $indexWinner = array_rand ($potentialWinners , 1);
        $winner = $potentialWinners[$indexWinner];


        $sessionNow = DB::table('sessiongames')
        ->select('id')
        ->where('start_date','<',date('Y-m-d'))
        ->where('end_date','>',date('Y-m-d'))
        ->first();

        $ranking= DB::table('users')
        ->select('users.firstname','users.lastname', DB::raw('SUM(user_point) as points'))
        ->where('sessiongames.id',$sessionNow->id)
        ->groupBy ('user_id')
        ->join('posts','users.id', '=', 'posts.user_id')
        ->join('challenges','challenges.id', '=', 'posts.challenge_id')
        ->join('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
        ->orderByDesc('points')
        ->get();

        $position=0;

        return $this->sendResponse($winner, 'Winner selected');
    }
}
