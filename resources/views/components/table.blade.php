<div class="table-responsive">

  <table class="table table-striped">
    {{ $colgroup }}

    <thead>
    <tr>
      @foreach($structure as $column)
        <th scope="col">{{$column["title"]}}</th>
      @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($items as $row)
      <tr>
        @foreach($structure as $column)
          <td scope="col">
            @if( isset($column["value"]) )
              {!! $column["value"]($row, $readonly) !!}
            @else
              {{ $row[$column["key"]] }}
            @endif
          </td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>

  {{-- Pagination --}}
  @if(method_exists($items, "links"))
    <div class="d-flex justify-content-center">
      {{$items->links()}}
    </div>
  @endif
</div>
