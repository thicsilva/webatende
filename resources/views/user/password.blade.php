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
          <h4 class="card-title">Alterar senha</h4>
          <form action="{{ route('user.update.password')}}" method="post" class="forms-sample">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                  <label for="password">Senha</label>
                  <input type="password" name="password" id="password" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                  <label for="password_confirmation">Confirme a Senha</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
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
