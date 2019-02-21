<!-- navbar -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ route('home')}}">
      <img src="{{ asset('images/logo.png') }}" alt="logo" />
      <span class="brand-name"> WebAtende</span>
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}">
      <img src="{{ asset('images/logo.png') }}" alt="logo" />
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center">
    <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
      <li class="nav-item {{ Request::is('schedule*')?'active':''}}">
        <a href="{{ route('schedule.index') }}" class="nav-link">
          <i class="mdi mdi-calendar-clock"></i>Agendamentos
        </a>
      </li>
      <li class="nav-item {{ Request::is('service-orders*')?'active':''}}">
        <a href="{{route('so.index')}}" class="nav-link">
          <i class="mdi mdi-swap-horizontal"></i>Entradas/Saídas
        </a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-file-outline"></i>
          @if($schedules->count()>0)<span class="count">{{$schedules->count()}}</span>@endif
        </a>
        @if($schedules->count()>0)
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          @foreach($schedules as $schedule)
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis font-weight-medium text-dark">{{$schedule->customer->name}}
                <span class="float-right font-weight-light small-text">{{$schedule->initial_date->diffForHumans()}}</span>
              </h6>
              <p class="font-weight-light small-text">
                {{$schedule->description}}
              </p>
            </div>
          </a>
          @endforeach
        </div>
        @endif
      </li>
      @if(auth()->user()->show_notification)
      <notification user_id="{{auth()->user()->id}}" base_url="{{ asset('') }}" sound_notification="{{ auth()->user()->play_sound }}"></notification>
      @endif
      <audio id="sound-notification">
        <source src="{{asset('uploads/notify.mp3')}}" type="audio/mpeg">
      </audio>
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="profile-text">Olá, {{ Auth::user()->name }} !</span>
          <img class="img-xs rounded-circle" src="{{ asset('uploads/users/' . auth()->user()->avatar) }}" alt="Profile image">
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <a href="{{ route('user.profile') }}" class="dropdown-item mt-2">
            Editar Perfil
          </a>
          <a href="{{ route('user.password') }}" class="dropdown-item">
            Alterar Senha
          </a>
          <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('form-logout').submit();">
            Encerrar Sessão
          </a>
          <form action="{{ route('logout') }}" method="post" id="form-logout" style="display:none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<!-- end navbar -->
