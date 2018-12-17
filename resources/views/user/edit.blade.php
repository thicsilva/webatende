@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')

  <!-- content-wrapper -->
<div class="content-wrapper">
@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
@if (Session::has('alert'))
  <div class="alert {{session('alert.type')==='success'?'alert-success':'alert-danger'}} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    {{ session('alert.message')}}
  </div>
@endif
  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Edição de usuário</h4>
          <form action="{{ route('user.update', $user->id)}}" method="post" class="forms-sample">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                  <label for="name">Nome</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check form-check-flat">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin" value="1" {{ old('is_admin', $user->is_admin)?'checked':'' }}>
                      Administrador
                      <i class="input-helper"></i>
                    </label>
                  </div>
                  <div class="form-check form-check-flat">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="show_notification" id="show_notification" value="1" {{ old('show_notification', $user->show_notification)?'checked':'' }}>
                      Exibir notificações
                      <i class="input-helper"></i>
                    </label>
                  </div>
                  <div class="form-check form-check-flat">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="play_sound" id="play_sound" value="1" {{ old('play_sound', $user->play_sound)?'checked':'' }}>
                      Tocar sons na notificação
                      <i class="input-helper"></i>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-success" type="submit">Salvar</button>
              <a href="{{ route('user.index') }}" class="btn btn-light mr-2">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
