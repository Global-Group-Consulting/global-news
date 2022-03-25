@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">
      <div class="card">
        <div class="card-header">{{ __('Crea una nuova Notifica') }}</div>

        <div class="card-body">
          <form action="{{route("news.store")}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col">
                @include("partials.form_input", [
                  "label" => "Titolo",
                  "name" => "title",
                  "value" => old("title")
                ])
              </div>

              <div class="col">
                @include("partials.form_switch", [
                    "label" => "Attivo",
                    "name" => "active",
                    "checked" => old("active") ?? "1"
                  ])
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                @include("partials.form_select", [
                  "label" => "Visibile in",
                  "name" => "apps",
                  "multiple" => true,
                  "value"=> old("apps"),
                  "options" => $appsOptions
                ])
              </div>

              <div class="col">
                @include("partials.form_input", [
                  "label" => "Immagine di copertina",
                  "name" => "coverImg",
                  "type"=> "file",
                  "accept"=> "image/*"
                ])
              </div>
            </div>

            <div class="row">
              <div class="col">
                @include("partials.form_input", [
                  "label" => "Visibile dal",
                  "name" => "startAt",
                  "type"=> "date",
                  "value" => old("startAt")
                ])
              </div>

              <div class="col">
                @include("partials.form_input", [
                  "label" => "Visibile fino al",
                  "name" => "endAt",
                  "type"=> "date",
                  "value" => old("endAt")
                ])
              </div>
            </div>


            <div class="row">
              <div class="col">
                @include("partials.form_txt", [
                  "label" => "Contenuto",
                  "name" => "content",
                  "value" => old("content")
                ])
              </div>
            </div>

            <div class=" d-flex">
              <a href="{{route('news.index')}}" class="btn btn-outline-secondary me-3"
                 type="reset">Annulla</a>
              <button class="btn btn-success" type="submit">Crea</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
