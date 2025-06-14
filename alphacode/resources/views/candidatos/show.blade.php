<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Candidato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informações do Usuário</h3>
                    <div class="mb-4">
                        <p><strong class="font-medium">Nome:</strong> {{ $candidato->user->name ?? 'N/A' }}</p>
                        <p><strong class="font-medium">Email:</strong> {{ $candidato->user->email ?? 'N/A' }}</p>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-6">Dados do Candidato</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong class="font-medium">CPF:</strong> {{ $candidato->cpf ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <p><strong class="font-medium">Telefone:</strong> {{ $candidato->telefone ?? 'Não informado' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p><strong class="font-medium">Endereço:</strong> {{ $candidato->endereco ?? 'Não informado' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p><strong class="font-medium">Formação:</strong></p>
                            <div class="bg-gray-100 p-3 rounded-md text-sm mt-1">{{ $candidato->formacao ?? 'Não informado' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <p><strong class="font-medium">Experiência Profissional:</strong></p>
                            <div class="bg-gray-100 p-3 rounded-md text-sm mt-1">{{ $candidato->experiencia_profissional ?? 'Não informado' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <p><strong class="font-medium">Habilidades:</strong></p>
                            <div class="bg-gray-100 p-3 rounded-md text-sm mt-1">{{ $candidato->habilidades ?? 'Não informado' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <p><strong class="font-medium">Currículo (Texto/Link):</strong></p>
                            <div class="bg-gray-100 p-3 rounded-md text-sm mt-1">{{ $candidato->curriculo ?? 'Não informado' }}</div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-2">
                        <a href="{{ route('candidatos.edit', $candidato) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Editar') }}
                        </a>
                        <a href="{{ route('candidatos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Voltar para a Lista') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>