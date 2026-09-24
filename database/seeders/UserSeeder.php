<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions (Fine-grain control for your HOA features)
        $permissions = [
            'dashboard',
            'profile.edit',
            'profile.update',
            'profile.destroy',
            'admin.users.index',
            'admin.users.create',
            'admin.users.store',
            'admin.users.edit',
            'admin.users.update',
            'admin.users.delete',
            'task.index',
            'task.create',
            'task.store',
            'task.edit',
            'task.update',
            'task.destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Roles and Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // Give admin all permissions
        $admin = Permission::all();
        $adminRole->givePermissionTo($admin);



        $userRole = Role::firstOrCreate(['name' => 'user']);
        // Give members specific low-level permissions
        $userRole->givePermissionTo([
            'dashboard', 
            'profile.edit', 
            'profile.update', 
            'profile.destroy', 
            'task.index', 
            'task.create', 
            'task.store', 
            'task.edit', 
            'task.update', 
            'task.destroy'
        ]);

        // 3. Create Default Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@taskmanager.com'],
            [
                'name' => 'Task Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // 4. Create Default Member User
        $member = User::firstOrCreate(
            ['email' => 'user1@taskmanager.com'],
            [
                'name' => 'John User 1',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $member->assignRole('user');

        $member2 = User::firstOrCreate(
            ['email' => 'user2@taskmanager.com'],
            [
                'name' => 'Mark User 2',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $member2->assignRole('user');
    }
}
