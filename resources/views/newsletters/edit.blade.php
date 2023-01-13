@extends("layouts.app")

@section("content")
  <x-card title="Modifica Newsletter">
    <x-forms.newsletter-upsert :newsletter="$newsletter"/>
  </x-card>
@endsection
