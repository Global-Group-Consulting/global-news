@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-xl-10">
      @include("partials.session_error")

      <div class="card">
        <div class="card-header">{{ __('Modifica Faq') }}</div>

        <div class="card-body">

          @include("faqs.forms.upsert", [
            "action" => route("faqs.update", $faq->id),
            "method" => "PATCH",
            "resource" => "faqs"
          ])
        </div>
      </div>
    </div>
  </div>
@endsection
