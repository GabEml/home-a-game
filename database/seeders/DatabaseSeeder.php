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

        $userAdminDefis = New User;
        $userAdminDefis->firstname="Test";
        $userAdminDefis->lastname="Test";
        $userAdminDefis->email="test@test.com";
        $userAdminDefis->password=Hash::make("test");
        $userAdminDefis->date_of_birth=$date->format("Y-m-d");
        $userAdminDefis->phone="0678254697";
        $userAdminDefis->address="45 rue Paradis";
        $userAdminDefis->city="Paris";
        $userAdminDefis->country="France";
        $userAdminDefis->postal_code="79000";
        $userAdminDefis->role_id=2;
        $userAdminDefis->save();

        $userSuperAdmin = New User;
        $userSuperAdmin->firstname="Test";
        $userSuperAdmin->lastname="Test";
        $userSuperAdmin->email="test2@test.com";
        $userSuperAdmin->password=Hash::make("test");
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
