<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Novo Candidato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('candidatos.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="user_id" class="block font-medium text-sm text-gray-700">Associar ao Usuário:</label>
                            <select id="user_id" name="user_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror" required>
                                <option value="">Selecione um Usuário</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cpf" class="block font-medium text-sm text-gray-700">CPF:</label>
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telefone" class="block font-medium text-sm text-gray-700">Telefone:</label>
                            <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefone') border-red-500 @enderror">
                            @error('telefone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="endereco" class="block font-medium text-sm text-gray-700">Endereço:</label>
                            <textarea id="endereco" name="endereco" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('endereco') border-red-500 @enderror">{{ old('endereco') }}</textarea>
                            @error('endereco')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="formacao" class="block font-medium text-sm text-gray-700">Formação:</label>
                            <textarea id="formacao" name="formacao" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('formacao') border-red-500 @enderror">{{ old('formacao') }}</textarea>
                            @error('formacao')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="experiencia_profissional" class="block font-medium text-sm text-gray-700">Experiência Profissional:</label>
                            <textarea id="experiencia_profissional" name="experiencia_profissional" rows="5" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('experiencia_profissional') border-red-500 @enderror">{{ old('experiencia_profissional') }}</textarea>
                            @error('experiencia_profissional')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="habilidades" class="block font-medium text-sm text-gray-700">Habilidades (separadas por vírgula):</label>
                            <textarea id="habilidades" name="habilidades" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('habilidades') border-red-500 @enderror">{{ old('habilidades') }}</textarea>
                            @error('habilidades')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="curriculo" class="block font-medium text-sm text-gray-700">Currículo (texto ou link):</label>
                            <textarea id="curriculo" name="curriculo" rows="5" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('curriculo') border-red-500 @enderror">{{ old('curriculo') }}</textarea>
                            @error('curriculo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('candidatos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Candidato
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>