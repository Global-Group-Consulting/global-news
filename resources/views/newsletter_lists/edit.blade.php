@extends("layouts.app")

@section("content")
  <x-card title="Modifica Newsletter">
    <NewsletterListFormUpsert action="{{ route('newsletter_lists.store') }}"
                              cancel-href="{{ route('newsletter_lists.index') }}"
                              submit-text="Aggiorna"
                              :newsletter-list="{{ json_encode($newsletterList) }}"
                              :errors="{{ json_encode($errors->all(["key"=> ":key", "message"=> ":message"])) }}">
      <template v-slot:csrf>
        @csrf
        @method('PATCH')
      </template>
    </NewsletterListFormUpsert>
  </x-card>
@endsection
