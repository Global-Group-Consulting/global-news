@extends("layouts.app")

@section("content")
  <div class="row justify-content-center">

    <div class="col-12 col-md-10 col-xl-10">

      <div class="card">
        <div class="card-header">{{ __('Lista Notifiche') }}</div>

        <div class="card-body">
          {{-- Data Table --}}
          <table class="table table-striped">
            <thead>
            <tr>
              <th scope="col">Titolo</th>
              <th scope="col">App</th>
              <th scope="col">Tipo</th>
              <th scope="col">Destinatario</th>
              <th scope="col">Piattaforme</th>
              <th scope="col">Letta</th>
              <th scope="col">Data creazione</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($notifications as $singleNews)
              <tr>
                <th scope="row">{{$singleNews->title}}</th>
                <td>{{$singleNews->app}}</td>
                <td>{{$singleNews->type}}</td>
                <td>
                  @foreach($singleNews->receivers as $user)
                    <div>{{$user["firstName"]}} {{$user["lastName"]}} - {{$user["email"]}}<br><small>({{ $user["_id"] }})</small></div>
                  @endforeach
                </td>
                <td>{{$singleNews->platforms ? join(",", $singleNews->platforms) : ''}}</td>
                <td>
                  @if($singleNews->completed)
                    <i class="fas fa-check text-success"></i>
                  @else
                    <i class="fas fa-pause text-warning"></i>
                  @endif</td>
                <td>{{$singleNews->created_at->format("d/m/y H:i")}}</td>
                <td>
                  <a href="{{route('notifications.show', $singleNews->_id)}}" class="btn btn-link">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

          {{-- Pagination --}}
          <div class=" d-flex justify-content-center">
            {{$notifications->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
