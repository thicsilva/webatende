@extends('layouts.app')

@section('title', 'Exibir Orçamento')

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
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dados do Cliente</h4>
           <address>
            <p class="font-weight-bold">{{ $budget->customer_name }}</p>
            <p>{{ $budget->customer_document }}</p>
            <p>{{ $budget->customer_contact }}</p>
          </address>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            Observações
          </h4>
          <p>Chamada: <strong><a href="{{route('call.show', $budget->call->id )}}">{{$budget->call->id}} </a></strong></p>
          <p>Criado por: <strong>{{ $budget->user->name }}</strong></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Descrição</h4>
          {!! $budget->description !!}
        </div>
      </div>
    </div>
  </div>
  @if(!empty($budget->filename))
  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Orçamento Anexado</h4>
          <a href="{{ asset('storage/budgets/' . $budget->filename) }}" class="btn btn-info" target="_blank"><i class="mdi mdi-file-pdf-box"></i> Visualizar</a>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

@stop
