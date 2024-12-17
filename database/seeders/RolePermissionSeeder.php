<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            'create transaction',
            'view transaction',
            'delete transaction',
            'manage users',
            // Add more permissions as needed
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['create transaction', 'view transaction', 'delete transaction', 'manage users']);

        $superAdmin = Role::create(['name' => 'superadmin']);
        $superAdmin->givePermissionTo(Permission::all()); // Superadmin has all permissions

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(['create transaction', 'view transaction']); // Users can only create and view transactions

        $user = User::find(1); // Find a user by ID
        $user->assignRole('admin'); // Assign the admin role

        $user2 = User::find(2);
        $user2->assignRole('user'); // Assign the user role

    }
}
