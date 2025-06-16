<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Vaga;
use App\Services\Operations;
use Illuminate\Support\Facades\Date;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $itemsPerPage = request('items_per_page', 20);

        if (session('user.type') == 'empresa') {
            // Carrega as vagas do usuário
            $vagas = Empresa::find($id)
                ->vagas()
                ->whereNull('deleted_at')
                ->paginate($itemsPerPage);
        } else {
            $candidato = Candidato::find($id);

            $vagasIncritas = $candidato
                ->vagas()
                ->pluck('vagas.id');

            $vagas = Vaga::whereNull('deleted_at')
                ->whereNotIn('id', $vagasIncritas)
                ->paginate($itemsPerPage);
        }

        // exibe a home
        return view('home', [
            'vagas' => $vagas,
            'user' => session('user.type')
        ]);
    }

    public function newVaga()
    {
        // exibe view para criar nova vaga
        return view('new_vaga');
    }

    public function newVagaSubmit(Request $request)
    {
        // validar requisição
        $request->validate(
            // rules
            [
                'text_title' => 'required | min:3 | max:200',
                'text_vaga' => 'required | min:3 | max:3000',
                'select_regime' => 'required',
            ],
            // error messages
            [
                'text_title.required' => 'O título não pode estar vazio.',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_vaga.required' => 'A descrição não pode estar vazia.',
                'text_vaga.min' => 'A descrição deve ter no mínimo :min caracteres.',
                'text_vaga.max' => 'A descrição deve ter no máximo :max caracteres.',
            ]
        );

        // pega o id do user logado
        $id = session('user.id');

        // cria uma nova vaga
        $vaga = new Vaga();
        $vaga->empresa_id = $id;
        $vaga->title = $request->text_title;
        $vaga->text = $request->text_vaga;
        $vaga->regime = $request->select_regime;
        $vaga->save();

        // redireciona para a home
        return redirect()->route('home');
    }

    public function editVaga($id)
    {
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega vaga
        $vaga = Vaga::find($id);
        // verifica se vaga existe no banco
        if (!$vaga) {
            return redirect()->route('home');
        }

        // exibe a view para editar vaga
        return view('edit_vaga', ['vaga' => $vaga]);
    }

    public function editVagaSubmit(Request $request)
    {
        // validate request
        $request->validate(
            // regras
            [
                'text_title' => 'required | min:3 | max:200',
                'text_vaga' => 'required | min:3 | max:3000',
            ],
            // error messages
            [
                'text_title.required' => 'O título não pode estar vazio.',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_vaga.required' => 'A descrição não pode estar vazia.',
                'text_vaga.min' => 'A descrição deve ter no mínimo :min caracteres.',
                'text_vaga.max' => 'A descrição deve ter no máximo :max caracteres.',
            ]
        );

        // verifica se o id da vaga existe
        if ($request->vaga_id == null) {
            return redirect()->route('home');
        }

        // desencripta vaga_id
        $id = Operations::decryptValue($request->vaga_id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega a vaga
        $vaga = Vaga::find($id);

        // verifica se vaga existe no banco
        if (!$vaga) {
            return redirect()->route('home');
        }

        // atualiza vaga
        $vaga->title = $request->text_title;
        $vaga->text = $request->text_vaga;
        $vaga->regime = $request->select_regime;
        $vaga->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function deleteVaga($id)
    {
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // Carrega vagas criadas
        $vaga = Vaga::find($id);

        // confirmação exclusão de vagas
        return view('delete_vaga', ['vaga' => $vaga]);
    }

    public function deleteVagaConfirm($id)
    {
        // desencripta id
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega vaga
        $vaga = Vaga::find($id);

        $vaga->delete();

        return redirect()->route('home');
    }

    public function newCandidato()
    {
        // exibe view para criar novo candidato
        return view('new_candidato');
    }

    public function newCandidatoSubmit(Request $request)
    {
        // validar requisição
        $request->validate(
            [
                'name' => 'required|min:3|max:100',
                'username' => 'required|email|max:50',
                'password' => 'required|min:6|confirmed'
            ],
            [
                'name.required' => 'O nome não pode estar vazio.',
                'name.min' => 'O nome deve ter no mínimo :min caracteres.',
                'name.max' => 'O nome deve ter no máximo :max caracteres.',

                'username.required' => 'O email não pode estar vazio.',
                'username.email' => 'Informe um email válido.',
                'username.max' => 'O email deve ter no máximo :max caracteres.',

                'password.required' => 'A senha não pode estar vazia.',
                'password.min' => 'A senha deve ter no mínimo :min caracteres.',
                'password.confirmed' => 'A confirmação da senha não corresponde.'
            ]
        );

        // criar novo candidato
        $candidato = new Candidato;
        $candidato->name = $request->name;
        $candidato->username = $request->username;
        $candidato->password = bcrypt($request->password);
        $candidato->save();

        // redirecionar para home
        return redirect()->route('home');
    }

    public function editCandidato($id)
    {
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega candidato
        $candidato = Candidato::find($id);

        // verifica se candidato existe no banco
        if (!$candidato) {
            return redirect()->route('home');
        }

        // exibe a view para editar candidato
        return view('edit_candidato', ['candidato' => $candidato]);
    }

    public function editCandidatoSubmit(Request $request)
    {
        // validar requisição
        $request->validate(
            // regras
            [
                'name' => 'required | min:3 | max:100',
                'username' => 'required | email | max:50',
                'password' => 'required | min:6 | confirmed'
            ],
            // error messages
            [
                'name.required' => 'O nome não pode estar vazio.',
                'name.min' => 'O nome deve ter no mínimo :min caracteres.',
                'name.max' => 'O nome deve ter no máximo :max caracteres.',

                'username.required' => 'O email não pode estar vazio.',
                'username.email' => 'Informe um email válido.',
                'username.max' => 'O email deve ter no máximo :max caracteres.',

                'password.required' => 'A senha não pode estar vazia.',
                'password.min' => 'A senha deve ter no mínimo :min caracteres.',
                'password.confirmed' => 'A confirmação da senha não corresponde.'
            ]
        );

        // desencripta vaga_id
        $id = Operations::decryptValue($request->candidato_id);

        // verifica se o id existe
        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega o candidato
        $candidato = Candidato::find($id);

        // verifica se candidato existe no banco
        if (!$candidato) {
            return redirect()->route('home');
        }

        // atualiza candidato
        $candidato->name = $request->name;
        $candidato->username = $request->username;
        $candidato->password = bcrypt($request->password);
        $candidato->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function deleteCandidato($id)
    {
        // desencripta id do candidato
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // Carrega candidato
        $candidato = Candidato::find($id);

        // confirmação exclusão da conta
        return view('delete_candidato', ['candidato' => $candidato]);
    }

    public function deleteCandidatoConfirm($id)
    {
        // desencripta id do candidato
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // carrega candidato
        $candidato = Candidato::find($id);

        $candidato->delete();

        // exclui a sessão
        // logout da aplicação
        session()->forget('user');
        return redirect()->to('/login');

        // return redirect()->route('login');
    }

    public function inscreverVaga($id)
    {
        // desencripta id do candidato
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // Carrega vaga
        $vaga = Vaga::find($id);

        // verifica se a vaga existe no banco
        if (!$vaga) {
            return redirect()->route('home');
        }

        // confirmação de inscrição
        return view('subscription_confirm', ['vaga' => $vaga]);
    }

    public function inscreverVagaConfirm($id)
    {
        // desencripta id da vaga
        $vagaId = Operations::decryptValue($id);

        if ($vagaId === null) {
            return redirect()->route('home');
        }

        // Pega id do candidato da sessão
        $candidatoId = session('user.id');

        // Carrega candidato
        $candidato = Candidato::find($candidatoId);

        // verifica se candidato existe no banco
        if (!$candidato) {
            return redirect()->route('home');
        }

        // Faz a inscrição na vaga (adiciona na tabela candidato_vaga)
        // Impede inscrições duplicadas
        if (!$candidato->vagas->contains($vagaId)) {
            $candidato->vagas()->attach($vagaId);
        }

        return redirect()->route('subscriptions')->with('success', 'Inscrição realizada com sucesso!');
    }

    public function subscriptions()
    {
        // Pega id do candidato da sessão
        $candidatoId = session('user.id');

        // Carrega candidato
        $candidato = Candidato::find($candidatoId);

        // Verifica se candidato existe no banco
        if (!$candidato) {
            return redirect()->route('home');
        }

        $itemsPerPage = request('items_per_page', 20);

        $vagas = $candidato
            ->vagas()
            ->paginate($itemsPerPage);

        return view('subscriptions', ['vagas' => $vagas]);
    }

    public function cancelSubscription($id)
    {
        // desencripta id do candidato
        $id = Operations::decryptValue($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        // Carrega vaga
        $vaga = Vaga::find($id);

        // verifica se vaga existe no banco
        if (!$vaga) {
            return redirect()->route('home');
        }

        return view('subscription_cancel_confirm', ['vaga' => $vaga]);
    }

    public function cancelSubscriptionConfirm($id)
    {
        // desencripta id da vaga
        $vagaId = Operations::decryptValue($id);

        // verifica se o id é nulo
        if ($vagaId === null) {
            return redirect()->route('home');
        }

        // Pega id do candidato da sessão
        $candidatoId = session('user.id');

        // Carrega candidato e vaga
        $candidato = Candidato::find($candidatoId);
        $vaga = Vaga::find($vagaId);

        // verifica se candidato e vaga existem no banco
        if (!$candidato || !$vaga) {
            return redirect()->route('home');
        }

        $candidato->vagas()->detach($vagaId);

        return redirect()->route('home')->with('success', 'Inscrição cancelada!');
    }
}
