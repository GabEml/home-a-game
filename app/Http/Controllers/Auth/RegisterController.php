<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Sessiongame;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use App\Actions\Fortify\PasswordValidationRules;
// use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected $redirectTo = '/inscription_sessions';

    public function __construct(
    ){
    
    }

    use PasswordValidationRules;

    protected function redirectTo()
    {
        return $redirectTo;
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function showRegistrationForm()
    {

        return view('auth.register'); //, (['sessions' => $sessions])
    }

    /**
     * Validate and create a newly registered user with session ?.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function registered(Request $request)
    {
        $validate = $this->validator($request->all());
        $user = $this->create($validate);

        Auth::login($user);

        // dd($request->all());

        return redirect()->route('sessiongameusers.create');
    }

    /**
     * Validator function
     *
     * @param array $input
     * @return void
     */
    public function validator(array $input)
    {
        return Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'date_of_birth'=>['required','date','before_or_equal:today'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone'=>['required', 'string','max:14'],
            'address'=>['required','string', 'max:255'],
            'postal_code' => ['required', 'string', 'min:3', 'max:8'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255']
        ])->validate();
    }

    /**
     * Create form function
     *
     * @param array $input
     * @return void
     */
    public function create(array $input)
    {
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
