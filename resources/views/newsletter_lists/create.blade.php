@extends("layouts.app")

@section("content")
  <x-card title="{{__('Crea una nuova lista utenti')}}">
    <NewsletterListFormUpsert action="{{ route('newsletter_lists.store') }}"
                          cancel-href="{{ route('newsletter_lists.index') }}"
                          submit-text="Salva"
                          :errors="{{ json_encode($errors->all(["key"=> ":key", "message"=> ":message"])) }}">
      <template v-slot:csrf>
        @csrf
      </template>
    </NewsletterListFormUpsert>
  </x-card>
@endsection
