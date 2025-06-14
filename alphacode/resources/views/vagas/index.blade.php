<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vagas Disponíveis') }}
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

                    <div class="mb-6">
                        <form action="{{ route('vagas.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                            <div class="flex-grow">
                                <label for="search" class="block text-sm font-medium text-gray-700">Buscar por Título/Descrição</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ex: Desenvolvedor, Suporte..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="tipo_vaga" class="block text-sm font-medium text-gray-700">Tipo de Contratação</label>
                                <select name="tipo_vaga" id="tipo_vaga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Todos</option>
                                    <option value="CLT" {{ request('tipo_vaga') == 'CLT' ? 'selected' : '' }}>CLT</option>
                                    <option value="Pessoa Jurídica" {{ request('tipo_vaga') == 'Pessoa Jurídica' ? 'selected' : '' }}>PJ</option>
                                    <option value="Freelancer" {{ request('tipo_vaga') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                                </select>
                            </div>

                            @auth
                                @if (!Auth::user()->candidato)
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status da Vaga</label>
                                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Todos</option>
                                            <option value="ativa" {{ request('status') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                                            <option value="pausada" {{ request('status') == 'pausada' ? 'selected' : '' }}>Pausada</option>
                                        </select>
                                    </div>
                                @endif
                            @endauth

                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 h-10">
                                    {{ __('Filtrar') }}
                                </button>
                                <a href="{{ route('vagas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 h-10">
                                    {{ __('Limpar Filtros') }}
                                </a>
                            </div>
                        </form>
                    </div>

                    @auth
                        @if (!Auth::user()->candidato)
                            <div class="mb-6 flex justify-between items-center">
                                @can('create', App\Models\Vaga::class)
                                    <a href="{{ route('vagas.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Criar Nova Vaga') }}
                                    </a>
                                @endcan

                                @can('delete', App\Models\Vaga::class)
                                    <form id="bulk-delete-form" action="{{ route('vagas.bulk-delete') }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja excluir as vagas selecionadas?');">
                                            {{ __('Excluir Selecionadas') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif
                    @endauth

                    @if ($vagas->isEmpty())
                        <p class="text-gray-600">Nenhuma vaga encontrada.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @auth
                                            @if (!Auth::user()->candidato)
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <input type="checkbox" id="select-all-vagas" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </th>
                                            @endif
                                        @endauth
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('vagas.index', array_merge(request()->except('order_by', 'direction'), ['order_by' => 'titulo', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                {{ __('Título') }}
                                                @if (request('order_by') == 'titulo')
                                                    {!! request('direction') == 'asc' ? '&uarr;' : '&darr;' !!}
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('vagas.index', array_merge(request()->except('order_by', 'direction'), ['order_by' => 'tipo_vaga', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                {{ __('Tipo') }}
                                                @if (request('order_by') == 'tipo_vaga')
                                                    {!! request('direction') == 'asc' ? '&uarr;' : '&darr;' !!}
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Localização') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('vagas.index', array_merge(request()->except('order_by', 'direction'), ['order_by' => 'ativa', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                {{ __('Status') }}
                                                @if (request('order_by') == 'ativa')
                                                    {!! request('direction') == 'asc' ? '&uarr;' : '&darr;' !!}
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('vagas.index', array_merge(request()->except('order_by', 'direction'), ['order_by' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                {{ __('Criada em') }}
                                                @if (request('order_by') == 'created_at')
                                                    {!! request('direction') == 'asc' ? '&uarr;' : '&darr;' !!}
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Ações') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($vagas as $vaga)
                                        <tr>
                                            @auth
                                                @if (!Auth::user()->candidato)
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input type="checkbox" name="vaga_ids[]" value="{{ $vaga->id }}" class="vaga-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    </td>
                                                @endif
                                            @endauth
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a href="{{ route('vagas.show', $vaga->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $vaga->titulo }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vaga->tipo_vaga }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vaga->localizacao }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vaga->ativa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $vaga->ativa ? 'Ativa' : 'Pausada' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vaga->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('vagas.show', $vaga->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalhes</a>
                                                @auth
                                                    @can('update', $vaga)
                                                        <a href="{{ route('vagas.edit', $vaga->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Editar</a>
                                                    @endcan
                                                    @can('delete', $vaga)
                                                        <form action="{{ route('vagas.destroy', $vaga->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Excluir</button>
                                                        </form>
                                                    @endcan
                                                @endauth
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $vagas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @auth
        @if (!Auth::user()->candidato)
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const selectAllCheckbox = document.getElementById('select-all-vagas');
                    const vagaCheckboxes = document.querySelectorAll('.vaga-checkbox');
                    const bulkDeleteForm = document.getElementById('bulk-delete-form');

                    function updateBulkDeleteButton() {
                        const anyChecked = Array.from(vagaCheckboxes).some(cb => cb.checked);
                        if (anyChecked) {
                            bulkDeleteForm.classList.remove('hidden');
                        } else {
                            bulkDeleteForm.classList.add('hidden');
                        }
                    }

                    selectAllCheckbox.addEventListener('change', function () {
                        vagaCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateBulkDeleteButton();
                    });

                    vagaCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function () {
                            if (!this.checked) {
                                selectAllCheckbox.checked = false;
                            }
                            updateBulkDeleteButton();
                        });
                    });

                    bulkDeleteForm.addEventListener('submit', function(event) {
                        const checkedVagas = Array.from(vagaCheckboxes).filter(cb => cb.checked);
                        if (checkedVagas.length === 0) {
                            alert('Nenhuma vaga selecionada para exclusão.');
                            event.preventDefault();
                            return false;
                        }

                        const hiddenInputsContainer = document.createElement('div');
                        checkedVagas.forEach(checkbox => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'vaga_ids[]';
                            input.value = checkbox.value;
                            hiddenInputsContainer.appendChild(input);
                        });
                        this.appendChild(hiddenInputsContainer);
                    });

                    updateBulkDeleteButton();
                });
            </script>
        @endif
    @endauth
</x-app-layout>