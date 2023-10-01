<?php

namespace Database\Seeders;

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
            'name' => 'ouafa',
            'phone' => '0682201021',
            'email' => 'ouafa@gmail.com',
            'password' => Hash::make('123456'),
            'roles_name' => ["Admin"]
        ]);

            $role = Role::create(['name' => 'Admin']);

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
    }
}
