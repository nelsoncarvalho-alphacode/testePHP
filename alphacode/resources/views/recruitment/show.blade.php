<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Candidatura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sucesso!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Erro!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Validação falhou!</strong>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Candidatura de {{ $application->candidato->user->name ?? 'N/A' }} para a Vaga: {{ $application->vaga->titulo }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">Detalhes do Candidato</h2>
                            <p class="text-gray-700 mb-2"><strong>Nome:</strong> {{ $application->candidato->user->name ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Email:</strong> {{ $application->candidato->user->email ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Telefone:</strong> {{ $application->candidato->telefone ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Cidade:</strong> {{ $application->candidato->cidade ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Formação:</strong> {{ $application->candidato->formacao_academica ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Experiência:</strong> {{ $application->candidato->experiencia_profissional ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-2"><strong>Habilidades:</strong> {{ $application->candidato->habilidades ?? 'N/A' }}</p>
                            {{-- TODO: Adicionar link para ver perfil completo do candidato se existir --}}
                            {{-- Ex: <a href="{{ route('candidatos.show', $application->candidato->id) }}" class="text-blue-600 hover:text-blue-800 mt-2 block">Ver Perfil Completo</a> --}}
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">Detalhes da Vaga</h2>
                            <p class="text-gray-700 mb-2"><strong>Título:</strong> {{ $application->vaga->titulo }}</p>
                            <p class="text-gray-700 mb-2"><strong>Localização:</strong> {{ $application->vaga->localizacao }}</p>
                            <p class="text-gray-700 mb-2"><strong>Tipo de Vaga:</strong> {{ $application->vaga->tipo_vaga }}</p>
                            <p class="text-gray-700 mb-2"><strong>Salário:</strong> {{ $application->vaga->salario ? 'R$ ' . number_format($application->vaga->salario, 2, ',', '.') : 'A combinar' }}</p>
                            {{-- TODO: Adicionar link para ver detalhes da vaga --}}
                            <a href="{{ route('vagas.show', $application->vaga->id) }}" class="text-blue-600 hover:text-blue-800 mt-2 block">Ver Detalhes da Vaga</a>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Status e Observações da Candidatura</h2>
                    <form action="{{ route('applications.update', $application->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT') {{-- Ou PATCH --}}

                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status da Candidatura')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="pendente" {{ $application->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="em análise" {{ $application->status == 'em análise' ? 'selected' : '' }}>Em Análise</option>
                                <option value="aprovada" {{ $application->status == 'aprovada' ? 'selected' : '' }}>Aprovada</option>
                                <option value="rejeitada" {{ $application->status == 'rejeitada' ? 'selected' : '' }}>Rejeitada</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="observacoes" :value="__('Observações')" />
                            <textarea id="observacoes" name="observacoes" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('observacoes', $application->observacoes) }}</textarea>
                            <x-input-error :messages="$errors->get('observacoes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Atualizar Candidatura') }}
                            </x-primary-button>
                            <a href="{{ route('vagas.show', $application->vaga->id) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Voltar para a Vaga') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>