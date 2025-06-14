@csrf

<div>
    <x-input-label for="titulo" :value="__('Título da Vaga')" />
    <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $vaga->titulo ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
</div>

<div class="mt-4">
    <x-input-label for="descricao" :value="__('Descrição da Vaga')" />
   <textarea id="descricao" name="descricao" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('descricao', $vaga->descricao ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
</div>

<div class="mt-4">
    <x-input-label for="tipo_vaga" :value="__('Tipo de Contratação')" />
    <select id="tipo_vaga" name="tipo_vaga" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
        <option value="">Selecione um tipo</option>
        <option value="CLT" {{ old('tipo_vaga', $vaga->tipo_vaga ?? '') == 'CLT' ? 'selected' : '' }}>CLT</option>
        <option value="Pessoa Jurídica" {{ old('tipo_vaga', $vaga->tipo_vaga ?? '') == 'Pessoa Jurídica' ? 'selected' : '' }}>Pessoa Jurídica</option>
        <option value="Freelancer" {{ old('tipo_vaga', $vaga->tipo_vaga ?? '') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('tipo_vaga')" />
</div>

<div>
    <label for="ativa" class="block font-medium text-sm text-gray-700">Vaga Ativa?</label>
    <input type="hidden" name="ativa" value="0">
    <input type="checkbox"
           id="ativa"
           name="ativa"
           value="1"
           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
           {{ old('ativa', $vaga->ativa ?? true) ? 'checked' : '' }}> 
    <span class="ml-2 text-gray-700">Sim, esta vaga está ativa.</span>
</div>