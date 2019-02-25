@extends('layouts.app')

@section('title', 'Exibir Chamada')

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
          <h4 class="card-title">Dados Internos</h4>
           <p>OS: <strong>{{$order->os_number}}</strong></p>
           <p>Documentos: <strong>{{$order->documents}}</strong></p>
           <p>Enviado para fábrica? <strong>{{$order->factory?'Sim':'Não'}}</strong></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dados da Entrada/Saída</h4>
          <p>Data Entrada: <strong>{{$order->entrance_date->format('d/m/Y')}}</strong> </p>
          <p>Tipo de Entrada: <strong>{{$order->entranceMovement->description}}</strong></p>
          @if($order->exit_date)
          <p>Data Saída: <strong>{{ optional($order->exit_date)->format('d/m/Y')}} </strong>  </p>
          <p>Tipo de Saída: <strong>{{optional($order->exitMovement)->description}}</strong></p>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dados do Cliente</h4>
           <address>
            <p class="font-weight-bold">{{ $order->customer->name }}</p>
            <p>Contato: <strong>{{ $order->contact }}</strong></p>
          </address>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dados do relógio</h4>
          <p class="font-weight-bold">{{$order->equipment->model}}</p>
          <p>Série: <strong>{{$order->serial}}</strong></p>
          <p class="font-weight-bold">
            Acessórios
            <ul class="list-arrow">
            @foreach($order->accessories as $accessory)
              <li>{{$accessory->description}}</li>
            @endforeach
            </ul>
          </p>
          <p>Defeito: <strong>{{$order->fault}}</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
