<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth'=>['required','date','before_or_equal:today'],
            'phone'=>['required', 'string','max:16'],
            'address'=>['required','string', 'max:255'],
            'postal_code' => ['required', 'string', 'min:3', 'max:8'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'date_of_birth' => $input['date_of_birth'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'postal_code' => $input['postal_code'],
            'city' => $input['city'],
            'country' => $input['country'],
            ])->save();
            if($user->stripe_id!=null){
                $user->updateStripeCustomer(
                    ['address'=>
                        ['city'=>$user->city, 'country'=>$user->country,'line1'=>$user->address,'postal_code'=>$user->postal_code], 
                    'name' => $user->firstname ." ". $user->lastname,
                    'metadata' => ['user_id' => $user->id],
                    'phone'=> $user->phone,
                    'email'=>$user->email,
                ]);
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'date_of_birth' => $input['date_of_birth'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'postal_code' => $input['postal_code'],
            'city' => $input['city'],
            'country' => $input['country'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
        if($user->stripe_id!=null){
        $user->updateStripeCustomer(
            ['address'=>
                ['city'=>$user->city, 'country'=>$user->country,'line1'=>$user->address,'postal_code'=>$user->postal_code], 
            'name' => $user->firstname ." ". $user->lastname,
            'metadata' => ['user_id' => $user->id],
            'phone'=> $user->phone,
            'email'=>$user->email,
        ]);
    }
    }
}
