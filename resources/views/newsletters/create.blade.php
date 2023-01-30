@extends("layouts.app")

@section("content")
  <x-card title="{{__('Crea una nuova Newsletter')}}">
    <x-forms.newsletter-upsert/>
  </x-card>
@endsection
