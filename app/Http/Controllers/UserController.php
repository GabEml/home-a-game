<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Sessiongame;
use App\Models\SessiongameUser;
use App\Notifications\Sessiongame as NotificationsSessiongame;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use App\Notifications\DeleteUser as NotificationsDeleteUser;

use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Http\Controllers\Api\UserCsv;

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
     * Search users
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $key = $request->searchUser;

        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"User")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();

        $usersSearch = User::select('users.id','lastname','firstname','email')
                ->where('roles.role',"User")
                ->where(function($query) use($key){
                    $query->orWhere('lastname', 'like', "%{$key}%")
                          ->orWhere('firstname', 'like', "%{$key}%")
                          ->orWhere('email', 'like', "%{$key}%");
                })
            ->join('roles','roles.id', '=', 'users.role_id')
            ->get();
        
        return view('superadmin.search', ['users'=>$users,'usersSearch'=>$usersSearch]);
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

        $arrSessiongame=array();

        $validateData=$request->validate([
            'firstname' => 'required| string| max:255',
            'lastname' => 'required| string| max:255',
            'date_of_birth'=>'required|date|before_or_equal:today',
            'email' => 'required| string| email| max:255| unique:users',
            'phone'=>'required| string|max:14',
            'address'=>'required|string| max:255',
            'postal_code' => 'required| string| min:3 | max:8',
            'city' => 'required| string| max:255',
            'country' => 'required| string| max:255',
            'role_id'=> 'required|integer|exists:roles,id',
            'sessiongame_id' => "exists:sessiongames,id",
        ]);

        $user = new User();
        $user ->firstname = $validateData['firstname'];
        $user ->lastname = $validateData['lastname'];
        $user ->date_of_birth = $validateData['date_of_birth'];
        $user ->email = $validateData['email'];
        $user ->password = Hash::make(Str::random(12));
        $user ->phone = $validateData['phone'];
        $user ->address = $validateData['address'];
        $user ->postal_code = $validateData['postal_code'];
        $user ->role_id= $validateData['role_id'];
        $user ->city = $validateData['city'];
        $user ->country = $validateData['country'];

        $user->save();

        $token = Str::random(60);
        $tokenHash = Hash::make($token);
        DB::table('password_resets')->insert([
                 'email' => $user->email, 
                 'token' => $tokenHash, 
                 'created_at' => Carbon::now()->timezone('Europe/Paris')
               ]);
       
       $user->sendPasswordResetNotificationAdmin($token,Auth::user()->email);

        if ($request->filled('sessiongame_id')){
            for ($i = 0; $i < sizeof($validateData["sessiongame_id"]); $i++) {
                $sessiongameUserExist = SessiongameUser::where('user_id',$user->id )->where('sessiongame_id',$validateData["sessiongame_id"][$i])->first();
                if($sessiongameUserExist!=Null){
                    continue;
                }
                $sessiongame=new SessiongameUser();
                $sessiongame->sessiongame_id = $validateData["sessiongame_id"][$i];
                $sessiongame->user_id = $user->id;
                $sessiongame->save();

                array_push($arrSessiongame, $sessiongame->sessiongame->name . " ", "et");
            }
                array_pop($arrSessiongame);
                $user->notify(new NotificationsSessiongame($arrSessiongame, "athomeagame@gmail.com", $user->firstname . " " . $user->lastname ));
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
            'phone'=>'required| string|max:14',
            'address'=>'required|string| max:255',
            'postal_code' => 'required| string| min:3 | max:8',
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

        $arrSessiongame=array();
        
        $validateData=$request->validate([
            'sessiongame_id' => "required|exists:sessiongames,id",
        ]);

        for ($i = 0; $i < sizeof($validateData["sessiongame_id"]); $i++) {
            $sessiongameUserExist = SessiongameUser::where('user_id',$user->id )->where('sessiongame_id',$validateData["sessiongame_id"][$i])->first();
            if($sessiongameUserExist!=Null){
                continue;
            }
            $sessiongame=new SessiongameUser();
            $sessiongame->sessiongame_id = $validateData["sessiongame_id"][$i];
            $sessiongame->user_id = $user->id;
            $sessiongame->save();
            array_push($arrSessiongame, $sessiongame->sessiongame->name . " ", "et");
        }
            array_pop($arrSessiongame);
            $user->notify(new NotificationsSessiongame($arrSessiongame, "athomeagame@gmail.com", $user->firstname . " " . $user->lastname ));
        
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
        $user->notify(new NotificationsDeleteUser($user->firstname . " " . $user->lastname));

        $users= DB::table('users')
        ->select("users.id", "firstname", "lastname")
        ->where('roles.role',"User")
        ->join('roles','roles.id', '=', 'users.role_id')
        ->get();
        
        return redirect()->route('users.indexUsers', ['users'=>$users]);

        //print_r($user);
    }


    /**
     * get all users and render
     * @param Request $request
     */
    public function indexListUsers(Request $request) {

        $currentValues = $request->all();
        $userRoles = $this->getAllRoles();
        $filteredUsers = $this->filteredUsers($currentValues);
        $allUsers = $this->filteredUsers($currentValues, false, true);

        // dd($userRoles);

        return view('superadmin.list-users', compact('currentValues', 'filteredUsers', 'userRoles', 'allUsers'));
    }

    /**
     *  Get users by filter
     * @param Request $currentValues
     * @param Boolean $paginate
     */
    public function filteredUsers($currentValues, $paginate = true, $allUsers = false) {

        if($allUsers == true) {
            $filteredUsers = DB::table('users')
            ->join('roles','roles.id', '=', 'users.role_id')
            ->select('*')
            ->get();
        } else {
            if(count($currentValues) > 0 && !isset($currentValues['page'])) {
                $query = DB::table('users')
                ->join('roles','roles.id', '=', 'users.role_id')
                ->select('*');

                if($currentValues['role'] != "Any Role") {
                    $query->where("role", "=", $currentValues['role']);
                }
            } else {
                $query = DB::table('users')
                ->select('*');
            } 

            if($paginate === true) {
                if(isset($currentValues['paginate']) == null) {
                    $filteredUsers = $query->paginate(100);
                } else {
                    $filteredUsers = $query->paginate($currentValues['paginate']);
                }
            } else {
                $filteredUsers = $query->get();
            }
        }

        return $filteredUsers;
    }

     /**
     *  Get all users role
     */
    public function getAllRoles() {
        $userRoles = [];

        $query = DB::table('roles')
        ->select('*');
       
        $roles = $query->get();

        if(count($roles) > 1 && $roles) {
            foreach($roles as $role) {
                if(!in_array($role->role, $userRoles)) {
                    array_push($userRoles, $role->role);
                }  
            }
        }

        return $userRoles;
    }

    /**
     * Generate csv file for users
     * @param Request $request
     */
    public function usersCsv(Request $request) {
        // dd($request);
        $currentValues = $request->all();
        $users = $this->filteredUsers($currentValues, false);
        $userApi = new UserCsv();

        // dd($userApi);
        $file = $userApi->generateCsv($users);
        if (is_array($file) && $file['error']) {
            return redirect()->back()->with([
                'message'   => $file['message']
            ]);
        } else {
            return $file;
        }
    }
}