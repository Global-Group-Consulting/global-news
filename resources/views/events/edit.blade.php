@extends("layouts.app")

@section("content")
  <x-card :title="'Modifica evento: ' . $event->title" sizeClasses="col-12 col-lg-10 col-xl-9"
          :backUrl="route('events.index')">
    <x-forms.events-upsert :action="route('events.update', $event->_id)"
                           method="PUT"
                           :event="$event"></x-forms.events-upsert>
  </x-card>
@endsection
