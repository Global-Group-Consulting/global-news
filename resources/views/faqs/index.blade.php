@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('faqs.create')}}">
            <i class="fas fa-plus"></i>
            Aggiungi</a>
        </li>
      </ul>

      <div class="card">
        <div class="card-header">{{ __('Lista FAQ') }}</div>

        <div class="card-body">
          {{-- Data Table --}}
          <table class="table table-striped">
            <thead>
            <tr>
              <th scope="col">Titolo</th>
              <th scope="col">App</th>
              <th scope="col">Stato</th>
              <th scope="col">Ultima modifica</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($faqs as $faq)
              <tr>
                <td>{{ $faq->question  }}</td>
                <td>{{ join(", ", $faq->apps)  }}</td>
                <td>{{ $faq->active ? "Attivo" : "Non attivo" }}</td>
                <td>{{ \Carbon\Carbon::parse($faq->updated_at )->setTimezone('Europe/Berlin')->format("d/m/y H:i:s") }}</td>
                <td>
                  <a href="{{route('faqs.edit', $faq->id)}}" class="btn btn-link">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{route('faqs.show', $faq->id)}}" class="btn btn-link">
                    <i class="fas fa-eye"></i>
                  </a>
                  <button class="btn btn-link text-danger" data-bs-toggle="modal"
                          data-bs-target="#deleteModal"
                          data-bs-id="{{$faq->id}}">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

          {{-- Pagination --}}
          <div class=" d-flex justify-content-center">
            {{$faqs->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("faqs.destroy", "_id")
  ])
@endsection
