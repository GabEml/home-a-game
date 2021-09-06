<?php

namespace App\Http\Controllers;

use App\Models\Sessiongame;
use App\Models\Challenge;
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

        //On récupère les sessions de l'utilisateur qui sont en cours
        $sessiongamesUserNow = $user->sessiongames()->where('start_date','<',date('Y-m-d'))
        ->where('end_date','>',date('Y-m-d'))
        ->orderBy('end_date')
        ->get();

        //On récupère les ids des sessions en cours pour ne pas les afficher 2 fois
        $idSessiongamesNow = $sessiongamesUserNow->pluck('id');

        //On récupère toutes les autres sessions auquelles il est inscrit, qu'elles soient futur ou passés
        $sessiongamesUser = $user->sessiongames()->whereNotIn('sessiongames.id', $idSessiongamesNow)->orderByDesc('end_date')->get();

        $dateNow = date('Y-m-d');

        $challengeCompleted = 0;

        return view('sessiongame.index',['challengeCompleted'=>$challengeCompleted,'sessiongames'=>$sessiongamesAll, 'sessiongamesUser'=>$sessiongamesUser,'sessiongamesUserNow'=>$sessiongamesUserNow, 'dateNow'=>$dateNow]);
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
        
            $validateData=$request->validate([
                'price' => 'numeric',
                'name' => 'required|max:60|min:3',
                'description' => 'required|min:5', 
                'start_date' => 'required|date|after_or_equal:tomorrow', 
                'end_date'=>'required|date|after:start_date',
                'goodie'=>'required|integer|exists:goodies,id',
                'image_path'=>'required|image|max:100000',
                'type' => 'required|in:On The Road a Game,Home a Game',
                'see_ranking'=> 'integer|in:0,1',
            ]);

            if ($request->filled('price')){
            $sessiongame->price = $validateData["price"];
            }
            if ($request->filled('see_ranking')){
                $sessiongame->see_ranking = $validateData["see_ranking"];
            }

        // Save the file locally in the storage/public/ folder under a new folder named /product
        $request->image_path->store('images', 'public');
        $path ="/".$request->file('image_path')->store('images');
        
        $sessiongame->type = $validateData["type"];
        $sessiongame->name = $validateData["name"];
        $sessiongame->description = $validateData["description"];
        $sessiongame->start_date = $validateData["start_date"];
        $sessiongame->end_date = $validateData["end_date"];
        $sessiongame->image_path=$path;
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
        if($sessiongame!=NULL){
            $ranking= DB::table('sessiongame_user')
            ->select('users.id', DB::raw('SUM(user_point) as points'))
            ->join('users','users.id','=','sessiongame_user.user_id')
            ->leftjoin('posts', function ($join) use($sessiongame){
                $join->on('users.id', '=', 'posts.user_id')
                    ->whereIn('posts.challenge_id', function($query) use($sessiongame)
                    {
                        $query->select('id')
                              ->from('challenges')
                              ->where('sessiongame_id', "=", $sessiongame->id);
                    });
            })
            ->leftJoin('challenges','challenges.id', '=', 'posts.challenge_id')
            ->leftJoin('sessiongames','sessiongames.id', '=', 'challenges.sessiongame_id')
            ->where('sessiongame_user.sessiongame_id',$sessiongame->id)
            ->where('challenges.sessiongame_id',$sessiongame->id)
            ->orWhere(function($query) use($sessiongame) {
                $query->where('sessiongame_user.sessiongame_id', $sessiongame->id)
                      ->whereNull('challenges.sessiongame_id');
            })
            ->groupBy ('sessiongames.id','sessiongame_user.user_id')
            ->orderByDesc('points')
            ->get();
        }
        else {
            $ranking=NULL;
        }
        $position=0;
    
        return view('sessiongame.show', ['users'=>$ranking, "position"=>$position, "sessiongame"=>$sessiongame]);
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
                'name' => 'required|max:60|min:3',
                'description' => 'required|min:5', 
                'price' => 'numeric',
                'start_date' => 'required|date|', 
                'end_date'=>'required|date|after:start_date',
                'goodie'=>'required|integer|exists:goodies,id',
                'image_path'=>'image|max:100000',
                'type' => 'required|in:On The Road a Game,Home a Game',
                'see_ranking'=> 'integer|in:0,1',
            ]);

            if ($request->filled('see_ranking')){
                $sessiongame->see_ranking = $validateData["see_ranking"];
            }
            else{
                $sessiongame->see_ranking = 1;
            }

            if ($request->filled('price')){
                $sessiongame->price = $validateData["price"];
            }
        

        if ($request->hasFile('image_path')) {
            $path = $sessiongame->image_path;

            //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
            $path = substr($path,1);
            
            if(is_file($path))
            {
                //Supprimer l'image du dossier
                unlink(public_path($sessiongame->image_path));
        

                // Save the file locally in the storage/public/ folder under a new folder named /product
                $request->image_path->store('images', 'public');
                $path ="/".$request->file('image_path')->store('images');

                $sessiongame->image_path=$path;
            }
        }
        $sessiongame->name = $validateData["name"];
        $sessiongame->description = $validateData["description"];
        $sessiongame->start_date = $validateData["start_date"];
        $sessiongame->end_date = $validateData["end_date"];
        $sessiongame->type = $validateData["type"];
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
        $path = $sessiongame->image_path;

        //Pour utiliser is_file, il faur enlever le "/" qui est au début du chemin de l'image dans la bdd
        $path = substr($path,1);
            
        if(is_file($path))
        {
            //Supprimer l'image du dossier
            unlink(public_path($sessiongame->image_path));
        }
        $sessiongame->delete();
        return redirect('/sessions');
    }
}
