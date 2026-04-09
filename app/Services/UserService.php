<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function create(array $data): User
    {
        $role = $data['role'] ?? null;
        unset($data['role']);

        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        if ($role) {
            $user->assignRole($role);
        }

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $role = $data['role'] ?? null;
        unset($data['role']);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->userRepository->update($user, $data);

        if ($role) {
            $user->syncRoles([$role]);
        }

        return $user;
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    public function suspend(User $user): User
    {
        return $this->userRepository->update($user, [
            'status' => UserStatus::Suspended->value,
        ]);
    }

    public function activate(User $user): User
    {
        return $this->userRepository->update($user, [
            'status' => UserStatus::Active->value,
        ]);
    }

    public function syncRoles(User $user, array $roles): User
    {
        $user->syncRoles($roles);

        return $user->fresh();
    }

    public function uploadAvatar(User $user, UploadedFile $file): User
    {
        $extension = $file->getClientOriginalExtension();
        $path = "avatars/{$user->id}.{$extension}";

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));

        return $this->userRepository->update($user, ['avatar' => $path]);
    }
}
