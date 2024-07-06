<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $editPermission = Permission::create(['name' => 'edit event']);
        $viewPermission = Permission::create(['name' => 'view event']);
        $createPermission = Permission::create(['name' => 'create event']);
        $deletePermission = Permission::create(['name' => 'delete event']);

        // Create Super Admin user
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'spadmin@gmail.com',
            'password' => Hash::make('1234567'),
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        $superAdmin->assignRole($superAdminRole);

        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234567'),
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([$viewPermission, $editPermission]);
        $admin->assignRole($adminRole);
    }
}
