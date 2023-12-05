<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pass Evento | Global Club</title>

  <link href="{{ asset('css/pass_club.css') }}" rel="stylesheet">
  <script src="{{ asset('js/pass_club.js') }}" defer></script>
</head>
<body>
  <header class="py-5">
    <img src="{{asset('img/logo-global-club.svg')}}" alt="">
  </header>

  <main class="container">
    <div class="card bg-dark">
      <div
          class="card-header px-5 py-4 d-flex flex-sm-row flex-column align-items-center justify-content-between gap-3 w-100">
        <h2 class="mb-0 d-flex align-items-center gap-3">Pass Evento
          @if($userReservation["isCompanion"])
            <span class="badge bg-primary fs-6">Accompagnatore</span>
          @endif
        </h2>

        <button type="button" class="btn btn-primary d-print-none"
                onclick="window.print()">Stampa PDF
        </button>
      </div>

      <div class="card-body p-5">
        <div class="row align-items-start flex-column-reverse flex-md-row g-lg-5">
          <div class="col-12 col-md-3 d-flex justify-content-center">
            <a style="max-width: 250px" class="mb-3 d-inline-block" target="_blank"
               href="{{Storage::url($event->coverImg)}}">
              <img src="{{Storage::url($event->coverImg)}}" alt="" class="img-fluid w-100">
            </a>
          </div>

          <div class="col-12 col-md-6 py-5 py-md-0">
            <ul class="list-unstyled">
              <li>
                <div class="lead" style="color: var(--bs-gray-600)">Nome Evento</div>
                <p class=" ms-3">{{$event->title}}</p>
              </li>

              @if(strlen(strip_tags($event->content)))
                <li>
                  <div class="lead" style="color: var(--bs-gray-600)">Descrizione</div>
                  <p class=" ms-3">{{substr(strip_tags($event->content), 0, 100)}} ...</p>
                </li>
              @endif

              <li>
                <div class="lead" style="color: var(--bs-gray-600)">Data</div>
                <p class=" ms-3">{{ $event->startAt->setTimezone(Cookie::get("global-tz"))->format("d/m/Y H:i") ?? "*" }}</p>
              </li>

              <li>
                <div class="lead" style="color: var(--bs-gray-600)">Luogo</div>
                <p class=" ms-3">{{$event->city}} - {{ $event->place }}</p>
              </li>

              <li>
                <div class="lead" style="color: var(--bs-gray-600)">Partecipante</div>

                <ul class="list-unstyled ms-3">
                  <li class="">{{$userReservation["firstName"]}} {{$userReservation["lastName"]}}
                    @if($userReservation["isCompanion"])
                      <em class="">(Invitat* da
                        <strong>{{$reservation->user["firstName"]}} {{$reservation->user["lastName"]}})</strong></em>
                    @endif
                  </li>
                </ul>

              </li>
            </ul>
          </div>

          <div class="col-12 col-md-3">
            <div class="visible-print text-center mb-3">
              <a style="max-width: 400px" class="d-inline-block" target="_blank"
                 href="{{ Storage::url($userReservation["passQr"])  }}">
                {!! $passQr !!}
              </a>

              <style>
                .visible-print svg {
                  width: 100%;
                  height: auto;
                  aspect-ratio: 1/1;
                }
              </style>

              <div class="mt-3">{{ $userReservation["passCode"]  }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</body>
</html>
