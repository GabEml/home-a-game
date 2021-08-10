<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user view models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create()
    {
        return Auth::user()->role->role==="User";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return Auth::user()->role->role==="Admin Défis";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if(Auth::user()->role->role==="User"){
            return $post->state=="pending" or $post->challenge->editable==1;
        }
        else{
            return Auth::user()->role->role==="Admin Défis";
        }
  
    }

}
