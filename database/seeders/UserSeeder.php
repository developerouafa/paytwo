<?php

namespace Database\Seeders;

use App\Models\profileuser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => ['en' => 'ouafa', 'ar' => 'وفاء'],
            'phone' => '0682201021',
            'email' => 'ouafa@gmail.com',
            'password' => Hash::make('123456'),
            'roles_name' => ["Admin"]
        ]);

        $user_id = User::latest()->first()->id;
        profileuser::create([
            'user_id' => $user_id,
            // 'clienType' => 'clienType',
            // 'nationalIdNumber' => 'nationalIdNumber',
            // 'commercialRegistrationNumber' => 'commercialRegistrationNumber',
            // 'taxNumber' => 'taxNumber',
            // 'adderss' => 'adderss',
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}