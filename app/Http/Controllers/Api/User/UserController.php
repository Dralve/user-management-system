<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api');
    }

    /**
     * @return Collection|JsonResponse
     */
    public function index(): Collection|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-user')){
            return response()->json(['message' => 'You do not have permission to view users'], 403);
        }

        return $this->userService->getUsers();
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermission('create-user')){
            return response()->json(['message' => 'You do not have permission to create users'], 403);
        }

        $user = $this->userService->createUser($request->validated());
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);

    }

    /**
     * @param User $user
     * @return User|JsonResponse
     */
    public function show(User $user): User|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-user')){
            return response()->json(['message' => 'You do not have permission to show users'], 403);
        }

        return $this->userService->showUser($user);
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if (auth()->user()->id !== $user->id) {
            return response()->json(['message' => 'You cannot update others user profile'], 403);
        }

        $data = $request->validated();
        $updatedUser = $this->userService->updateUser($user, $data);

        return response()->json(['message' => 'User updated successfully', 'user' => $updatedUser], 200);
    }

    /**
     * @param AssignRoleRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function assignRoles(AssignRoleRequest $request, User $user): JsonResponse
    {
        if (!auth()->user()->hasPermission('edit-roles')){
            return response()->json(['message' => 'You do not have permission to assign roles'], 403);
        }

        $assignRole = $this->userService->assignRolesToUsers($user, $request->validated());

        if (!$assignRole['success']) {
            return response()->json(['message' => $assignRole['message']], $assignRole['status']);
        }

        return response()->json(['message' => 'Roles updated successfully', 'roles' => $assignRole['roles']], 200);
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        if (!auth()->user()->hasPermission('delete-user')){
            return response()->json(['message' => 'You do not have permission to delete users'], 403);
        }

        if (!auth()->user()->hasRole('admin') && auth()->user()->id !== $user->id){
            return response()->json(['message' => 'You do not have permission to delete others users'], 403);
        }

        $this->userService->deleteUser($user);
        return response()->json(['message' =>'User deleted successfully'], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to restore user'], 403);
        }

        $user = $this->userService->restoreUser($id);

        if (!$user){
            return response()->json(['message' => 'User not found or not deleted'], 404);
        }
        return response()->json(['message' => 'User restored successfully', 'user' => $user], 200);
    }

    /**
     * @return Collection|JsonResponse|array
     */
    public function getDeletedUsers(): Collection|JsonResponse|array
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to view deleted users'], 403);
        }

        return $this->userService->showDeletedUsers();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function forceDelete($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You do not have permission to delete users'], 403);
        }

       $user = $this->userService->permanentlyDeleteUser($id);
        if (!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
