<button id="{{ $id }}" type="submit" class="btn btn-success" @if(isset($formId)) form="{{$formId}}" @endif>
    @if(isset($icon))
        <i class="me-2 {{ $icon }}"></i>
    @endif
    <span>{{ $label }}</span>
</button>
