<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select(['id', 'name'])->get();
        $data = [
            'roles' => $roles,
        ];
        return Inertia::render('User/Form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Handled by model cast
        ]);

        // Sync selected roles
        if ($request->has('role_id')) {
            $user->syncRoles($request->role_id);
        }

        return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $userId)
    {
        $userId->load('roles');
        $roles = Role::select(['id', 'name'])->get();
        $data = [
            'roles' => $roles,
            'user' => [
                'id' => $userId->id,
                'name' => $userId->name,
                'email' => $userId->email,
                'role_id' => $userId->roles->first()?->id ?? null,
            ]
        ];
        return Inertia::render('User/Form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $userId)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $userId->update($data);

        // Sync roles on update
        $userId->syncRoles([$request->role_id]);

        return redirect()->route('admin.users.edit', ["userId" => $userId->id])->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
