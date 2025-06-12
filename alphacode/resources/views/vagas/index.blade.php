<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Vagas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('vagas.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Criar Nova Vaga') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('vagas.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="search" :value="__('Pesquisar')" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="$request->search" placeholder="Título ou Descrição" />
                            </div>
                            <div>
                                <x-input-label for="tipo_vaga" :value="__('Tipo de Contratação')" /> 
                                <select id="tipo_vaga" name="tipo_vaga" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Todos</option>
                                    <option value="CLT" {{ $request->tipo_vaga == 'CLT' ? 'selected' : '' }}>CLT</option>
                                    <option value="Pessoa Jurídica" {{ $request->tipo_vaga == 'Pessoa Jurídica' ? 'selected' : '' }}>Pessoa Jurídica</option>
                                    <option value="Freelancer" {{ $request->tipo_vaga == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Todos</option>
                                    <option value="ativa" {{ $request->status == 'ativa' ? 'selected' : '' }}>Ativa</option>
                                    <option value="pausada" {{ $request->status == 'pausada' ? 'selected' : '' }}>Pausada</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="order_by" :value="__('Ordenar por')" />
                                <select id="order_by" name="order_by" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="created_at" {{ $request->order_by == 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                                    <option value="titulo" {{ $request->order_by == 'titulo' ? 'selected' : '' }}>Título</option>
                                    <option value="tipo_vaga" {{ $request->order_by == 'tipo_vaga' ? 'selected' : '' }}>Tipo Contratação</option> 
                                    <option value="ativa" {{ $request->order_by == 'ativa' ? 'selected' : '' }}>Status</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="direction" :value="__('Direção')" />
                                <select id="direction" name="direction" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="desc" {{ $request->direction == 'desc' ? 'selected' : '' }}>Descendente</option>
                                    <option value="asc" {{ $request->direction == 'asc' ? 'selected' : '' }}>Ascendente</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="per_page" :value="__('Itens por Página')" />
                                <select id="per_page" name="per_page" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="10" {{ $request->per_page == '10' ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ $request->per_page == '20' ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $request->per_page == '50' ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $request->per_page == '100' ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button type="submit">
                                {{ __('Aplicar Filtros') }}
                            </x-primary-button>
                            <a href="{{ route('vagas.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Limpar Filtros') }}
                            </a>
                        </div>
                    </form>

                    <form id="bulkDeleteForm" action="{{ route('vagas.bulk-delete') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir as vagas selecionadas?');">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <x-primary-button type="submit" id="bulkDeleteButton" class="bg-red-600 hover:bg-red-700 disabled:opacity-50" disabled>
                                {{ __('Excluir Selecionadas') }}
                            </x-primary-button>
                        </div>
                    </form>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criada Em</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($vagas as $vaga)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="vaga_ids[]" value="{{ $vaga->id }}" class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vaga->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vaga->titulo }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vaga->tipo_vaga }}</td> 
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vaga->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $vaga->ativa ? 'Ativa' : 'Pausada' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $vaga->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('vagas.edit', $vaga) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</a>
                                                <form action="{{ route('vagas.destroy', $vaga) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Nenhuma vaga encontrada.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form> 

                    <div class="mt-4">
                        {{ $vagas->appends($request->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkDeleteButton = document.getElementById('bulkDeleteButton');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm'); 

    function updateBulkDeleteButtonState() {
        const checkedCount = Array.from(itemCheckboxes).filter(cb => cb.checked).length;
        bulkDeleteButton.disabled = checkedCount === 0;
    }

    bulkDeleteButton.addEventListener('click', function() {
        bulkDeleteForm.querySelectorAll('input[name="vaga_ids[]"]').forEach(input => input.remove());

        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'vaga_ids[]';     
                hiddenInput.value = checkbox.value; 
                bulkDeleteForm.appendChild(hiddenInput);
            }
        });

        if (confirm('Tem certeza que deseja excluir as vagas selecionadas? Esta ação é irreversível.')) {
            bulkDeleteForm.submit();
        }
    });

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateBulkDeleteButtonState();
        });
    }

    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                if (selectAllCheckbox) { 
                    selectAllCheckbox.checked = false;
                }
            } else {
                const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                if (selectAllCheckbox) { 
                    selectAllCheckbox.checked = allChecked;
                }
            }
            updateBulkDeleteButtonState();
        });
    });

    updateBulkDeleteButtonState(); 
});
    </script>
</x-app-layout>