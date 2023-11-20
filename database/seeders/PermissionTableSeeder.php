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
            //! Dashboard Users
            'Header Page Dashboard',

            //! Users
            'sidebar users & permissions',
            'sidebar users',
            'sidebar Deleted users',
            'Create User',
            'Show users',
            'Show users softdelete',
            'Edit User',
            'Delete User',
            'Delete All Users softdelete',
            'Delete All Users',
            'Delete Group Users',
            'Delete Group Users softdelete',
            'Restore One User',
            'Restore Group Users',
            'Restore All Users',
            'Delete One User softdelete',

            //! Permissions
            'sidebar permissions',
            'Create role',
            'Show roles',
            'Modify roles',
            'Delete role',

            //! Sections
            'sidebar Section & Children',
            'sidebar section',
            'sidebar Deleted sections',
            'Delete Group Section softdelete',
            'Delete One Section softdelete',
            'Delete All Section softdelete',
            'Restore All Section',
            'Restore One Section',
            'Restore Group Section',
            'Create Section',
            'Delete All Section',
            'Delete Group Section',
            'Show Section',
            'Show Section softdelete',
            'Edit Section',
            'Delete Section',

            //! Children
            'sidebar children',
            'sidebar Deleted childrens',
            'Create Children Section',
            'Delete Group Children Section',
            'Show Children Section',
            'Show Children Section softdelete',
            'Edit Children Section',
            'Delete Children Section',
            'Delete All Children',
            'Delete All Children softdelete',
            'Delete Group Children softdelete',
            'Restore All Children',
            'Restore Group Children',
            'Restore One Children',
            'Delete Children softdelete',

            //! Product
            'sidebar products',
            'sidebar Deleted products',
            'Show main&multip images products',
            'Edit main image Product',
            'Delete main image Product',
            'Edit multip image Product',
            'Delete multip image Product',
            'Delete all image Product',
            'Create Image Gallary Product',
            'Create Product',
            'Delete All Product',
            'Delete All Product softdelete',
            'Restore All Product',
            'Restore One Product',
            'Restore Group Product',
            'Delete Group Product',
            'Delete Group Product softdelete',
            'Delete Product softdelete',
            'Show Product',
            'Edit Product',
            'Delete Product',
            'promotion Product',
            'stock Product',
            'Show Promotions',
            'Update Promotion',
            'Delete Promotion',
            'Delete All Promotions',
            'Delete Group Promotions',

            //! Clients
            'sidebar clients',
            'sidebar Deleted clients',
            'Create Client',
            'Delete Group Client',
            'Show Client',
            'Show Client softdelete',
            'Edit Client',
            'Delete Client',
            'Delete Group Clients softdelete',
            'Restore All Clients',
            'Restore Group Clients',
            'Restore One Clients',
            'Delete Clients softdelete',
            'Delete All Clients',
            'Delete All Clients softdelete',
            'View Invoices Client',

            //! Group Services
            'sidebar Group Services',
            'Delete All GroupServices',
            'Delete All GroupServices softdelete',
            'Show Group Services',
            'Show Group Services softdelete',
            'Edit Group Services',
            'Delete Group Services',
            'Delete Group GroupServices softdelete',
            'Restore All GroupServices',
            'Restore Group GroupServices',
            'Delete GroupServices One softdelete',
            'Restore One GroupServices',

            //! Receipt
            'sidebar receipt & Payment',
            'sidebar receipt',
            'sidebar Deleted receipt',
            'Delete Group Receipt softdelete',
            'Restore All Receipt',
            'Restore Group Receipt',
            'Restore One Receipt',
            'Delete Receipt softdelete',
            'Create Receipt',
            'Delete All Receipt',
            'Delete Group Receipt',
            'Show Receipt',
            'Edit Receipt',
            'Delete Receipt',
            'Print Receipt',

            //! Catch Payment
            'sidebar Payment',
            'sidebar Deleted Payment',
            'Create Catch Payment',
            'Delete All Catch Payment',
            'Delete All Catch Payment softdelete',
            'Delete Group Catch Payment',
            'Show Catch Payment',
            'Edit Catch Payment',
            'Print Catch Payment',
            'Delete Catch Payment',
            'Delete Group Catch Payment softdelete',
            'Restore All Catch Payment',
            'Restore Group Catch Payment',
            'Restore One Catch Payment',
            'Delete Catch Payment softdelete',

            //! Bank Tranktransfer
            'sidebar Bank Tranktransfer',
            'sidebar Deleted Bank Tranktransfer',
            'Delete All Bank Tranktransfer',
            'Delete All Bank Tranktransfer softdelete',
            'Delete Group Bank Tranktransfer',
            'Delete Group Bank Tranktransfer softdelete',
            'Restore All Bank Tranktransfer',
            'Restore Group Bank Tranktransfer',
            'Restore One Bank Tranktransfer',
            'Delete Bank Tranktransfer softdelete',
            'Show Bank Tranktransfer',
            'Show Bank Tranktransfer softdelete',
            'Delete Bank Tranktransfer',
            'Print Bank Tranktransfer',

            //! Bank Card
            'sidebar Bank Card',
            'sidebar Deleted Bank Card',
            'Delete All Bank Card',
            'Delete All Bank Card softdelete',
            'Delete Group Bank Card',
            'Delete Group Bank Card softdelete',
            'Restore All Bank Card',
            'Restore Group Bank Card',
            'Restore One Bank Card',
            'Delete Bank Card softdelete',
            'Show Bank Card',
            'Show Bank Card softdelete',
            'Delete Bank Card',
            'Print Bank Card',

            //! Single Invoices
            'sidebar Invoices Singleservice & groupservice',
            'sidebar Details => Invoices Singleservice & groupservice',
            'sidebar Singleservice',
            'sidebar Details Singleservice',
            'sidebar Deleted Singleservice',
            'Delete Group SingleInvoice',
            'Delete All SingleInvoice',
            'Delete All SingleInvoice softdelete',
            'Delete Group SingleInvoice softdelete',
            'Sent Invoices Group SingleInvoice',
            'Restore All SingleInvoice',
            'Restore Group SingleInvoice',
            'Restore One SingleInvoice',
            'Show Single Invoices softdelete',
            'Delete Single Invoices softdelete',
            'Show Single Invoices',
            'Create Single Invoices',
            'Edit Single Invoices',
            'Delete Single Invoices',
            'Print Single Invoices',

            //! Group Invoices
            'sidebar groupservice',
            'sidebar Details groupservice',
            'sidebar Deleted groupservice',
            'sidebar Details GroupServices',
            'sidebar Deleted GroupServices',
            'Show Group Invoices softdelete',
            'Delete Group Invoices softdelete',
            'Create Group Invoices',
            'Show Group Invoices',
            'Edit Group Invoices',
            'Delete Group Invoices',
            'Print Group Invoices',
            'Delete Group GroupInvoice softdelete',
            'Delete Group GroupServices',
            'Delete All GroupInvoice',
            'Delete All GroupInvoice softdelete',
            'Delete Group GroupInvoice',
            'Restore All GroupInvoice',
            'Restore Group GroupInvoice',
            'Restore One GroupInvoice',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
