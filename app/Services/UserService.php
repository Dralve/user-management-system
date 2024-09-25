<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{

    public function getUsers(): Collection
    {
        return User::all();
    }

    public function showUser(User $user): User
    {
        return $user->load('roles:name');
    }

    public function createUser(array $data)
    {
        $user = User::create($data);

        if (isset($data['roles']) && is_array($data['roles'])){
            foreach ($data['roles'] as $role){
                if (isset($role['role_id'])){
                    $user->roles()->attach($role['role_id']);
                }
            }
        }

        return $user;
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);

        return $user;
    }

    public function assignRolesToUsers(User $user, array $data): array
    {
        $roleIds = collect($data['roles'] ?? [])
            ->pluck('role_id')
            ->filter()
            ->all();

        if (empty($roleIds)) {
            return [
                'success' => false,
                'message' => 'No valid role IDs provided',
                'status' => 400
            ];
        }

        $user->roles()->sync($roleIds);

        return [
            'success' => true,
            'roles' => $user->roles()->get()->toArray()
        ];
    }


    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);

        if ($user){
            $user->restore();
        }
        return $user;
    }

    public function showDeletedUsers(): array|Collection
    {
        return User::onlyTrashed()->get();
    }

    public function permanentlyDeleteUser($id)
    {
        $user = User::withTrashed()->find($id);

        if ($user){
            $user->forceDelete();
        }
        return $user;
    }
}
