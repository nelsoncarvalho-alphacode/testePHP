<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules; 
use Illuminate\Support\Facades\Hash; 

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        Gate::authorize('viewAny', User::class);

        $query = User::query();

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        if ($request->has('role') && $request->input('role') != '') {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users', 'request'));
    }

     public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin', // Aqui a role é fixada como 'admin'
            ]);

            // Garante que não será criado um perfil de Candidato para este Admin
            if ($user->candidato) {
                $user->candidato->delete();
            }

            return redirect()->route('admin.users.index')->with('success', 'Novo administrador criado com sucesso!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Erro ao criar novo administrador: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao criar o novo administrador.');
        }
    }

    public function updateRole(Request $request, User $user)
    {
        Gate::authorize('update', $user); 

        try {
            $request->validate([
                'role' => 'required|in:candidato,recrutador',
            ]);

            $user->role = $request->role;
            $user->save();

            if ($user->role === 'recrutador' && $user->candidato) {
                $user->candidato->delete();
            }
          
            else if ($user->role === 'candidato' && !$user->candidato) {
                \App\Models\Candidato::create(['user_id' => $user->id]);
            }

            return redirect()->back()->with('success', 'Perfil do usuário atualizado com sucesso!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar perfil do usuário {$user->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o perfil do usuário.');
        }
    }
}
