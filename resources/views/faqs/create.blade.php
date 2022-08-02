@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">
      <div class="card">
        <div class="card-header">{{ __('Crea una nuova News') }}</div>

        <div class="card-body">
          @include("faqs.forms.upsert", [
                    "action" => route("faqs.store"),
                    "resource" => "faqs"
                  ])
        </div>
      </div>
    </div>
  </div>
@endsection
