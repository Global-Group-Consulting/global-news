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

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&display=swap" rel="stylesheet">

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
              <div class="alert alert-danger mx-3">
                {{ session()->get('error') }}
              </div>
            @endif

            @if(session()->has('success'))
              <div class="alert alert-success mx-3">
                {{ session()->get('success') }}
              </div>
            @endif
          </div>

          @yield('content')
        </div>
      </div>
    </div>
  </main>
</div>

@yield("scripts")

<script type="text/javascript">
  bkLib.onDomLoaded(nicEditors.allTextAreas);


</script>
</body>

</html>
