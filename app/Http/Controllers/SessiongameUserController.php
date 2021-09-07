<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\User;
use App\Models\Sessiongame;
use Illuminate\Http\Request;
use App\Models\SessiongameUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;


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
        $sessionpaschoisie = Sessiongame::whereNotIn('id', $sessionUser)->where("end_date" , '>' ,$dateNow)->where('type','Home a Game')->get();

        return view('sessiongameuser.create',['sessiongames'=>$sessionpaschoisie]);
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
            'sessiongames' => 'required|exists:sessiongames,id',
        ]);

        $test = DB::table('sessiongame_user')
        ->where('sessiongame_id',$validateData["sessiongames"])
        ->where('user_id',Auth::user()->id)
        ->get();

        if($test->isEmpty()){
        // for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
        //     $sessiongame=new SessiongameUser();
        //     $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
        //     $sessiongame->user_id = Auth::user()->id;
        //     $sessiongame->save();
        // }
        $sessiongames = Sessiongame::whereIn('id',$validateData["sessiongames"])->get();
        $totalPrice = Sessiongame::whereIn('id',$validateData["sessiongames"])->sum('price');
        
        return view('sessiongameuser.payment',['sessiongames'=>$sessiongames,'totalPrice'=>$totalPrice]);
        //return redirect()->route('sessiongames.index');
        }
        else{
            return redirect()->route('sessiongameusers.create');
        }

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePayment(Request $request)
    {
        $this->authorize('create', SessiongameUser::class);
        $validateData=$request->validate([
            'sessiongames' => 'required|exists:sessiongames,id',
        ]);

        $test = DB::table('sessiongame_user')
        ->where('sessiongame_id',$validateData["sessiongames"])
        ->where('user_id',Auth::user()->id)
        ->get();


        if($test->isEmpty()){
            $totalPrice = Sessiongame::whereIn('id',$validateData["sessiongames"])->sum('price');

            $user=User::where('id', Auth::user()->id)->first();
            try{
                $user->charge(
                $totalPrice*100, $request->payment_method, [
                    'currency' => 'eur',
                    'description'=>'Paiement session @Home a Game'
                ]);

            for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
                    $sessiongame=new SessiongameUser();
                    $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
                    $sessiongame->user_id = Auth::user()->id;
                    $sessiongame->save();
                }
                return redirect()->route('sessiongames.index')->with('success_message', 'Thank You! Your payment has been successfully accepted!');
            }
            catch(Exception $e){
                back()->withErrors('Error! '. $e->getMessage());
            }
   
        }
        else{
            return redirect()->route('sessiongameusers.store');
        }

        
    }

}
