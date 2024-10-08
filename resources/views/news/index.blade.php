@extends("layouts.app")

@section("content")
  <x-card title="Lista News" sizeClasses="col-12 col-lg-10">
    <x-slot name="before">
      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('news.create')}}">
            <i class="fas fa-plus"></i>
            Aggiungi</a>
        </li>
      </ul>
    </x-slot>

    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">Titolo</th>
        <th scope="col">Visibilità</th>
        <th scope="col">App</th>
        <th scope="col">Stato</th>
        <th scope="col">Ultima modifica</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach($news as $singleNews)
        <tr>
          <th scope="row">{{$singleNews->title}}</th>
          <td>
            @if($singleNews->startAt)
              dal {{\Carbon\Carbon::parse($singleNews->startAt)->format("d/m/y")}}
            @endif

            @if($singleNews->startAt && $singleNews->endAt)
              <br>
            @endif

            @if($singleNews->endAt)
              al {{\Carbon\Carbon::parse($singleNews->endAt)->format("d/m/y")}}
            @endif
          </td>
          <td>{{join(", ", $singleNews->apps)}}</td>
          <td>{{$singleNews->active ? "Attivo" : "Non attivo"}}</td>
          <td>{{\Carbon\Carbon::parse($singleNews->updated_at)->format("d/m/y H:i")}}</td>
          <td>
            <a href="{{route('news.edit', $singleNews->_id)}}" class="btn btn-link">
              <i class="fas fa-edit"></i>
            </a>
            <a href="{{route('news.show', $singleNews->_id)}}" class="btn btn-link">
              <i class="fas fa-eye"></i>
            </a>
            <button class="btn btn-link text-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-bs-id="{{$singleNews->_id}}">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    {{-- Pagination --}}
    <div class=" d-flex justify-content-center">
      {{$news->links()}}
    </div>
  </x-card>

  @include("partials.modals.delete", [
    "action"=> route("news.destroy", "_id")
  ])
@endsection
