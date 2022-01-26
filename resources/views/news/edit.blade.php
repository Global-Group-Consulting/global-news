@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-xl-10">
      @include("partials.session_error")

      <div class="card">
        <div class="card-header">{{ __('Modifica App') }}</div>

        <div class="card-body">
          @if($news->coverImg)
            <div class="mb-3 img-thumbnail-container">
              <img src="{{Storage::temporaryUrl($news->coverImg, now()->addMinutes(5))}}"
                   class="img-thumbnail">
              <!--            <button type="button" class="btn btn-danger" aria-label="Close">
                            <i class="fas fa-times"></i>
                          </button>-->
            </div>
          @endif

          <form action="{{route("news.update", $news->_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("patch")

            <div class="row">
              <div class="col">
                @include("partials.form_input", [
                  "label" => "Titolo",
                  "name" => "title",
                  "value" => $news["title"]
                ])
              </div>

              <div class="col">
                @include("partials.form_switch", [
                    "label" => "Attivo",
                    "name" => "active",
                    "checked" => $news["active"]
                  ])
              </div>
            </div>

            <div class="row">
              <div class="col">
                @include("partials.form_select", [
                  "label" => "Visibile in",
                  "name" => "apps",
                  "multiple" => true,
                  "value"=> $news["apps"],
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
                  "value" => $news["startAt"]
                ])
              </div>

              <div class="col">
                @include("partials.form_input", [
                  "label" => "Visibile fino al",
                  "name" => "endAt",
                  "type"=> "date",
                  "value" => $news["endAt"]
                ])
              </div>
            </div>


            <div class="row">
              <div class="col">
                @include("partials.form_txt", [
                  "label" => "Contenuto",
                  "name" => "content",
                  "value" => $news["content"]
                ])
              </div>
            </div>

            <div class=" d-flex">
              <a href="{{route('news.index')}}" class="btn btn-outline-secondary me-3"
                 type="reset">Annulla</a>
              <button class="btn btn-success" type="submit">Salva</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
