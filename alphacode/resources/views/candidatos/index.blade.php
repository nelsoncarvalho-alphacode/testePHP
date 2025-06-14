<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Candidatos') }}
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

                    <form method="GET" action="{{ route('candidatos.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Pesquisa Geral (Nome, Email, CPF, Telefone, Endereço)</label>
                                <input type="text" name="search" id="search"
                                       value="{{ $request->input('search') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="formacao_filter" class="block text-sm font-medium text-gray-700">Filtrar por Formação</label>
                                <input type="text" name="formacao_filter" id="formacao_filter"
                                       value="{{ $request->input('formacao_filter') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="habilidade_filter" class="block text-sm font-medium text-gray-700">Filtrar por Habilidade</label>
                                <input type="text" name="habilidade_filter" id="habilidade_filter"
                                       value="{{ $request->input('habilidade_filter') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Aplicar Filtros') }}
                            </button>
                            <a href="{{ route('candidatos.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Limpar Filtros') }}
                            </a>
                        </div>
                    </form>
                    <form id="bulk-delete-form" method="POST" action="{{ route('candidatos.bulk_destroy') }}" onsubmit="return confirmBulkDelete();">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4 flex justify-between items-center">
                            <a href="{{ route('candidatos.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Novo Candidato') }}
                            </a>
                            <button type="submit" id="bulk-delete-button"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest opacity-50 cursor-not-allowed"
                                    disabled>
                                {{ __('Excluir Selecionados') }}
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left">
                                            <input type="checkbox" id="select-all-candidatos" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telefone
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Ações</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($candidatos as $candidato)
                                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="ids[]" value="{{ $candidato->id }}" class="candidato-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $candidato->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $candidato->user->email ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $candidato->telefone ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end">
                                                <a href="{{ route('candidatos.show', $candidato) }}" class="text-blue-600 hover:text-blue-900 mr-4">Ver</a>
                                                <a href="{{ route('candidatos.edit', $candidato) }}" class="text-yellow-600 hover:text-yellow-900 mr-4">Editar</a>
                                                <form action="{{ route('candidatos.destroy', $candidato) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este candidato?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Nenhum candidato encontrado.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $candidatos->links() }}
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all-candidatos');
            const itemCheckboxes = document.querySelectorAll('.candidato-checkbox'); 
            const bulkDeleteButton = document.getElementById('bulk-delete-button');  
            const bulkDeleteForm = document.getElementById('bulk-delete-form');      

            console.log('--- DOMContentLoaded Initial Check ---');
            console.log('selectAllCheckbox found:', selectAllCheckbox ? true : false);
            console.log('Number of itemCheckboxes found:', itemCheckboxes.length);
            console.log('bulkDeleteButton found:', bulkDeleteButton ? true : false);
            console.log('bulkDeleteForm found:', bulkDeleteForm ? true : false);
            console.log('------------------------------------');

            function updateBulkDeleteButtonState() {
                const checkedCount = Array.from(itemCheckboxes).filter(cb => cb.checked).length;
                console.log('updateBulkDeleteButtonState called. Checked count:', checkedCount);

                if (bulkDeleteButton) {
                    bulkDeleteButton.disabled = checkedCount === 0;
                    if (checkedCount === 0) {
                        bulkDeleteButton.classList.add('opacity-50', 'cursor-not-allowed');
                        bulkDeleteButton.classList.remove('hover:bg-red-700', 'focus:ring-2', 'focus:ring-red-500', 'focus:ring-offset-2');
                        console.log('Button disabled via JS.');
                    } else {
                        bulkDeleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        bulkDeleteButton.classList.add('hover:bg-red-700', 'focus:ring-2', 'focus:ring-red-500', 'focus:ring-offset-2');
                        console.log('Button enabled via JS.');
                    }
                } else {
                    console.error("bulkDeleteButton not found for state update!");
                }
            }

            if (selectAllCheckbox) { 
                selectAllCheckbox.addEventListener('change', function () {
                    console.log('selectAllCheckbox changed. New state:', this.checked);
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateBulkDeleteButtonState(); 
            } else {
                console.error("selectAllCheckbox element not found!");
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    console.log('Individual checkbox changed. ID:', checkbox.value, 'New state:', this.checked);
                    if (selectAllCheckbox) {
                        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                        console.log('selectAllCheckbox updated to:', allChecked);
                    }
                    updateBulkDeleteButtonState(); 
                });
            });

            updateBulkDeleteButtonState();
            console.log('Initial button state set.');
        });

        function confirmBulkDelete() {
            const candidatoCheckboxes = document.querySelectorAll('.candidato-checkbox');
            const selectedCount = Array.from(candidatoCheckboxes).filter(checkbox => checkbox.checked).length;

            if (selectedCount === 0) {
                alert('Por favor, selecione pelo menos um candidato para excluir.');
                return false;
            }

            return confirm('Tem certeza que deseja excluir os ' + selectedCount + ' candidatos selecionados? Esta ação não pode ser desfeita.');
        }
    </script>
    @endpush
</x-app-layout>