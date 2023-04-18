<div class="{{ $class ?? "mb-3" }} form-check form-switch">

  @if(!isset($noLabel) ?? false)
    <div class="form-label">&nbsp;</div>
  @endif

  <input type="hidden" name="{{$name}}" value="0" checked>

  <input class="form-check-input @error($name) is-invalid @enderror" type="checkbox" role="switch"
         id="{{$name}}Input" name="{{$name}}" value="1" {{ $checked ? 'checked' : '' }}>
  <label for="{{$name}}Input" class="form-check-label">
    {{$label}}
  </label>

  @error($name)
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>
