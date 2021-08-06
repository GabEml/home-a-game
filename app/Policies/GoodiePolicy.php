<?php

namespace App\Policies;

use App\Models\Goodie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class GoodiePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::user()->role->role==="Admin Défis" or Auth::user()->role->role==="User";
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create()
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Goodie  $goodie
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
     * @param  \App\Models\Goodie  $goodie
     * @return mixed
     */
    public function delete()
    {
        return Auth::user()->role->role==="Admin Défis";
    }
}
