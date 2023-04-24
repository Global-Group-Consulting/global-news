<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <link href="{{ asset('css/pass_club.css') }}" rel="stylesheet">
</head>
<body>
  <main class="container">
    <div class="card bg-dark">
      <div class="card-header p-5">
        <h2>Pass Evento</h2>
      </div>

      <div class="card-body p-5">
        <div class="row">
          <div class="col">
            <ul class="list-unstyled">
              <!--              <li>
                <a style="max-width: 250px" class="mb-3 d-inline-block" target="_blank" href="{{Storage::url($event->coverImg)}}">
                  <img src="{{Storage::url($event->coverImg)}}" alt="" class="img-fluid w-100">
                </a>
              </li>-->
              <li>
                <h5>Nome Evento</h5>
                <p class="lead">{{$event->title}}</p>
              </li>

              <li>
                <h5>Descrizione</h5>
                <p class="lead">{{$event->content}}</p>
              </li>

              <li>
                <h5>Data</h5>
                <p class="lead">{{$event->startAt}}</p>
              </li>

              <li>
                <h5>Partecipanti</h5>

                <ul class="list-unstyled">
                  <li class="lead">{{$reservation->user["firstName"]}} {{$reservation->user["lastName"]}}</li>
                  @foreach($reservation->companions as $companion)
                    <li class="lead">{{$companion["firstName"]}} {{$companion["lastName"]}}</li>
                  @endforeach
                </ul>

              </li>
            </ul>
          </div>
          <div class="col">
            <div class="visible-print text-center">

              {!! $pass !!}

              {{--  <img src="data:image/svg+xml;base64, {!! base64_encode($pass)!!}">--}}

              <div class="mt-3">{{ $reservation->passCode  }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>


