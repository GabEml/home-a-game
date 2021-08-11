<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use DateTime;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $roleUser = New Role;
        $roleUser->id = 1;
        $roleUser->role = "User";
        $roleUser->save();

        $roleAdminDefis = New Role;
        $roleAdminDefis->id = 2;
        $roleAdminDefis->role = "Admin Défis";
        $roleAdminDefis->save();

        $roleSuperAdmin = New Role;
        $roleSuperAdmin->id = 3;
        $roleSuperAdmin->role = "Super Admin";
        $roleSuperAdmin->save();


        $date= new DateTime;

        $user = New User;
        $user->firstname="Toto";
        $user->lastname="Toto";
        $user->email="toto@toto.com";
        $user->password=Hash::make("toto");
        $user->date_of_birth=$date->format("Y-m-d");
        $user->phone="0678254697";
        $user->address="45 rue Paradis";
        $user->city="Paris";
        $user->country="France";
        $user->postal_code="79000";
        $user->role_id=1;
        $user->save();

        $userAdminDefis = New User;
        $userAdminDefis->firstname="Admin Defis";
        $userAdminDefis->lastname="Admin Defis";
        $userAdminDefis->email="admin@defi.com";
        $userAdminDefis->password=Hash::make("admindefis");
        $userAdminDefis->date_of_birth=$date->format("Y-m-d");
        $userAdminDefis->phone="0678254697";
        $userAdminDefis->address="45 rue Paradis";
        $userAdminDefis->city="Paris";
        $userAdminDefis->country="France";
        $userAdminDefis->postal_code="79000";
        $userAdminDefis->role_id=2;
        $userAdminDefis->save();

        $userSuperAdmin = New User;
        $userSuperAdmin->firstname="Super Admin";
        $userSuperAdmin->lastname="Super Admin";
        $userSuperAdmin->email="super@admin.com";
        $userSuperAdmin->password=Hash::make("superadmin");
        $userSuperAdmin->date_of_birth=$date->format("Y-m-d");
        $userSuperAdmin->phone="0678254697";
        $userSuperAdmin->address="45 rue Paradis";
        $userSuperAdmin->city="Paris";
        $userSuperAdmin->country="France";
        $userSuperAdmin->postal_code="79000";
        $userSuperAdmin->role_id=3;
        $userSuperAdmin->save();
    }
}
