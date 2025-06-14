<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Vaga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sucesso!</strong>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Erro!</strong>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $vaga->titulo }}</h1>
                            <p class="text-gray-600 mb-1"><strong>Tipo de Contratação:</strong> {{ $vaga->tipo_vaga }}</p>
                            <p class="text-gray-600 mb-1"><strong>Localização:</strong> {{ $vaga->localizacao }}</p>
                            <p class="text-gray-600 mb-1"><strong>Salário:</strong> {{ $vaga->salario ? 'R$ ' . number_format($vaga->salario, 2, ',', '.') : 'A combinar' }}</p>
                            <p class="text-gray-600 mb-1"><strong>Status:</strong>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vaga->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $vaga->ativa ? 'Ativa' : 'Pausada' }}
                                </span>
                            </p>
                            <p class="text-gray-600"><strong>Criada em:</strong> {{ $vaga->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="flex gap-4">
                            @can('update', $vaga)
                                <a href="{{ route('vagas.edit', $vaga->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Editar Vaga') }}
                                </a>
                            @endcan

                            @can('delete', $vaga)
                                <form action="{{ route('vagas.destroy', $vaga->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta vaga?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Deletar Vaga') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Descrição:</h3>
                    <p class="text-gray-700 mb-6">{{ $vaga->descricao }}</p>

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Requisitos:</h3>
                    <p class="text-gray-700 mb-6">{{ $vaga->requisitos }}</p>

                    <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ações da Vaga</h3>
                        @auth
                            @if (Auth::user()->candidato)
                                @php
                                    $hasApplied = Auth::user()->candidato->applications->where('vaga_id', $vaga->id)->isNotEmpty();
                                @endphp

                                @if ($hasApplied)
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                        {{ __('Já Candidatado') }}
                                    </button>
                                    <p class="text-sm text-gray-600 mt-2">Você já se candidatou a esta vaga.</p>
                                @else
                                    <form action="{{ route('applications.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="vaga_id" value="{{ $vaga->id }}">
                                        <input type="hidden" name="candidato_id" value="{{ Auth::user()->candidato->id }}">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('Candidatar-se a esta Vaga') }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <p class="text-sm text-gray-600">Esta é uma visualização da vaga. Como recrutador, você não se candidata.</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-600">
                                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Faça login</a> ou
                                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">registre-se</a> para se candidatar a esta vaga.
                            </p>
                        @endauth
                    </div>

                    @auth
                        @if (!Auth::user()->candidato)
                            <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Candidaturas Recebidas</h3>

                                @if ($vaga->applications->isEmpty())
                                    <p class="text-gray-600">Ainda não há candidaturas para esta vaga.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidato</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data da Candidatura</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($vaga->applications as $application)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            <a href="{{ route('applications.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                                {{ $application->candidato->user->name ?? 'N/A' }}
                                                            </a>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $application->candidato->user->email ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $application->created_at->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                @if($application->status == 'aprovado') bg-green-100 text-green-800
                                                                @elseif($application->status == 'rejeitado') bg-red-100 text-red-800
                                                                @elseif($application->status == 'em_analise') bg-blue-100 text-blue-800
                                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{ route('applications.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver/Gerenciar</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('vagas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Voltar para a Lista de Vagas') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
