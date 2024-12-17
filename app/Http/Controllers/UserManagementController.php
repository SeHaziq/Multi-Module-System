<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class UserManagementController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        // Apply middleware for roles and permissions management
        $this->middleware('auth');
        $this->middleware('role:admin|superadmin');
    }

    public function index()
    {
        $users = User::with('roles')->get();
        return view('usermanagements.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usermanagements.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Ensure password confirmation
            'role' => 'required|exists:roles,id', // Validate that the role exists by ID
        ]);

        // Create the user with the provided password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encrypt the password
        ]);

        // Retrieve the role by ID and assign it by name
        $role = Role::findOrFail($request->role);

        if ($role->guard_name !== 'web') {
            $role->guard_name = 'web'; // Ensure the guard is 'web'
            $role->save();
        }

        // Assign the role to the user
        $user->assignRole($role->name);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role->name,
            ])
            ->log("Created user '{$user->name}' with role '{$role->name}'.");

        return redirect()->route('usermanagements.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return view('usermanagements.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,id',
        ]);

        $oldRole = $user->roles->pluck('name')->first();
        $newRole = Role::findOrFail($request->role)->name;

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role
        $user->syncRoles([$newRole]);

        // Log the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'old_name' => $user->getOriginal('name'),
                'new_name' => $request->name,
                'old_email' => $user->getOriginal('email'),
                'new_email' => $request->email,
                'old_role' => $oldRole,
                'new_role' => $newRole,
            ])
            ->log("Updated user '{$user->name}'. Role changed from '{$oldRole}' to '{$newRole}'.");

        return redirect()->route('usermanagements.index')->with('success', 'User updated successfully.');
    }

    public function show($id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);
        return view('usermanagements.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Log the activity before deleting the user
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')->toArray(),
            ])
            ->log("Deleted user '{$user->name}' with roles: " . implode(', ', $user->roles->pluck('name')->toArray()));

        $user->delete();

        return redirect()->route('usermanagements.index')->with('success', 'User deleted successfully.');
    }
}
