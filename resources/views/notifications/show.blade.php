@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <div class="card">
        <div class="card-header">{{ $notification->title }}</div>

        <div class="card-body">
          @if($notification->coverImg)
            <img src="{{$notification->coverImg}}" class="img-fluid mb-4" alt="">
          @endif

          <div class="mb-4 py-4 border-bottom">
            {!! $notification->content !!}
          </div>

          <div class="">
            <h3>Destinatari</h3>

            <div class="row row-cols-2 mb-4">
              @foreach($notification->receivers as $user)
                <div class="col">
                  <strong class="card-title">{{ $user["firstName"] }} {{ $user["lastName"] }}</strong>
                  (<span class="card-text">{{ $user["email"] }}</span>)
                </div>
              @endforeach
            </div>
          </div>

          <div class="border-top pt-4">
            <h3>Dettagli</h3>

            <div class="row row-cols-2 mb-4">
              <div class="col">
                Tipologia: <strong>{{$notification->type}}</strong>
              </div>
              <div class="col">
                Piattaforme: <strong>{{join(($notification->platforms ?? []), ", ")}}</strong>
              </div>
              <div class="col">
                Letta da tutti i destinatari: <strong>{{$notification->completed ? "Si" : "No"}}</strong>
              </div>
              <div class="col">
                Visibile nell'App: <strong>{{$notification->app}}</strong>
              </div>
              <div class="col">
                Data creazione: <strong>{{$notification->created_at->format("d/m/Y H:i:s")}}</strong>
              </div>
              <div class="col">
                Ultima modifica: <strong>{{$notification->updated_at->format("d/m/Y H:i:s")}}</strong>
              </div>
            </div>
          </div>

          <div class="border-top pt-4">
            <h3>Letture</h3>
            <code>
              <pre>{{json_encode($notification->readings ?? [], JSON_PRETTY_PRINT)}}</pre>
            </code>
          </div>
        </div>
      </div>

      <div class="accordion mt-4" id="accordionExample">
        <div class="accordion-item collapsed">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="false" aria-controls="collapseOne">
              Json notifica
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
               data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <code>
                <pre>{{json_encode($notification ?? [], JSON_PRETTY_PRINT)}}</pre>
              </code>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
