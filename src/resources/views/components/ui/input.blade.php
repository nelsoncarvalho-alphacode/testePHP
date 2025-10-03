@props(['name', 'type' => 'text', 'value' => ''])

<input type="{{ $type }}"
       name="{{ $name }}"
       id="{{ $name }}"
       value="{{ old($name, $value) }}"
       {{ $attributes->merge(['class' => 'form-control']) }}>
