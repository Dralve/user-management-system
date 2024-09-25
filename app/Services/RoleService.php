<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RoleService
{

    public function getRoles(): Collection
    {
        return Role::all();
    }

    public function showRoles(Role $role): Role
    {
        $role->load(['permissions' => function ($query) {
            $query->select('permissions.id', 'permissions.name', 'permissions.description');
        }]);

        return $role;
    }

    public function createRole(array $data)
    {
        $role = Role::create($data);

            if (isset($data['permissions']) && is_array($data['permissions'])){
                foreach ($data['permissions'] as $permission){
                    if (isset($permission['permission_id'])){
                        $role->permissions()->attach($permission['permission_id']);
                    }
                }
            }

        return $role;
    }

    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);

        if (isset($data['permissions']) && is_array($data['permissions'])){
            $syncData = [];

            foreach ($data['permissions'] as $permission){
                if (isset($permission['permission_id'])){
                    $syncData[] = $permission['permission_id'];
                }
            }
            $role->permissions()->sync($syncData);
        }

        $role->load(['permissions:id,name,description']);
        return $role;
    }

    public function deleteRole(Role $role): void
    {
        $role->delete();
    }
}
