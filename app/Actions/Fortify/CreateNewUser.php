<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth'=>['required','date','before_or_equal:today'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone'=>['required', 'string','max:14'],
            'address'=>['required','string', 'max:255'],
            'postal_code' => ['required', 'string', 'min:3', 'max:8'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],

        ])->validate();

        return User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'date_of_birth' => $input['date_of_birth'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'address' => $input['address'],
            'postal_code' => $input['postal_code'],
            'role_id'=> 1,
            'city' => $input['city'],
            'country' => $input['country'],
        ]);
    }
}
