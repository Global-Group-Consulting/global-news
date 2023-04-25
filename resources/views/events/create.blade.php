@extends("layouts.app")

@section("content")
  <x-card title="Crea un nuovo evento" sizeClasses="col-12 col-lg-10 col-xl-9"
          :backUrl="route('events.index')">
    <x-forms.events-upsert :action="route('events.store')" ></x-forms.events-upsert>
  </x-card>
@endsection
