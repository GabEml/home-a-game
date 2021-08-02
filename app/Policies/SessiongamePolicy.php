<?php

namespace App\Policies;

use App\Models\Sessiongame;
use App\Models\User;
use App\Models\Goodie;
use App\Models\SessiongameUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SessiongamePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user view models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user, Sessiongame $sessiongame)
    {
        if (Auth::user()->role->role==="User"){
            return Sessiongame::all()->where("id_user", $user->id)->where("id_sessiongame", $sessiongame->id)!==null;
        }
        else {
            return Auth::user()->role->role==="Admin Défis";
        }
        
    }

    /**
     * Determine whether the user view model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, Sessiongame $sessiongame)
    {
        if (Auth::user()->role->role==="User"){
           
            return SessiongameUser::where("user_id", Auth::user()->id)->where("sessiongame_id", $sessiongame->id)->get()->isNotEmpty()
            and $sessiongame->start_date<date('Y-m-d') and $sessiongame->end_date>date('Y-m-d');
        }
        else {
            return Auth::user()->role->role==="Admin Défis";
        }
        
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sessiongame  $Sessiongame
     * @return mixed
     */
    public function update()
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sessiongame  $Sessiongame
     * @return mixed
     */
    public function delete()
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can draw a winner.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sessiongame  $Sessiongame
     * @return mixed
     */
    public function draw()
    {
        return Auth::user()->role->role==="Admin Défis";
    }

}
