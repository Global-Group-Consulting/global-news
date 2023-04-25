<div class="btn-group">
  @if(!$readonly)
    <a href="{{route('events.edit', $event->_id)}}" class="btn btn-link">
      <i class="fas fa-edit"></i>
    </a>
  @endif

  <a href="{{route('events.show', $event->_id)}}" class="btn btn-link text-warning">
    <i class="fas fa-eye"></i>
  </a>

  @if(!$readonly)
    <button class="btn btn-link text-danger"
            data-bs-toggle="modal"
            data-bs-target="#deleteModal"
            data-bs-id="{{$event->_id}}">
      <i class="fas fa-trash"></i>
    </button>
  @endif
</div>
