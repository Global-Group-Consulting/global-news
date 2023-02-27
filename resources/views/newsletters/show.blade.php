@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('newsletters.edit', $newsletter->id)}}">
            <i class="fas fa-edit"></i>
            Modifica
          </a>
        </li>
        <li class="nav-item">
          <DeleteButton :id="{{$newsletter->id}}"
                        class="nav-link"
                        resource="/newsletters"
                        label>
          </DeleteButton>
        </li>
      </ul>

      <div class="card">
        <div class="card-header">{{ __('Dettagli Newsletter') }}</div>

        <div class="card-body">
          <h1>{{ $newsletter->subject  }}</h1>

          <div class="row">
            <div class="col">
              Destinatari: {{ $newsletter->list_id }}
            </div>
            <div class="col">
              Stato: {{ $newsletter->status }}
            </div>
          </div>

          <div class="row">
            <div class="col">
              Data creazione:
              <strong>{{\Carbon\Carbon::parse($newsletter->created_at )->setTimezone('Europe/Berlin')->format("d/m/y H:i:s")}}</strong>
            </div>
            <div class="col">
              Ultima modifica:
              <strong>{{\Carbon\Carbon::parse($newsletter->updated_at )->setTimezone('Europe/Berlin')->format("d/m/y H:i:s")}}</strong>
            </div>
          </div>

          <div class="mt-4 p-3 border">
            {!! $newsletter->content !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("newsletters.destroy", "_id")
  ])
@endsection
