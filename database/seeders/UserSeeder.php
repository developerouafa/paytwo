<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\product;
use App\Models\profileclient;
use App\Models\section;
use App\Models\stockproduct;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create User
        $user = User::create([
            'name' => ['en' => 'ouafa', 'ar' => 'وفاء'],
            'phone' => '0582201021',
            'email' => 'SuperADMIN_TIK2023@gmail.com',
            'password' => Hash::make('202324tik@zAWy'),
            'roles_name' => ["owner"],
            'Status' => '1'
        ]);

        //* Create Client
        $user_id = User::latest()->first()->id;
        Client::create([
            'name' => 'client',
            'phone' => '0682201021',
            'email' => 'Clienttest@gmail.com',
            'password' => Hash::make('123456tik@&TpNg'),
            'user_id' => $user_id,
            'Status' => '1'
        ]);
        $client_id = Client::latest()->first()->id;
        profileclient::create([
            'client_id' => $client_id
        ]);

        //* Create section
        section::create([
            'name' => ['en' => 'sectionen1', 'ar' => 'sectionar1'],
            'user_id' => $user_id,
        ]);
        $section_id = section::latest()->first()->id;

        //* Create children section
        section::create([
            'name' => ['en' => 'childen1', 'ar' => 'childar1'],
            'parent_id' => $section_id,
            'user_id' => $user_id,
        ]);

        //* Create product
        product::create([
            'name' => ['en' => 'producten1', 'ar' => 'productar1'],
            'description' => ['en' => 'descriptionen1', 'ar' => 'descriptionar1'],
            'price' => '100',
            'user_id' => $user_id,
        ]);

        //* Create stockproduct
        $product_id = product::latest()->first()->id;
        stockproduct::create([
            'product_id'=> $product_id,
            'user_id' => $user_id,
        ]);

        //* Create Role Permissions
        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
