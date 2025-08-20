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
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O email deve ser válido.',
                'email.unique' => 'Este email já está sendo utilizado.',
            ]);

            User::create($data);

            return response()->json([
                'success' => true, 
                'message' => 'Usuário cadastrado com sucesso!',
                'redirect' => route('home')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar usuário: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O email deve ser válido.',
                'email.unique' => 'Este email já está sendo utilizado.',
            ]);

            $user->update($data);

            return response()->json([
                'success' => true, 
                'message' => 'Usuário atualizado com sucesso!',
                'redirect' => route('home')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar usuário: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Usuário excluído com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir usuário: ' . $e->getMessage()], 500);
        }
    }

    public function sortearAmigo()
    {
        $users = User::all();
        
        if ($users->count() < 2) {
            return view('pages.users.draw_friend', compact('users'));
        }
        
        // Faz o sorteio completo
        $userList = $users->toArray();
        $shuffledUsers = collect($userList)->shuffle();
        $pairs = [];
        
        // Cria pares de sorteio
        for ($i = 0; $i < count($userList); $i++) {
            $currentUser = $userList[$i];
            $nextIndex = ($i + 1) % count($userList);
            $drawnUser = $userList[$nextIndex];
            
            $pairs[] = [
                'giver' => $currentUser,
                'receiver' => $drawnUser
            ];
        }
        
        // Embaralha os pares para maior aleatoriedade
        $pairs = collect($pairs)->shuffle();
        
        return view('pages.users.draw_friend', compact('pairs', 'users'));
    }

    private function getUsers(Request $request)
    {
        return User::when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    }
}
