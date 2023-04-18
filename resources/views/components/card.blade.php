<div {{$attributes->merge(["class" => 'row justify-content-center'])}}>
  <div @class([$sizeClasses ?? "col"])>

    {{ $before ?? '' }}

    <div class="card">
      @if(isset($title) || $includeBackBtn)
        <div class="card-header">
          @if($includeBackBtn)
            <a href="{{ $backUrl ?? url()->previous() }}" class="btn btn-link">
              <i class="fas fa-chevron-left"></i>
            </a>
          @endif
          {{ $title }}</div>
      @endif

      <div class="card-body">
        {{ $slot }}
      </div>
    </div>
  </div>
</div>
