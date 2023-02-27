@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-xl-10">
      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('newsletter_lists.edit', $newsletterList->id)}}">
            <i class="fas fa-edit"></i>
            Modifica
          </a>
        </li>
        <li class="nav-item">
          <DeleteButton class="nav-link"
                        :resource="newsletter_lists"
                        :id="{{ $newsletterList->id }}"
                        label></DeleteButton>
        </li>
      </ul>

      <div class="card">
        <div class="card-header">{{ __('Dettagli Lista utenti Newsletter') }}</div>

        <div class="card-body">
          <h1>{{ $newsletterList->name  }}</h1>

          <div class="row">
            <div class="col">
              Destinatari: {{ $newsletterList->user_ids }}
            </div>
            <div class="col">
              Ruoli: {{ $newsletterList->roles }}
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("newsletter_lists.destroy", "_id")
  ])
@endsection
