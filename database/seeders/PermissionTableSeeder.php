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
            'sidebar Deleted sections',
            'sidebar children',
            'sidebar Deleted childrens',
            'sidebar products',
            'sidebar Deleted products',
            'sidebar clients',
            'sidebar Deleted clients',
            'sidebar Group Services',
            'sidebar Invoices Singleservice & groupservice',
            'sidebar Details => Invoices Singleservice & groupservice',
            'sidebar Singleservice',
            'sidebar Details Singleservice',
            'sidebar groupservice',
            'sidebar Details groupservice',
            'sidebar receipt & Payment',
            'sidebar receipt',
            'sidebar Deleted receipt',
            'sidebar Payment',
            'sidebar Deleted Payment',
            'sidebar Bank Tranktransfer',
            'sidebar Deleted Bank Tranktransfer',
            'sidebar Bank Card',
            'sidebar Deleted Bank Card',
            'Create User',
            'Show users',
            'Edit User',
            'Delete User',
            'Delete Group User',
            'Delete All Promotions',
            'Delete Group Promotions',
            'Delete Group SingleInvoice',
            'Delete All SingleInvoice',
            'Show Promotions',
            'Update Promotion',
            'Delete Promotion',
            'Create role',
            'Show roles',
            'Modify roles',
            'Delete role',
            'Create Section',
            'Delete All Section',
            'Delete Group Section',
            'Show Section',
            'Edit Section',
            'Delete Section',
            'Create Children Section',
            'Delete Group Children Section',
            'Show Children Section',
            'Edit Children Section',
            'Delete Children Section',
            'Create Client',
            'Delete All Client',
            'Delete Group Client',
            'Show Client',
            'Edit Client',
            'Delete Client',
            'Show main&multip images products',
            'Edit main image Product',
            'Edit multip image Product',
            'Delete multip image Product',
            'Delete all image Product',
            'Create Image Gallary Product',
            'Create Catch Payment',
            'Delete All Catch Payment',
            'Delete Group Catch Payment',
            'Show Catch Payment',
            'Edit Catch Payment',
            'Print Catch Payment',
            'Delete Catch Payment',
            'Create Product Product',
            'Delete All Product',
            'Delete Group Product',
            'Show Product',
            'Edit Product',
            'Delete Product',
            'promotion Product',
            'stock Product',
            'Create Receipt',
            'Delete All Receipt',
            'Delete All Bank Tranktransfer',
            'Delete All Bank Card',
            'Delete Group Receipt',
            'Delete Group Bank Tranktransfer',
            'Delete Group Bank Card',
            'Show Receipt',
            'Show Bank Tranktransfer',
            'Show Bank Card',
            'Edit Receipt',
            'Delete Receipt',
            'Delete Bank Tranktransfer',
            'Delete Bank Card',
            'Print Receipt',
            'Print Bank Tranktransfer',
            'Print Bank Card',
            'Create Group Invoices',
            'Show Group Invoices',
            'Edit Group Invoices',
            'Delete Group Invoices',
            'Print Group Invoices',
            'Show Single Invoices',
            'Create Single Invoices',
            'Edit Single Invoices',
            'Delete Single Invoices',
            'Print Single Invoices',
            'Show Group Services',
            'Edit Group Services',
            'Delete Group Services',
            'View Invoices Client'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
