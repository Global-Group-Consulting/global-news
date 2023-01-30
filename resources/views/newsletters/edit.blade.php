@extends("layouts.app")

@section("content")
  <x-card title="Modifica Newsletter">
    <x-forms.newsletter-upsert :newsletter="$newsletter"
                               method="PATCH"
                               actionRoute="newsletters.update"
                               :actionRouteParams="['newsletter' => $newsletter->id]"
                               submitText="Aggiorna"/>
  </x-card>
@endsection
