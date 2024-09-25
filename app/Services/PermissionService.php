<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{

    public function getPermissions(): Collection
    {
        return Permission::all();
    }

    public function showPermission(Permission $permission): Permission
    {
        return $permission->load('roles');
    }

    public function createPermission(array $data)
    {
        $permission = Permission::create($data);

        if (isset($data['roles']) && is_array($data['roles'])){
            foreach ($data['roles'] as $role){
                if (isset($role['role_id'])){
                    $permission->roles()->attach($role['role_id']);
                }
            }
        }
        return $permission;
    }

    public function updatePermission(Permission $permission, array $data): Permission
    {
        $permission->update($data);

        if (isset($data['roles']) && is_array($data['roles'])){
            $syncData = [];

            foreach ($data['roles'] as $role){
                if (isset($role['role_id'])){
                    $syncData[] = $role['role_id'];
                }
            }
            $permission->roles()->sync($syncData);
        }

        $permission->load('roles:id,name');
        return $permission;
    }

    public function deletePermission(Permission $permission): void
    {
        $permission->delete();
    }

    public function restorePermission($id)
    {
        $permission = Permission::onlyTrashed()->find($id);

        if ($permission){
            $permission->restore();
        }
        return $permission;
    }

    public function showDeletedPermissions(): array|Collection
    {
        return Permission::onlyTrashed()->get();
    }

    public function permanentlyDelete($id): bool
    {
        $permission = Permission::withTrashed()->find($id);

        if ($permission){
            $permission->forceDelete();
            return true;
        }
            return false;
    }
}
