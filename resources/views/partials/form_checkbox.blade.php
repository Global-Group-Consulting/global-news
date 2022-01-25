<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input @error($name) is-invalid @enderror"
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
