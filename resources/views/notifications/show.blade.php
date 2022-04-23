@extends("layouts.app")

@section("content")
  @php($data = (object) $notification->data)

  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <div class="card">
        <div class="card-header">{{$data->title}}</div>

        <div class="card-body">
          @if(property_exists($data, "coverImg"))
            <img src="{{$data->coverImg}}" class="img-fluid mb-4" alt="">
          @endif

          <div class="mb-4 py-4 border-bottom">
            {!! $data->content !!}
          </div>

          <div class="">
            <h3>Destinataro</h3>

            <div class="row row-cols-2 mb-4">
              @php($user = (object) $data->receiver)

              <div class="col">
                <strong class="card-title">{{ $user->firstName }} {{ $user->lastName }}</strong>
                (<span class="card-text">{{ $user->email }}</span>)
              </div>
            </div>
          </div>

          <div class="border-top pt-4">
            <h3>Dettagli</h3>

            <div class="row row-cols-2 mb-4">
              <div class="col">
                ID: <strong>{{$notification->id}}</strong>
              </div>
              <div class="col">
                Tipologia: <strong>{{$data->type}}</strong>
              </div>
              <div class="col">
                Piattaforme: <strong>{{join(($data->platforms ?? []), ", ")}}</strong>
              </div>
              <div class="col">
                Letta: <strong>{{$notification->read_at ? "Si" : "No"}}
                  @if($notification->read_at)
                    ({{ $notification->read_at->format("d/m/Y H:i:s") }})
                  @endif</strong>
              </div>
              <div class="col">
                Visibile nell'App: <strong>{{$data->app}}</strong>
              </div>
              <div class="col">
                Data creazione: <strong>{{$notification->created_at->format("d/m/Y H:i:s")}}</strong>
              </div>
              <div class="col">
                Ultima modifica: <strong>{{$notification->updated_at->format("d/m/Y H:i:s")}}</strong>
              </div>
            </div>
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
