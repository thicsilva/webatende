<!-- sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name">{{Auth::user()->name}}</p>
            <div>
              <small class="designation text-muted">{{Auth::user()->is_admin?'Administrador':'Usuário'}}</small>
              <span class="status-indicator online"></span>
            </div>
          </div>
        </div>
        <a href="{{route('call.create')}}" class="btn btn-success btn-block">Nova chamada
          <i class="mdi mdi-plus"></i>
        </a>
      </div>
    </li>
    <li class="nav-item {{request()->is('home')?'active':''}}">
      <a class="nav-link " href="{{ route('home') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-customer" aria-expanded="{{request()->is('customer*')?'true':'false'}}" aria-controls="ui-customer">
        <i class="menu-icon mdi mdi-factory"></i>
        <span class="menu-title">Clientes</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{request()->is('customer*')?'show':''}}" id="ui-customer">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{request()->is('customer/create')?'active':''}}" href="{{ route('customer.create') }}">Novo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{request()->is('customer')?'active':''}}" href="{{ route('customer.index') }}">Todos</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-call" aria-expanded="{{request()->is('call*')?'true':'false'}}" aria-controls="ui-call">
        <i class="menu-icon mdi mdi-phone-classic"></i>
        <span class="menu-title">Chamadas</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{request()->is('call*')?'show':''}}" id="ui-call">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{request()->is('call')?'active':''}}" href="{{ route('call.index') }}">Todas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{request()->is('call/for-you')?'active':''}}" href="{{ route('call.foryou') }}">Para Você</a>
          </li>
        </ul>
      </div>
    </li>
    @if (auth()->user()->is_admin)
    <li class="nav-item {{request()->is('user')?'active':''}}">
      <a class="nav-link" href="{{ route('user.index') }}">
        <i class="menu-icon mdi mdi-account-multiple"></i>
          Usuários
      </a>
    </li>
    @endif
  </ul>
</nav>
<!-- end sidebar -->
