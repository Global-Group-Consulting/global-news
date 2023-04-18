<form action="{{$action}}" method="POST" enctype="multipart/form-data">
  @csrf
  @method($method)

  <div class="row">
    <div class="col">
      @include("partials.form_input", [
        "label" => "Titolo",
        "name" => "title",
        "value" => old("title", $event->title)
      ])
    </div>

    <div class="col">
      @include("partials.form_input", [
        "label" => "Posti disponibili",
        "name" => "seats",
        "type" => "number",
        "value" => old("seats", $event->seats),
        "min" => 1
      ])
    </div>
  </div>

  <div class="row">
    <div class="col">
      @include("partials.form_switch", [
          "label" => "Attivo",
          "name" => "active",
          "noLabel"=> true,
          "checked" => old("active", $event->active) ?? "1"
        ])
    </div>

    <div class="col">
      @include("partials.form_switch", [
          "label" => "Prenotabile",
          "name" => "bookable",
          "noLabel"=> true,
          "checked" => old("bookable", $event->bookable) ?? "1"
        ])
    </div>
  </div>

  <div class="row">
    <div class="col">
      @include("partials.form_input", [
        "label" => "Data Inizio",
        "name" => "startAt",
        "type"=> "datetime-local",
        "value" => old("startAt", $event->startAt)
      ])
    </div>

<!--    <div class="col">
      @include("partials.form_input", [
        "label" => "Data Fine",
        "name" => "endAt",
        "type"=> "datetime-local",
        "value" => old("endAt", $event->endAt)
      ])
    </div>-->
  </div>

  <div class="row">
    <div class="col-6">
      @include("partials.form_select", [
        "label" => "Visibile in",
        "name" => "apps",
        "multiple" => true,
        "value"=> old("apps", $event->apps ?? [\App\Enums\AppType::CLUB]),
        "options" => $appsOptions
      ])
    </div>

    <div class="col">
      @include("partials.form_input", [
        "label" => "Locandina",
        "name" => "coverImg",
        "type"=> "file",
        "accept"=> "image/*",
        "value" => $event->coverImg ?? ''
      ])
    </div>
  </div>

  <div class="row">
    <div class="col">
      @include("partials.form_txt", [
        "label" => "Contenuto",
        "name" => "content",
        "value" => old("content", $event->content)
      ])
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <a href="{{route('events.index')}}" class="btn btn-outline-secondary me-3"
       type="reset">Annulla</a>
    <button class="btn btn-success" type="submit">
      {{ $event->_id ? "Salva": "Crea" }}
    </button>
  </div>
</form>
