@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">
      @include('partials.session_success')

      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          Coming Soon! Maybe....
        </div>
      </div>
    </div>
  </div>
@endsection
