@props(['href' => null, 'type' => 'button', 'color' => 'primary', 'size' => 'sm'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-{$color} btn-{$size}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$color} btn-{$size}"]) }}>
        {{ $slot }}
    </button>
@endif
