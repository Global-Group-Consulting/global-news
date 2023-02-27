@extends("layouts.app")

@section("content")
  <x-card title="Modifica Newsletter">
    <NewsletterFormUpsert :newsletter="{{ json_encode($newsletter) }}"
                          :lists="{{ json_encode($lists) }}"
                          action="{{ route('newsletters.update', ['newsletter' => $newsletter->id]) }}"
                          cancel-href="{{ route('newsletters.index') }}"
                          submit-text="Aggiorna"
                          :errors="{{ json_encode($errors->all(["key"=> ":key", "message"=> ":message"])) }}">
      <template v-slot:csrf>
        @csrf
        @method('PATCH')
      </template>
    </NewsletterFormUpsert>
  </x-card>
@endsection
