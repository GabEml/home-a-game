<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordAdmin as ResetPasswordAdminNotification;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail as VerifyEmailNotification;


/**
 * Le modèle User qui est lié à la table users dans la base de données
 * 
 * @author Clara Vesval <clara.vesval@ynov.com> 
 * 
 */

// Pour l'envoi de mail
// class User extends Authenticatable implements MustVerifyEmail


class User extends Authenticatable  // implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    public $timestamps = false;

/* Relations Eloquent */

/**
     * Renvoie le role de l'utilisateur'
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    } 

    /**
     * Renvoie la liste des articles écrit par un utilisateur
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * Renvoie la liste des posts d'un utilisateur
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Renvoie tous les sessions qui sont asssociés à 'l'utilisateur
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sessiongames()
    {
        return $this->belongsToMany('App\Models\Sessiongame')
                    ->using("App\Models\SessiongameUser")
                    ->withPivot("id");
                    
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'date_of_birth',
        'email',
        'password',
        'phone',
        'address',
        'postal_code',
        'role_id',
        'city',
        'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //'profile_photo_url',
    ];

    public function sendPasswordResetNotificationAdmin($token, $email)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordAdminNotification($token, $email));
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    // public function sendEmailVerificationNotification(){
    //     $this->notify(new VerifyEmailNotification());
    // }
}
