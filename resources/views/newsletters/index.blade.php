@extends("layouts.app")

@section("content")

  <ul class="nav mb-4 justify-content-center">
    <li class="nav-item">
      <a class="nav-link" href="{{route('newsletters.create')}}">
        <i class="fas fa-plus"></i>
        Aggiungi</a>
    </li>
  </ul>

  <div class="card">
    <div class="card-header">{{ __('Lista Newsletter') }}</div>

    <div class="card-body">
      {{-- Data Table --}}
      <livewire:newsletters-table :newsletters="$newsletters"/>

      {{-- Pagination --}}
      <div class=" d-flex justify-content-center">
        {{--{{$newsletters->links()}}--}}
      </div>
    </div>
  </div>

  @include("partials.modals.delete", [
    "action"=> route("newsletters.destroy", "_id")
  ])
@endsection
