@php
  $hasFilePreview = isset($type) && $type === 'file' && isset($value) && $value;
@endphp

<div class="mb-3 {{$hasFilePreview ? 'd-flex' : ''}}">
  @if($hasFilePreview)
    <a href="{{Storage::url($value)}}" target="_blank" style="width: 67px"
       class="flex-shrink-0 d-flex align-items-center me-2">
      <img src="{{Storage::url($value)}}" class="img-fluid"> </a>
  @endif

  @if($hasFilePreview)
    <div class="flex-fill">
      @endif

      <label for="{{$name}}Input" class="form-label">
        {{$label}}
      </label>
      <input type="{{ $type ?? 'text'  }}" class="form-control @error($name) is-invalid @enderror"
             @if(isset($accept)) accept="{{$accept}}" @endif
             id="{{$name}}Input"
             name="{{$name}}"
             value="{{ $value ?? '' }}"
          {{isset($min) ? "min=$min" : ''}}>
      @error($name)
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      @if($hasFilePreview)
    </div>
  @endif
</div>
