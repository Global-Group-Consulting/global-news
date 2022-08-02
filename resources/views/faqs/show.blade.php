@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('faqs.edit', $faq->id)}}">
            <i class="fas fa-edit"></i>
            Modifica
          </a>
        </li>
        <li class="nav-item">
          <button class="btn btn-link nav-link text-danger" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  data-bs-id="{{$faq->id}}">
            <i class="fas fa-trash"></i>
            Elimina
          </button>
        </li>
      </ul>

      <div class="card">
        <div class="card-header">{{ __('Dettagli FAQ') }}</div>

        <div class="card-body">
          <h1>{{ $faq->question  }}</h1>

          <div class="row">
            <div class="col">
              Stato: <strong>{{$faq->active ? "Attivo" : "Non attivo"}}</strong>
            </div>
            <div class="col">
              Visibile nelle App: <strong>{{join(", ", $faq->apps)}}</strong>
            </div>
            <div class="col">
              Ultima modifica:
              <strong>{{\Carbon\Carbon::parse($faq->updated_at )->setTimezone('Europe/Berlin')->format("d/m/y H:i:s")}}</strong>
            </div>
          </div>

          <div class="mt-4 py-4 border-top">
            {!! $faq->answer !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("faqs.destroy", "_id")
  ])
@endsection
