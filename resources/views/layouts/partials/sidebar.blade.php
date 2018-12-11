<!-- sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name">{{Auth::user()->name}}</p>
            <div>
              <small class="designation text-muted">{{Auth::user()->is_admin?'Administrador':'Usuário'}}</small>
              <span class="status-indicator online"></span>
            </div>
          </div>
        </div>
        <button class="btn btn-success btn-block">Nova chamada
          <i class="mdi mdi-plus"></i>
        </button>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-customer" aria-expanded="false" aria-controls="ui-customer">
        <i class="menu-icon mdi mdi-account-group"></i>
        <span class="menu-title">Clientes</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-customer">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.create') }}">Novo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.index') }}">Todos</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-call" aria-expanded="false" aria-controls="ui-call">
        <i class="menu-icon mdi mdi-phone-classic"></i>
        <span class="menu-title">Chamados</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-call">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="#">Todos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Para Você</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
<!-- end sidebar -->
