<a href="{{route('newsletters.edit', $row->id)}}" class="btn btn-link">
  <i class="fas fa-edit"></i>
</a>

<a href="{{route('newsletters.show', $row->id)}}" class="btn btn-link">
  <i class="fas fa-eye"></i>
</a>

<button class="btn btn-link text-danger" data-bs-toggle="modal"
        data-bs-target="#deleteModal"
        data-bs-id="{{$row->id}}">
  <i class="fas fa-trash"></i>
</button>
