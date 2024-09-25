<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    /**
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('auth:api');
    }


    /**
     * @return JsonResponse|Collection
     */
    public function index(): JsonResponse|Collection
    {
        if (!auth()->user()->hasPermission('view-permission')){
            return response()->json(['message' => 'You do not have permission to view permissions'], 403);
        }

        return $this->permissionService->getPermissions();
    }

    /**
     * @param PermissionRequest $request
     * @return JsonResponse
     */
    public function store(PermissionRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermission('create-permission')){
            return response()->json(['message' => 'You do not have permission to create permissions'], 403);
        }

        $permission = $this->permissionService->createPermission($request->validated());
        return response()->json(['message' => 'Permission created successfully.', 'permission' => $permission], 201);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse|Permission
     */
    public function show(Permission $permission): JsonResponse|Permission
    {
        if (!auth()->user()->hasPermission('view-permission')){
            return response()->json(['message' => 'You do not have permission to view permissions'], 403);
        }

        return $this->permissionService->showPermission($permission);
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return JsonResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        if (!auth()->user()->hasPermission('edit-permission')){
            return response()->json(['message' => 'You do not have permission to edit permissions'], 403);
        }

        $data = $request->validated();
        $updatedPermission = $this->permissionService->updatePermission($permission, $data);
        return response()->json(['message' => 'Permission updated successfully.', 'permission' => $updatedPermission], 200);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        if (!auth()->user()->hasPermission('delete-permission')){
            return response()->json(['message' => 'You do not have permission to delete permissions'], 403);
        }

        $this->permissionService->deletePermission($permission);
        return response()->json(['message' => 'Permission deleted successfully.']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to restore permissions'], 403);
        }

        $permission = $this->permissionService->restorePermission($id);

        if ($permission){
            return response()->json(['message' => 'Permission restored successfully', 'permission' => $permission], 200);
        }
            return response()->json(['message' => 'Permission not found or not deleted'], 404);
    }

    /**
     * @return JsonResponse
     */
    public function getDeletedPermissions(): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to view deleted permissions'], 403);
        }

        $deletedPermissions = $this->permissionService->showDeletedPermissions();
        return response()->json(['message' => 'Delete permissions', 'permission' => $deletedPermissions], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function forceDelete($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to delete permissions'], 403);
        }

        $permission = $this->permissionService->permanentlyDelete($id);
        if (!$permission){
            return response()->json(['message' => 'Permission not found'], 404);
        }

        return response()->json(['message' => 'Permission permanently deleted'], 200);
    }
}
