
<form method="GET" class="row g-2 mb-3">
    <div class="col">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pesquisar...">
    </div>
    @if (isset($select_name) && isset($select_value_label))
        <div class="col">
            <select class="form-select" name={{$select_name}}>
                @foreach ($select_value_label as $value => $label)
                    <option @if (request($select_name) == $value) selected @endif value="{{$value}}">{{$label}}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="col">
        <button type="submit" class="btn btn-secondary">Filtrar</button>
    </div>
</form>