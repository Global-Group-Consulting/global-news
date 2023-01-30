<table class="table table-striped">
  <thead>
  <tr>
    @foreach($columns as $column)
      <th scope="col">{{$column["label"]}}</th>
    @endforeach
  </tr>
  </thead>
  <tbody>

  @foreach($data as $row)
    <tr>
      @foreach($columns as $column)
        <td>
          @php
            $value = key_exists("name", $column) ? $row->{$column["name"]} : null;
          @endphp
          @if($column["type"] == "date")
            {{ $value ? \Carbon\Carbon::parse($value)->format("d/m/y") : '' }}
          @elseif($column["type"] == "datetime")
            {{ $value ? \Carbon\Carbon::parse($value)->format("d/m/y H:i") : '' }}
          @elseif($column["type"] == "boolean")
            {{$row->{$column["name"]} ? "Si" : "No"}}
          @elseif($column["type"] == "array")
            {{join(", ", $row->{$column["name"]})}}
          @elseif($column["type"] == "livewire")
            @livewire($column["component"], ["row" => $row, "column" => $column])
          @else
            {{$row[$column["name"]]}}
          @endif
        </td>
      @endforeach
    </tr>

  @endforeach

  </tbody>
</table>

{{-- Pagination --}}
<div class=" d-flex justify-content-center">
  {!! $pagination !!}
</div>
