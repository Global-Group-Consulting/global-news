<form action="{{$action}}" method="POST" enctype="multipart/form-data">
  @csrf
  @method($method)

  <fieldset>
    <legend>Dati evento</legend>
    <div class="row">
      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Titolo",
          "name" => "title",
          "value" => old("title", $event->title)
        ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Locandina",
          "name" => "coverImg",
          "type"=> "file",
          "accept"=> "image/*",
          "value" => $event->coverImg ?? ''
        ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Città",
          "name" => "city",
          "type" => "text",
          "value" => old("city", $event->city)
        ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Luogo",
          "name" => "place",
          "type" => "text",
          "value" => old("place", $event->place),
          "min" => 1
        ])
      </div>

      <div class="col">
        @include("partials.form_txt", [
          "label" => "Descrizione",
          "name" => "content",
          "value" => old("content", $event->content)
        ])
      </div>

    </div>
  </fieldset>

  <fieldset>
    <legend>Opzioni</legend>
    <div class="row">
      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Data Inizio",
          "name" => "startAt",
          "type"=> "datetime-local",
          "value" => old("startAt", $event->startAt?->setTimezone(Cookie::get("global-tz")))
        ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_input", [
          "label" => "Posti disponibili",
          "name" => "seats",
          "type" => "number",
          "value" => old("seats", $event->seats),
          "min" => 1
        ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_switch", [
            "label" => "Attivo",
            "name" => "active",
            "noLabel"=> true,
            "checked" => old("active", $event->active) ?? "1"
          ])

        @include("partials.form_switch", [
            "label" => "Prenotabile",
            "name" => "bookable",
            "noLabel"=> true,
            "checked" => old("bookable", $event->bookable) ?? "1"
          ])
      </div>

      <div class="col-12 col-md-6">
        @include("partials.form_select", [
          "label" => "Visibile in",
          "name" => "apps",
          "multiple" => true,
          "value"=> old("apps", $event->apps ?? [\App\Enums\AppType::CLUB]),
          "options" => $appsOptions
        ])
      </div>
    </div>
  </fieldset>

  <div class="d-flex justify-content-center mt-3">
    <a href="{{route('events.index')}}" class="btn btn-outline-secondary me-3"
       type="reset">Annulla</a>
    <button class="btn btn-success" type="submit">
      {{ $event->_id ? "Salva": "Crea" }}
    </button>
  </div>
</form>
