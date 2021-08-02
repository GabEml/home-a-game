<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessiongame extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Renvoie la liste des défis d'une session
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challenges()
    {
        return $this->hasMany('App\Models\Challenge');
    }

    /**
     * Renvoie le goodie de la session
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goodie()
    {
        return $this->belongsTo('App\Models\Goodie');
    } 

    /**
     * Renvoie tous les utilisateurs qui sont asssociés à la session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')
                    ->using("App\Models\SessiongameUser")
                    ->withPivot("id");
                    
    }
}
