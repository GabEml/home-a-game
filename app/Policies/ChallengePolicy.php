<?php

namespace App\Policies;

use App\Models\Challenge;
use App\Models\Sessiongame;
use App\Models\User;
use App\Models\SessiongameUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ChallengePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user view model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $challenge
     * @return mixed
     */
    public function view(Challenge $challenge)
    {
 
        return Auth::user()->role->role==="User" 
        and SessiongameUser::where("user_id", Auth::user()->id)->where("sessiongame_id", $challenge->sessiongame->id)->get()->isNotEmpty()
        and $challenge->sessiongame->start_date<date('Y-m-d') and $challenge->sessiongame->end_date>date('Y-m-d');

        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $Challenge
     * @return mixed
     */
    public function update()
    {
        return Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Challenge  $Challenge
     * @return mixed
     */
    public function delete()
    {
        return Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="Super Admin";
    }

}
