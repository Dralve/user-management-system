<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class RoleController extends Controller
{
    protected RoleService $roleService;

    /**
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return Collection|JsonResponse
     */
    public function index(): Collection|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-roles')) {
            return response()->json(['message' => 'You do not have permission to view roles'], 403);
        }

        return $this->roleService->getRoles();

    }

    /**
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermission('create-roles')){
            return response()->json(['message' => 'You do not have permission to create roles'], 403);
        }

        $role = $this->roleService->createRole($request->validated());
        return response()->json(['message' => 'Role Created Successfully', 'role' => $role], 201);
    }

    /**
     * @param Role $role
     * @return JsonResponse|Role
     */
    public function show(Role $role): JsonResponse|Role
    {
        if (!auth()->user()->hasPermission('view-roles')){
            return response()->json(['message' => 'You do not have permission to view roles'], 403);
        }

        return $this->roleService->showRoles($role);
    }

    /**
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        if (!auth()->user()->hasPermission('edit-roles')){
            return response()->json(['message' => 'You do not have permission to edit roles'], 403);
        }

        $data = $request->validated();

        $updatedRole = $this->roleService->updateRole($role, $data);
        return response()->json(['message' => 'Role Updated Successfully', 'role' => $updatedRole], 200);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        if (!auth()->user()->hasPermission('delete-roles')){
            return response()->json(['message' => 'You do not have permission to delete roles'], 403);
        }

        $this->roleService->deleteRole($role);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}
