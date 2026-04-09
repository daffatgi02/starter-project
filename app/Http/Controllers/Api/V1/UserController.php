<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('roles')->latest()->paginate(15);

        return UserResource::collection($users);
    }

    public function store(Request $request): UserResource
    {
        $this->authorize('create', User::class);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['sometimes', 'exists:roles,name'],
        ]);

        $user = $this->userService->create($validated);

        return new UserResource($user->load('roles'));
    }

    public function show(User $user): UserResource
    {
        $this->authorize('view', $user);
        return new UserResource($user->load('roles'));
    }

    public function update(Request $request, User $user): UserResource
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'exists:roles,name'],
        ]);

        $user = $this->userService->update($user, $validated);

        return new UserResource($user->load('roles'));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $this->userService->delete($user);

        return response()->json(['message' => 'User deleted.']);
    }
}
