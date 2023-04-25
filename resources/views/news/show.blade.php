@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-xl-10">

      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('news.edit', $news->_id)}}">
            <i class="fas fa-edit"></i>
            Modifica
          </a>
        </li>
        <li class="nav-item">
          <button class="btn btn-link nav-link text-danger" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  data-bs-id="{{$news->_id}}">
            <i class="fas fa-trash"></i>
            Elimina
          </button>
        </li>
      </ul>

      <div class="card">
        <div class="card-header">{{ __('Dettagli News') }}</div>

        <div class="card-body">
          @if($news->coverImg)
            <img src="{{Storage::temporaryUrl($news->coverImg, now()->addMinutes(5))}}"
                 class="img-fluid mb-4">
          @endif

          <h1>{{ $news->title  }}</h1>

          <div class="row">
            <div class="col">
              Visibile dal <strong>{{$news->startAt ?? "*"}}</strong> al <strong>{{$news->endAt ?? "*"}}</strong>
            </div>
            <div class="col">
              Stato: <strong>{{$news->active ? "Attivo" : "Non attivo"}}</strong>
            </div>
            <div class="col">
              Visibile nelle App: <strong>{{join(", ", $news->apps)}}</strong>
            </div>
            <div class="col">
              Ultima modifica: <strong>{{$news->updated_at}}</strong>
            </div>
          </div>

          <div class="mt-4 py-4 border-top">
            {!! $news->content !!}
          </div>

          <div>
            Letture: <strong>{{ count($news->readStatuses ?? [])  }}</strong><br>
            <code>
              <pre>{{json_encode($news->readStatuses ?? [], JSON_PRETTY_PRINT)}}</pre>
            </code>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("news.destroy", "_id")
  ])
@endsection
