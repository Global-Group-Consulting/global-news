@extends("layouts.app")

@section("content")

  <x-card title="Dettagli Evento" :backUrl="route('events.index')" sizeClasses="col-12 col-lg-10 col-xl-9">
    <x-slot name="before">
      @if($event->startAt >= \Carbon\Carbon::now()->startOf("day"))
        <ul class="nav mb-4 justify-content-center">
          <li class="nav-item">
            <a class="nav-link" href="{{route('events.edit', $event->_id)}}">
              <i class="fas fa-edit"></i>
              Modifica
            </a>
          </li>
          <li class="nav-item">
            <button class="btn btn-link nav-link text-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-bs-id="{{$event->_id}}">
              <i class="fas fa-trash"></i>
              Elimina
            </button>
          </li>
        </ul>
      @endif
    </x-slot>

    <div class="row">
      @if($event->coverImg)
        <div class="col-12 col-md-4 pb-4 pb-md-0">
          <a style="max-width: 250px" class="mb-3 me-3" target="_blank"
             href="{{Storage::url($event->coverImg)}}">
            <img src="{{Storage::url($event->coverImg)}}" alt="" class="img-fluid">
          </a>
        </div>
      @endif
      <div class="col-12 col-md-8">
        <h1>{{ $event->title  }}</h1>

        <p class="lead">{!! $event->content !!}</p>

        <div>Città: <strong>{{$event->city }}</strong></div>
        <div>Luogo: <strong>{{$event->place }}</strong></div>

        <div>
          Data inizio:
          <strong>{{$event->startAt->setTimezone(Cookie::get("global-tz"))->format("d/m/Y H:i") ?? "*"}}</strong>
          {{--      al <strong>{{$event->endAt->format("d/m/Y H:i") ?? "*"}}</strong>--}}
        </div>

        <div class="row">
          <div class="col">
            Posti totali: <strong>{{$event->seats}}</strong>
          </div>
          <div class="col">
            Posti rimanenti: <strong>{{$event->remainingSeats()}}</strong>
          </div>
        </div>

        <div>Stato: <strong>{{$event->active ? "Attivo" : "Non attivo"}}</strong></div>

        <div>Prenotabile: <strong>{{$event->bookable ? "Si" : "No"}}</strong></div>

        <div>Visibile nelle App: <strong>{{join(", ", $event->apps)}}</strong></div>

        <div>Ultima modifica: <strong>{{$event->updated_at->format("d/m/Y H:i:s")}}</strong></div>
      </div>
    </div>


  </x-card>

  @include("partials.modals.delete", [
    "action"=> route("events.destroy", "_id")
  ])
@endsection
