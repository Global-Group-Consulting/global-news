<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>
    @hasSection("title")
      @yield("title") |
    @endif
    Global Communications</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<div id="app">
  <main class="">
    {{-- sidebar --}}
    <div class="d-flex h-100">
      @auth
        @include('partials.sidebar')
      @endauth

      <div class="flex-fill d-flex flex-column">
        @auth
          @include('partials.navbar')
        @endauth

        <div class="py-4 flex-fill"
             style="oveflow-y:auto; overflow-x: hidden">

          <div class="container">
            @if(session()->has('error'))
              <div class="alert alert-danger">
                {{ session()->get('error') }}
              </div>
            @endif

            @if(session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif

            @yield('content')
          </div>

        </div>
      </div>
    </div>
  </main>
</div>

@yield("scripts")

@livewireScripts
</body>

</html>
