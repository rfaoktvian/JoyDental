<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function editUserForm(Request $request, $id)
    {
        return view('partials.account-form', data: compact('user'));
    }
    public function addUserForm(Request $request)
    {
        return view('partials.add-user-form');
    }

    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('filter_role')) {
            $roles = is_array($request->filter_role)
                ? $request->filter_role
                : [$request->filter_role];
            $query->whereIn('role', $roles);
        }

        if ($request->filled('search')) {
            $keyword = "%{$request->search}%";
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword)
                    ->orWhere('nik', 'like', $keyword);
            });
        }

        if ($request->filled('sort_by')) {
            $order = $request->sort_order === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $order);
        }

        $users = $query->paginate(12);

        return view('admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|email',
            'nik' => 'required|string|unique:users,nik',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nik' => $validatedData['nik'],
            'password' => Hash::make($validatedData['password'])
        ]);
        return redirect()->route('admin.users')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,doctor,admin'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return response()->noContent();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return response()->noContent();
    }
}
