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
            @foreach($notifications as $notification)
              @php($data = (object) $notification->data)

              <tr>
                <th scope="row">{{$data->title}}</th>
                <td>{{$data->app}}</td>
                <td>{{$data->type}}</td>
                <td>
                  @php($user = (object) $data->receiver)

                  <div>{{$user->firstName}} {{$user->lastName}} - {{$user->email}}<br><small>({{ $user->_id }}
                      )</small></div>
                </td>
                <td>{{property_exists($data, "platforms") ? join(", ", $data->platforms) : ''}}</td>
                <td>
                  @if(!is_null($notification->read_at))
                    <i class="fas fa-check text-success"
                       title="{{$notification->read_at->format("d/m/Y H:i:s")}} ({{ $notification->read_from  }}}})"></i>
                  @else
                    <i class="fas fa-pause text-warning"></i>
                  @endif</td>
                <td>{{$notification->created_at}}</td>
                <td>
                  <a href="{{route('notifications.show', $notification->_id)}}" class="btn btn-link">
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
