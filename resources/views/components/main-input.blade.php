@if(!isset($textarea))
  <div class="main-input-container">
    <input 
      placeholder="{{$placeholder}}"
      type="{{$type}}" 
      name="{{$name}}" 
      class="main-input" 
      id="input{{$name}}" 
      value="{{old($name, '')}}"
    >
    @error($name) 
      <div class="invalid-feedback">
        {{$message}}
      </div>    
    @enderror
  </div>
@endif

{{-- @isset($textarea)
  <div class="main-input-container">
    <textarea 
      placeholder="{{$placeholder}}"
      class="main-textarea"
      name="{{$name}}"
      aria-describedby="validation{{$name}}"
      id="textarea{{$name}}" 
    >{{old($name, '')}}</textarea>
    @error($name) 
      <div id="validation{{$name}}" class="invalid-feedback">
        {{$message}}
      </div>    
    @enderror
  </div>
@endisset --}}

<style>
  .main-input-container {
    display: flex;
    width: 100%;
    flex-direction: column;
    gap: 15px;
  }

  .main-input {
    width: 100%;
    font-size: 14px;
    padding: 15px;
    box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    border: none;
    outline: none;
  }

  .main-input::placeholder {
    font-weight: 500;
    font-size: 14px;
  }

  .invalid-feedback {
    padding-left: 15px;
    color: #D75945;
    font-weight: 500;
  }
</style>