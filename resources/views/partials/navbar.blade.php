<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="z-index: 2">
  <div class="container-fluid">
   {{--  <a class="navbar-brand" href="{{ url('/') }}">
      Global SSO
    </a> --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" v-pre>
            {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
          </a>

          <div class="dropdown-menu dropdown-menu-right"
            aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}"
              method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
