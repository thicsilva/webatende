@extends('auth.layout')

@section('content')
  <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
    <div class="row w-100">
      <div class="col-lg-4 mx-auto">
        <h2 class="text-center mb-4">Verifique seu e-mail</h2>
        <div class="auto-form-wrapper">
          @if (session('resent'))
            <div class="alert alert-success" role="alert">
            Um novo link de verificação foi enviado para o seu endereço de e-mail.
            Antes de prosseguir, verifique se recebeu um link de verificação em seu e-mail.
            Se você não recebeu o email, <a href="{{ route('verification.resend') }}">clique aqui para solicitar outro</a>.
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@stop

