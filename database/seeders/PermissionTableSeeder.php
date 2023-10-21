<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'sidebar users & permissions',
            'sidebar users',
            'sidebar permissions',
            'sidebar Section & Children',
            'sidebar section',
            'sidebar children',
            'sidebar products',
            'sidebar clients',
            'sidebar Group Services',
            'sidebar Singleservice & groupservice',
            'sidebar Singleservice',
            'sidebar groupservice',
            'sidebar receipt & Payment',
            'sidebar receipt',
            'Create User',
            'Show users',
            'Edit User',
            'Delete User',
            'Delete Group User',
            'Delete All Promotions',
            'Delete Group Promotions',
            'Show Promotions',
            'Update Promotion',
            'Delete Promotion',
            'Create role',
            'Show roles',
            'Modify roles',
            'Delete role',
            ];

            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
    }
}
