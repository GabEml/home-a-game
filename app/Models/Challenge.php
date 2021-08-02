<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Renvoi la session qui appartient au défi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessiongame()
    {
        return $this->belongsTo(Sessiongame::class);
    }

    /**
     * Renvoie la liste des posts associés au défi
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Renvoie la liste des images associés au défi
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
