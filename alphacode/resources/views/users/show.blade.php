<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Usuário</h3>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nome:</label>
                        <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Email:</label>
                        <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">ID:</label>
                        <p class="mt-1 text-gray-900">{{ $user->id }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Criado em:</label>
                        <p class="mt-1 text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700">Última atualização:</label>
                        <p class="mt-1 text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            Editar Usuário
                        </a>
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Voltar para a Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>