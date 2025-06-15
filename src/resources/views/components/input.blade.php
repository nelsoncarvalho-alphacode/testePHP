@if(!empty($label))
    <span class="input-group-text" for="{{$id}}">{{$label}}</span>
@endif
<input type="{{$type}}" class="form-control" placeholder="{{$placeholder}}" id="{{$id}}" name="{{$id}}">
