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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@tdc',
            'password' => Hash::make('1234567'),
        ]);

        $role = Role::create(['name' => 'super-admin']);
        $user->assignRole($role);

        $user = User::factory()->create([
            'name' => 'Nguyễn Văn A',
            'email' => 'vana@tdc',
            'password' => Hash::make('12345'),
            'created_at' => now()
        ]);

        
    }
}
