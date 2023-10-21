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
            'sidebar receipt',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
            ];
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
    }
}
