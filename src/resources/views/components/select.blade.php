@if(!empty($label))
    <span class="input-group-text" for="{{$id}}">{{$label}}</span>
@endif
<select class="form-select" id="{{$id}}" name="{{$id}}">
    <option value="" hidden selected>{{$placeholder}}</option>
    @foreach ($options as $item)
        <option value="{{$item[0]}}">{{$item[1]}}</option>
    @endforeach
</select>
