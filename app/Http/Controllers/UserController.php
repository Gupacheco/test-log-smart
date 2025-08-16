<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function users(Request $request)
    {
        $users = $this->getUsers($request);

        return view('pages.tableUsers', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request)
    {
        dd($request->toArray());
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function sortearAmigo()
    {
        $users = User::all();
        $randomUser = $users->random();

        return view('pages.users.draw_friend', compact('randomUser'));
    }

    private function getUsers(Request $request)
    {
        return User::when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
