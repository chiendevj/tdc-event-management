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
        $restorePermisstion = Permission::create(['name' => 'restore event']);
        $cancelPermission = Permission::create(['name' => 'cancel event']);
        $qrPermission = Permission::create(['name' => 'qr event']);
        $featuredPermission = Permission::create(['name' => 'featured event']);

        // Create Super Admin user
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'event@fit.tdc.edu.vn', // edit mail of supper admin here
            'password' => Hash::make('fittdc@2024'),
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        $superAdmin->assignRole($superAdminRole);

        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'dat61222@gmail.com',
            'password' => Hash::make('1234567'),
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([$viewPermission, $editPermission, $createPermission, $deletePermission, $cancelPermission, $qrPermission, $featuredPermission]);
        $admin->assignRole($adminRole);
    }
}
