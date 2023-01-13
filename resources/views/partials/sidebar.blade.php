<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark"
     style="width: 280px;">
  <a href="/"
     class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <span class="fs-4">Global Communications</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="/"
         class="nav-link text-white {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"
         aria-current="page">
        <i class="fas fa-tachometer-alt"></i>
        Home
      </a>
    </li>
    <li>
      <a href="{{ route('news.index') }}"
         class="nav-link text-white {{ (strpos(Route::currentRouteName(), 'news.') === 0) ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i>
        News
      </a>
    </li>

    <li>
      <a href="{{ route('notifications.index') }}"
         class="nav-link text-white {{ (strpos(Route::currentRouteName(), 'notifications.') === 0) ? 'active' : '' }}">
        <i class="fas fa-bell"></i>
        Notifiche
      </a>
    </li>
<!--    <li>
      <a href="{{ route('events.index') }}"
         class="nav-link text-white {{ (strpos(Route::currentRouteName(), 'events.') === 0) ? 'active' : '' }}">
        <i class="fas fa-laptop-house"></i>
        Eventi
      </a>
    </li>-->
    <li>
      <a href="{{ route('faqs.index') }}"
         class="nav-link text-white {{ (strpos(Route::currentRouteName(), 'faqs.') === 0) ? 'active' : '' }}">
        <i class="fas fa-question"></i>
        FAQ
      </a>
    </li>
    <li>
      <a href="{{ route('newsletters.index') }}"
         class="nav-link text-white {{ (strpos(Route::currentRouteName(), 'newsletters.') === 0) ? 'active' : '' }}">
        <i class="fas fa-ad"></i>
        Newsletter
      </a>
    </li>
  </ul>

</div>
