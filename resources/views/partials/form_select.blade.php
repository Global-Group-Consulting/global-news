@php
  if(!isset($name)){
    $name = "";
  }

  $isMultiple = isset($multiple) && $multiple;
  $selectName = $isMultiple ? $name . "[]" : $name;
  $errorName = $isMultiple ? $name . ".*" : $name;
@endphp

<div class="mb-3">
  <label for="{{$name}}Select" class="form-label">
    {{$label}}
  </label>

  <div class="dropdown">
    <button class="form-select text-start text-truncate @error($errorName) is-invalid @enderror"
            type="button" id="{{$name}}Select"
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside"
            aria-expanded="false">
      Dropdown
    </button>

    @error($errorName)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror

    <ul class="dropdown-menu" aria-labelledby="{{$name}}Select">
      <li>
        <button class="dropdown-item" type="button" data-dd-action="none">Nessuna</button>
      </li>
      <li>
        <button class="dropdown-item" type="button" data-dd-action="all">Tutte</button>
      </li>

      <li>
        <hr class="dropdown-divider">
      </li>

      @foreach($options as $option)
        @php
          $optionValue = isset($optionsKey) ? $option[$optionsKey] : $option["value"];
          $optionLabel = isset($optionsText) && key_exists("fn", $optionsText) ?
          $optionsText["fn"]($option) : $option["text"] ;
          $selected = $value === $optionValue;

          if(is_array($value)){
            $selected = in_array($optionValue, $value);
          }
        @endphp
        <li class="dropdown-item">
          <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   id="{{$selectName}}_{{$optionValue}}_option"
                   name="{{$selectName}}[]"
                   value="{{$optionValue}}" {{ $selected ? "checked" : '' }}>
            <label class="form-check-label" for="{{$selectName}}_{{$optionValue}}_option">
              {{ $optionLabel }}
            </label>
          </div>
        </li>
      @endforeach

    </ul>
  </div>
</div>
