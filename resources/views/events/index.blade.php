@extends('layouts.app')

@section("content")

  <x-card title="Eventi futuri" :includeBackBtn="false" class="mb-5">
    <x-slot name="before">
      <ul class="nav mb-4 justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="{{route('events.create')}}">
            <i class="fas fa-plus"></i>
            Aggiungi</a>
        </li>
      </ul>
    </x-slot>

    <x-table :structure="$tableStructure" :items="$futureEvents">
      <x-slot name="colgroup">
        <colgroup>
          <col>
          <col>
          <col>
          <col>
          <col>
          <col>
          <col style="width: 1%">
        </colgroup>
      </x-slot>

    </x-table>
  </x-card>

  <x-card title="Prossimi eventi" :includeBackBtn="false">

    <x-table :structure="$tableStructure" :items="$pastEvents" readonly>
      <x-slot name="colgroup">
        <colgroup>
          <col>
          <col>
          <col>
          <col>
          <col>
          <col>
          <col style="width: 1%">
        </colgroup>
      </x-slot>

    </x-table>
  </x-card>

  @include("partials.modals.delete", [
   "action"=> route("events.destroy", "_id")
 ])
@endsection
