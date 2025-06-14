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
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Sucesso!</strong>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Erro!</strong>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Validação falhou!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Candidatura para: <a href="{{ route('vagas.show', $application->vaga->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $application->vaga->titulo }}</a></h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-gray-600 mb-2"><strong>Candidato:</strong> {{ $application->candidato->user->name ?? 'N/A' }}</p>
                            <p class="text-gray-600 mb-2"><strong>Email do Candidato:</strong> {{ $application->candidato->user->email ?? 'N/A' }}</p>
                            <p class="text-gray-600 mb-2"><strong>Data da Candidatura:</strong> {{ $application->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-gray-600 mb-2"><strong>Status Atual:</strong>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($application->status == 'aprovado') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejeitado') bg-red-100 text-red-800
                                    @elseif($application->status == 'em_analise') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </span>
                            </p>
                             <a class="text-indigo-600 hover:text-indigo-900 text-sm" href=" {{route('candidatos.edit', Auth::user()->candidato) }} ">Meu curriculo</a>
                        </div>
                    </div>

                    @can('update', $application)
                        <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Atualizar Status da Candidatura</h3>
                            <form action="{{ route('applications.update', $application->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Novo Status:</label>
                                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="em_analise" {{ $application->status == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                                        <option value="aprovado" {{ $application->status == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                        <option value="rejeitado" {{ $application->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                    </select>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Atualizar Status') }}
                                </button>
                            </form>
                        </div>
                    @endcan

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('vagas.show', $application->vaga->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Voltar para a Vaga') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
