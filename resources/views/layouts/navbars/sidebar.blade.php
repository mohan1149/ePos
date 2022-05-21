<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <div class="logo">
    <a href="/home" class="simple-text logo-normal">
      {{ __('ePOs') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('t.dashboard') }}</p>
        </a>
      </li>
      @if (auth()->user()->role == 3)
      <li class="nav-item {{ (Request::segment(1) == 'profile' || Request::segment(1) == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#user_management" aria-expanded="true">
          <i class="material-icons">person</i>
          <p>{{ __('t.user_management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="user_management">
          <ul class="nav">
            <li class="nav-item{{ Request::segment(1) == 'add-user' ? ' active' : '' }}">
              <a class="nav-link" href="/add-user">
                <i class="material-icons">person_add</i>
                <span class="sidebar-normal">{{ __('t.add_user') }} </span>
              </a>
            </li>
            <li class="nav-item{{ Request::segment(1) == 'users' ? ' active' : '' }}">
              <a class="nav-link" href="/users">
                <i class="material-icons">person</i>
                <span class="sidebar-normal"> {{ __('t.users') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @endif
    </ul>
  </div>
</div>
