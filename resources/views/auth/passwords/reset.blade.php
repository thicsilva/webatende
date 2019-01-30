@extends('auth.layout')

@section('content')
  <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
    <div class="row w-100">
      <div class="col-lg-4 mx-auto">
        <h2 class="text-center mb-4">Redefinir Senha</h2>
        <div class="auto-form-wrapper">
          <form action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="input-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}" required autofocus>
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
              <button class="btn btn-primary submit-btn btn-block">Redefinir Senha</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
