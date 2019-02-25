@extends('auth.layout')
@section('content')
  <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
    <div class="row w-100">
      <div class="col-lg-4 mx-auto">
        <h2 class="text-center mb-4">Registrar</h2>
        <div class="auto-form-wrapper">
          <form action="{{route('register')}}" method="post">
            @csrf
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <div class="input-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{old('name')}}">
              </div>
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="input-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
              </div>
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
              </div>
              @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme a Senha">
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary submit-btn btn-block">Registrar</button>
            </div>
            <div class="text-block text-center my-3">
              <span class="text-small font-weight-semibold">Já possui uma conta?</span>
              <a href="{{route('login')}}" class="text-black text-small">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
