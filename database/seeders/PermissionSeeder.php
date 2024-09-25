<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $createRole = Permission::firstOrCreate([
            'name' => 'create-roles',
            'description' => 'Allows creating roles',
        ]);

        $editRole = Permission::firstOrCreate([
            'name' => 'edit-roles',
            'description' => 'Allows editing roles',
        ]);

        $viewRole = Permission::firstOrCreate([
            'name' => 'view-roles',
            'description' => 'Allows view roles',
        ]);

        $deleteRole = Permission::firstOrCreate([
            'name' => 'delete-roles',
            'description' => 'Allows deleting roles',
        ]);

        $createPermission = Permission::firstOrCreate([
            'name' => 'create-permission',
            'description' => 'Allows creating permissions',
        ]);

        $editPermission = Permission::firstOrCreate([
            'name' => 'edit-permission',
            'description' => 'Allows editing permissions',
        ]);

        $viewPermission = Permission::firstOrCreate([
            'name' => 'view-permission',
            'description' => 'Allows view permissions',
        ]);

        $deletePermission = Permission::firstOrCreate([
            'name' => 'delete-permission',
            'description' => 'Allows deleting permissions',
        ]);

        $restore = Permission::firstOrCreate([
            'name' => 'restore',
            'description' => 'Allows restore data',
        ]);

        $forceDelete = Permission::firstOrCreate([
            'name' => 'permanently-delete',
            'description' => 'Allows permanently delete data',
        ]);

        $viewDeletedData = Permission::firstOrCreate([
            'name' => 'view-deleted-data',
            'description' => 'Allows view deleted data',
        ]);

        $createUser = Permission::firstOrCreate([
            'name' => 'create-user',
            'description' => 'Allows creating new users',
        ]);

        $viewUser = Permission::firstOrCreate([
            'name' => 'view-user',
            'description' => 'Allows viewing user details',
        ]);

        $editUserProfile = Permission::firstOrCreate([
            'name' => 'edit-user',
            'description' => 'Allows modifying user profile',
        ]);

        $deleteUser = Permission::firstOrCreate([
            'name' => 'delete-user',
            'description' => 'Allows removing users',
        ]);


        $createBooks = Permission::firstOrCreate([
            'name' => 'create-book',
            'description' => 'Allows adding new books to the system',
        ]);

        $viewBooks = Permission::firstOrCreate([
            'name' => 'view-book',
            'description' => 'Allows viewing book details',
        ]);

        $editBooks = Permission::firstOrCreate([
            'name' => 'edit-book',
            'description' => 'Allows modifying existing book details',
        ]);

        $deleteBooks = Permission::firstOrCreate([
            'name' => 'delete-book',
            'description' => 'Allows deleting books from the system',
        ]);

        $createCategory = Permission::firstOrCreate([
            'name' => 'create-category',
            'description' => 'Allows adding new categories to the system',
        ]);

        $viewCategory = Permission::firstOrCreate([
            'name' => 'view-category',
            'description' => 'Allows viewing category details',
        ]);

        $editCategory = Permission::firstOrCreate([
            'name' => 'edit-category',
            'description' => 'Allows modifying existing category details',
        ]);

        $deleteCategory = Permission::firstOrCreate([
            'name' => 'delete-category',
            'description' => 'Allows deleting categories from the system',
        ]);


        $admin->permissions()->attach([$createRole->id, $editRole->id, $viewRole->id, $deleteRole->id,
            $createPermission->id, $editPermission->id, $viewPermission->id, $deletePermission->id,
            $restore->id, $forceDelete->id, $viewDeletedData->id, $createUser->id,
            $viewUser->id, $editUserProfile->id, $deleteUser->id, $createBooks->id,
            $viewBooks->id, $editBooks->id, $deleteBooks->id, $createCategory->id,
            $viewCategory->id, $editCategory->id, $deleteCategory->id]);
    }
}
