<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create(['name' => 'view data']);

        // Tạo người dùng Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'spadmin@gmail.com',
            'password' => Hash::make('1234567'),
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        $superAdmin->assignRole($superAdminRole);

        // Tạo người dùng Students
        $student = User::factory()->create([
            'name' => 'Nguyễn Văn A',
            'email' => 'vana.student@gmail.com',
            'password' => Hash::make('12345'),
            'created_at' => now()
        ]);

        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo('view data');
        $student->assignRole($studentRole);
    }
}
