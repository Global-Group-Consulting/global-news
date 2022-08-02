<form action="{{ $action  }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method($method ?? "POST")

  <div class="row">
    <div class="col">
      @include("partials.form_input", [
        "label" => "Titolo",
        "name" => "question",
        "value" => isset($faq) ? $faq["question"] : old("question")
      ])
    </div>

    <div class="col">
      @include("partials.form_select", [
        "label" => "Visibile in",
        "name" => "apps",
        "multiple" => true,
        "value"=> isset($faq) ? $faq["apps"] : old("apps"),
        "options" => $appsOptions
      ])
    </div>

    <div class="col">
      @include("partials.form_switch", [
          "label" => "Attivo",
          "name" => "active",
          "checked" => isset($faq) ? $faq["active"] : (old("active") ?? "1")
        ])
    </div>
  </div>


  <div class="row">
    <div class="col">
      @include("partials.form_txt", [
        "label" => "Contenuto",
        "name" => "answer",
        "value" => isset($faq) ? $faq["answer"] : old("answer")
      ])
    </div>
  </div>

  <div class=" d-flex">
    <a href="{{route($resource . '.index')}}"
       class="btn btn-outline-secondary me-3"
       type="reset">Annulla</a>
    <button class="btn btn-success" type="submit">Crea</button>
  </div>
</form>
