@extends('auth.layout')

@section('content')
  <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
    <div class="row w-100">
      <div class="col-lg-4 mx-auto">
        <h2 class="text-center mb-4">Redefinir Senha</h2>
        <div class="auto-form-wrapper">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
        @endif
          <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="input-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}" required>
              </div>
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <button class="btn btn-primary submit-btn btn-block">Enviar link de redefinição</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
