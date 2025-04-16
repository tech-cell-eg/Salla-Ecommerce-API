<?php

namespace App\Repositories;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        $user= User::create($data);
        $userRole = Role::where('name','user')->first();
        $user->assignRole( $userRole);
        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}