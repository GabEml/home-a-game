<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Sessiongame;
use App\Models\SessiongameUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUsers()
    {
        $this->authorize('viewAny', User::class);
        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"User")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return view('superadmin.users', ['users'=>$users]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdminChallenge()
    {
        
        $this->authorize('viewAny', User::class);
        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"Admin Défis")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return view('superadmin.adminchallenge', ['users'=>$users]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSuperAdmin()
    {
        $this->authorize('viewAny', User::class);
        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"Super Admin")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return view('superadmin.superadmin', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $dateNow = new DateTime;

        $roles= Role::all();
        $sessiongames = Sessiongame::where("end_date" , '>' ,$dateNow)->get();
        return view('superadmin.create',['roles'=>$roles,'sessiongames'=>$sessiongames]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validateData=$request->validate([
            'user' => 'required|integer|exists:users,id',
        ]);

        $idUser=$validateData["user"];
        $user = User::where('id', $idUser)->first();

        return redirect()->route('users.edit', ['user'=>$user]);
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

        $validateData=$request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth'=>'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255| unique:users',
            'phone'=>'required| string|max:10',
            'address'=>'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'role_id'=> 'required|integer|exists:roles,id',
            'sessiongames' => 'exists:sessiongames,id|unique:sessiongame_user,user_id,sessiongame_id',
        ]);

        $user = new User();
        $user ->firstname = $validateData['firstname'];
        $user ->lastname = $validateData['lastname'];
        $user ->date_of_birth = $validateData['date_of_birth'];
        $user ->email = $validateData['email'];
        $user ->password = Hash::make($validateData['firstname'].$validateData['lastname']);
        $user ->phone = $validateData['phone'];
        $user ->address = $validateData['address'];
        $user ->postal_code = $validateData['postal_code'];
        $user ->role_id= $validateData['role_id'];
        $user ->city = $validateData['city'];
        $user ->country = $validateData['country'];

        $user->save();

        if ($request->filled('sessiongames')){
            for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
                $sessiongame=new SessiongameUser();
                $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
                $sessiongame->user_id = $user->id;
                $sessiongame->save();
            }
        }

        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"User")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return view('superadmin.users', ['users'=>$users]);

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('updateSuperAdmin', User::class);
        $dateNow = new DateTime;
        $sessionUser = $user->sessiongames->pluck('id');
        $sessiongames = Sessiongame::whereNotIn('id', $sessionUser)->where("end_date" , '>' ,$dateNow)->get();

        $sessiongamesUser = $user->sessiongames;

        return view('superadmin.edit', ['user'=>$user,'sessiongames'=>$sessiongames, 'sessiongamesUser'=>$sessiongamesUser]);
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
        $this->authorize('updateSuperAdmin', User::class);

        $validateData=$request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth'=>'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255', Rule::unique('users')->ignore($user->id),
            'phone'=>'required| string|max:10',
            'address'=>'required|string| max:255',
            'postal_code' => 'required| string| max:5',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
           
        ]);

        $user ->firstname = $validateData['firstname'];
        $user ->lastname = $validateData['lastname'];
        $user ->date_of_birth = $validateData['date_of_birth'];
        $user ->email = $validateData['email'];
        $user ->phone = $validateData['phone'];
        $user ->address = $validateData['address'];
        $user ->postal_code = $validateData['postal_code'];
        $user ->city = $validateData['city'];
        $user ->country = $validateData['country'];

        $user->update();

        return redirect()->route('users.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, User $user)
    {
        $this->authorize('updateSuperAdmin', User::class);

        $validateData=$request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            
        ]);
        
        $user->role_id = $validateData["role_id"];
        $user->update();
    
        return redirect()->route('users.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function storeSessionGame(Request $request, User $user)
    {
        $this->authorize('updateSuperAdmin', User::class);

        $validateData=$request->validate([
            'sessiongames' => 'required|exists:sessiongames,id|unique:sessiongame_user,user_id,sessiongame_id',
        ]);

        for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
            $sessiongame=new SessiongameUser();
            $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
            $sessiongame->user_id = $user->id;
            $sessiongame->save();
        }
        
        return redirect()->route('users.edit', ['user'=>$user]);
    }

    /**
     * Delete SessiongameUser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function deleteSessiongameUser(Request $request, SessiongameUser $sessiongameUser)
    {
        $this->authorize('updateSuperAdmin', User::class);

        $sessiongameUser->delete();
        $user=$sessiongameUser->user;
        
        return redirect()->route('users.edit', ['user'=>$user]);
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

        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"User")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return redirect()->route('users.indexUsers', ['users'=>$users]);

    }
}
