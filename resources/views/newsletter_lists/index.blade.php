@extends("layouts.app")

@section("content")

  <ul class="nav mb-4 justify-content-center">
    <li class="nav-item">
      <a class="nav-link" href="{{route('newsletter_lists.create')}}">
        <i class="fas fa-plus"></i>
        Aggiungi</a>
    </li>
  </ul>

  <div class="card">
    <div class="card-header">{{ __('Liste utenti Newsletter') }}</div>

    <div class="card-body">
      {{-- Data Table --}}
      <NewsletterListTable :newsletter-lists="{{ json_encode($newsletterLists) }}">
        <template v-slot:pagination>{{$newsletterLists->links()}}</template>
      </NewsletterListTable>

    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("newsletter_lists.destroy", "_id")
  ])
@endsection
