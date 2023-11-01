
<label for="{{$id}}" class="form-label">{{$label}} @if(isset($required)) * @endif</label>
<div class="input-group @if($type != 'password') input-group-merge @endif">

    @if($type != 'password')
        @if(isset($info))
            <div class="input-group-prepend">
            <span class="input-group-text"
                  data-bs-toggle="popover"
                  title="Informações Adicionais"
                  data-bs-content="{{$info}}"
                  data-bs-trigger="focus"
                  tabindex="0"
                  id="basic-addon1" style="outline: none;">
                <i class=" dripicons-information noti-icon"></i>
            </span>
            </div>
        @endif
    @endif

    <input type="{{$type}}" @if($type == 'number') step="any" @endif class="form-control" id="{{$id}}" name="{{$name}}"
           value="{{$value === '' ? old($name): $value}}"
           @if(isset($disabled)) disabled="" @endif @if(isset($readOnly)) readonly="{{$readOnly}}" @endif

           @if(!empty($onblur))
               onblur="{{$onblur}}"
           @endif
           @if(isset($required))
               oninvalid="this.setCustomValidity('Campo obrigatório')"
           oninput="this.setCustomValidity('')"
           required
        @endif>

    @if($type == 'password')
        <div class="input-group-text" data-password="false">
            <span class="password-eye"></span>
        </div>
    @endif


    @if(!$errors->any())
            <div class="valid-feedback">
                Looks good!
            </div>
    @endif

        <div class="valid-feedback">
        @error($name)
        {{$message}}
        @enderror
    </div>
</div>
