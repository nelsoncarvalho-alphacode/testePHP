<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated(); 

        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao criar o usuário. Tente novamente.');
        }
    }

 
     public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
         return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        try {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

            if (isset($validatedData['password']) && !empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário ' . $user->id . ': ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar o usuário. Tente novamente.');
        }
    }

    public function destroy(User $user) 
    {
        try {
            $user->delete(); 

            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao excluir usuário ' . $user->id . ': ' . $e->getMessage());

            return redirect()->route('users.index')->with('error', 'Ocorreu um erro ao excluir o usuário. Tente novamente.');
        }
    }
}
