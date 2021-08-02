<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goodie extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Renvoie la liste des sessions associés au goodie
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessiongames()
    {
        return $this->hasMany('App\Models\Sessiongame');
    }
}
