<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUsers()
    {
        // $this->authorize('viewAny', User::class);
        $users = DB::table('users')
            ->select("users.id", "firstname", "lastname")
            ->where('roles.role', "User")
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->get();

        return $this->sendResponse($users, 'Users list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdminChallenge()
    {

        $this->authorize('viewAny', User::class);
        $users = DB::table('users')
            ->select("users.id", "firstname", "lastname")
            ->where('roles.role', "Admin Défis")
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->get();

        return $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSuperAdmin()
    {
        $this->authorize('viewAny', User::class);
        $users = DB::table('users')
            ->select("users.id", "firstname", "lastname")
            ->where('roles.role', "Super Admin")
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->get();

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return $this->sendResponse($user, 'User find successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNewUser(Request $request)
    {
        $this->authorize('create', User::class);

        $validateData = $request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255| unique:users',
            'phone' => 'required| string|max:10',
            'address' => 'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        $user = new User();
        $user->firstname = $validateData['firstname'];
        $user->lastname = $validateData['lastname'];
        $user->date_of_birth = $validateData['date_of_birth'];
        $user->email = $validateData['email'];
        $user->password = Hash::make($validateData['firstname'] . $validateData['lastname']);
        $user->phone = $validateData['phone'];
        $user->address = $validateData['address'];
        $user->postal_code = $validateData['postal_code'];
        $user->role_id = $validateData['role_id'];
        $user->city = $validateData['city'];
        $user->country = $validateData['country'];

        $user->save();

        return [$user, response()->json([
            "message" => "Utilisateur créé"
        ])];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255| unique:users',
            'phone' => 'required| string|max:10',
            'address' => 'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'password' => 'required',
        ]);

        $user = new User();
        $user->firstname = $validateData['firstname'];
        $user->lastname = $validateData['lastname'];
        $user->date_of_birth = $validateData['date_of_birth'];
        $user->email = $validateData['email'];
        $user->phone = $validateData['phone'];
        $user->address = $validateData['address'];
        $user->postal_code = $validateData['postal_code'];
        $user->password =  Hash::make($validateData['password']);
        $user->city = $validateData['city'];
        $user->country = $validateData['country'];
        $user->role_id = 1;

        $user->save();
        
        $token = $user->createToken("token");

        return ['token' => $token->plainTextToken];

        // return [$user, response()->json([
        //     "message" => "Utilisateur créé"])];
    }

    /**
     * storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // $validateData=$request->validate([
        //     'email' => 'required| string| email| max:255| unique:users',
        //     'password'=> 'required',
        // ]);

        // $user->save();
        // $user = User::where([["email",$request->input('email')],["password",Hash::make($request->input('password'))]])->first();

        $user = User::where("email",$request->input('email'))->first();

        if($user == null) {
            return $this->sendError('User not found', 'User not found');
        }

        $password = Hash::make($request->input('password'));
        $tokenresult = null;

        if(password_verify($request->input('password'), $user->password)) {
            $token = $user->createToken("token");
            $tokenresult = $token->plainTextToken;
        }        else {
            return $this->sendError('Password is not matching', 'Password is not matching');
        }

        return  $this->sendResponse(['id' => $user->id,'token' => $tokenresult], 'Token');

        // return [$test, response()->json([
        //     "message" => "OK"])];
    }

    /**
     * storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = User::where("email", $request->input('email'))->first();

        $user->tokens()->delete();

        $this->sendResponse('Deco', 'Déconnexion réussie');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, User $user)
    {
        $this->authorize('updateSuperAdmin', User::class);

        $validateData = $request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255', Rule::unique('users')->ignore($user->id),
            'phone' => 'required| string|max:10',
            'address' => 'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'role_id' => 'required|integer|exists:roles,id',

        ]);

        $user->firstname = $validateData['firstname'];
        $user->lastname = $validateData['lastname'];
        $user->date_of_birth = $validateData['date_of_birth'];
        $user->email = $validateData['email'];
        $user->phone = $validateData['phone'];
        $user->address = $validateData['address'];
        $user->postal_code = $validateData['postal_code'];
        $user->city = $validateData['city'];
        $user->country = $validateData['country'];
        $user->role_id = $validateData["role_id"];

        $user->update();

        return [$user, response()->json([
            "message" => "Utilisateur modifié"
        ])];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);

        $validateData = $request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255', Rule::unique('users')->ignore($user->id),
            'phone' => 'required| string|max:10',
            'address' => 'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'password' => 'required',

        ]);

        $user->firstname = $validateData['firstname'];
        $user->lastname = $validateData['lastname'];
        $user->date_of_birth = $validateData['date_of_birth'];
        $user->email = $validateData['email'];
        $user->phone = $validateData['phone'];
        $user->address = $validateData['address'];
        $user->postal_code = $validateData['postal_code'];
        $user->city = $validateData['city'];
        $user->country = $validateData['country'];
        $user->password =  Hash::make($validateData['password']);

        $user->update();

        return [$user, response()->json([
            "message" => "Utilisateur modifié"
        ])];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $user->tokens->each->delete();
        $user->delete();

        return [$user, response()->json([
            "message" => "Utilisateur supprimé"
        ])];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyUser(User $user)
    {
        $this->authorize('deleteSuperAdmin', User::class);

        $user->tokens->each->delete();
        $user->delete();

        return [$user, response()->json([
            "message" => "Utilisateur supprimé"
        ])];
    }
}
