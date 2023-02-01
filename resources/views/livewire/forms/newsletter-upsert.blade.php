<form action="{{ route($actionRoute, $actionRouteParams) }}"
      method="POST"
      enctype="multipart/form-data">
  @csrf
  @method($method)

  <div class="row">
    <div class="col">
      <livewire:form-input label="Oggetto"
                           name="subject" :value="$newsletter['subject']"/>
    </div>
  </div>

  <div class="row">
    <div class="col" x-data="{ disabled: @entangle('newsletter.send_asap') }">
      <livewire:form-input label="Lista destinatari"
                           name="subject"
                           wire:model="newsletter.subject"
                           x-bind:disabled="disabled"
      />

      <input type="text" x-bind:disabled="disabled">

      <h1><span x-text="disabled">asasd</span></h1>
    </div>
  </div>

  <div class="row">
    <div class="col">

      <livewire:form-input label="Data invio" type="datetime-local"
                           name="scheduled_at" :value="$newsletter['scheduled_at']"
                           wire:disabled="newsletter.send_asap"
      />
    </div>
    <div class="col">
      {{$newsletter['send_asap']}}
      <livewire:form-switch label="Invio immediato"
                            name="send_asap" :checked="$newsletter['send_asap']"/>
    </div>
  </div>

  {{--  <div class="row">--}}
  {{--    <div class="col">--}}
  {{--      <livewire:form-switch label="Invia subito"--}}
  {{--                            name=""--}}
  {{--                            type="switch"/>--}}
  {{--    </div>--}}

  {{--    <div class="col">--}}
  {{--      {{old('start_at')}}--}}
  {{--      <livewire:form-input label="Data invio programmato"--}}
  {{--                           name="start_at"--}}
  {{--                           type="date"--}}
  {{--                           :value="$newsletter['start_at']"/>--}}
  {{--    </div>--}}
  {{--  </div>--}}


  <div class="row">
    <div class="col">
      <livewire:form-text-editor label="Contenuto"
                                 name="content"
                                 :value="$newsletter['content']"/>
    </div>

    <div class=" d-flex">
      <a href="{{route('newsletters.index')}}"
         class="btn btn-outline-secondary me-3"
         type="reset">{{ $cancelText }}</a>
      <button class="btn btn-success"
              type="submit">{{ $submitText  }}</button>
    </div>
</form>
