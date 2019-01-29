@extends('layouts.app')

@section('title', 'Entrada de Equipamentos')
@section('css')

@stop
@section('content')
<!-- content-wrapper -->
<div class="content-wrapper">
  <div class="add-button">
    <button onclick="location.href='{{route('so.create')}}'" class="main" data-toggle="modal" data-target="#add">
      <i class="mdi mdi-plus"></i>
  </button>
  </div>
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
          <h4 class="class-title">Pesquisar</h4>
          <form class="forms-sample" action="{{ route('so.index') }}" method="get">
            <div class="row mb-5">
              <div class="col">
                <input type="text" name="os_number" id="os_number" class="form-control" placeholder="OS" value="{{ Request::input('os_number') }}">
              </div>
              <div class="col">
                <input type="text" name="customer" id="customer" class="form-control" placeholder="Cliente" value="{{ Request::input('customer') }}">
              </div>
              <div class="col">
                  <input type="date" name="entrance_date" id="entrance_date" class="form-control" placeholder="Data Inicial" value="{{ Request::input('entrance_date') }}">
              </div>
              <div class="col">
                <select name="situation" id="situation" class="form-control">
                  <option value="">...</option>
                @foreach($situations as $situation)
                  <option value="{{$situation->id}}">{{$situation->description}}</option>
                @endforeach
                </select>
              </div>
              <div class="col">
                <input type="text" name="serial" id="serial" class="form-control" placeholder="Nº Série" value="{{ Request::input('serial')}}">
              </div>
              <div class="col">
                <div class="form-check form-check-flat">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="status" id="status" value="1" {{Request::input('status')?'checked':''}}>
                      Listar Encerrados
                      <i class="input-helper"></i>
                    </label>
                  </div>
              </div>
              <div class="col">
                <button class="btn btn-inverse-dark">
                  <i class="mdi mdi-magnify"></i>
                  Pesquisar
                </button>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-12 text-center">
            @foreach($situations as $situation)
              <label class="badge" style="background-color:{{$situation->color}}">{{$situation->description}} <span class="badge badge-dark">{{$situation->serviceOrders->count()}}</span></label>
            @endforeach
            </div>
          </div>
          <div class="table-responsive">
            <table class="table sortable-table table-bordered table-sm" id="table">
              <thead>
                <tr>
                  <th>OS</th>
                  <th>Cliente</th>
                  <th>Data Entrada</th>
                  <th>Situação</th>
                  <th>Equipamento</th>
                  <th>Nº Série</th>
                  <th>Contato</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              @foreach($orders  as $order)
                <tr bgcolor="{{$order->situation->color}}">
                  <td>{{ $order->os_number }}</td>
                  <td>{{ $order->customer->name }}</td>
                  <td>{{ $order->entrance_date->format('d/m/Y') }}</td>
                  <td>{{ $order->situation->description }}</td>
                  <td>{{ $order->equipment->model }}</td>
                  <td>{{ $order->serial }}</td>
                  <td>{{ $order->contact }}</td>
                  <td class="text-center">
                    <div class="btn-group dropdown">
                      <button class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                      </button>
                      <div class="dropdown-menu">
                      <form action="{{ route('so.status', $order->id )}}" class="status"  method="post" style="display:none">
                        @csrf
                      </form>
                      @if($order->status)
                        <a href="{{route('so.edit', $order->id)}}" class="dropdown-item ">
                          <i class="mdi mdi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('so.delete', $order->id )}}" class="delete"  method="post" style="display:none">
                        @csrf
                        @method('DELETE')
                        </form>
                        <a href="#" class="dropdown-item delete">
                          <i class="mdi mdi-delete"></i> Excluir
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item status">
                          <i class="mdi mdi-lock-outline"></i> Encerrar
                        </a>
                      @elseif(auth()->user()->is_admin)
                        <a href="#" class="dropdown-item status">
                          <i class="mdi mdi-lock-open-outline"></i> Reabrir
                        </a>
                      @endif
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div class="row mt-5">
            {{ $orders->appends(Request::except('page'))->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('js')
  <script>
    (function($){
      'use strict';
      $(function(){
        $('.delete').each(function(){
          $(this).on('click', function(e){
            e.preventDefault();
            let form = $(this).parent().find('form.delete');
            console.log(form);
            swal({
              title: "Confirma a exclusão?",
              icon: "warning",
              buttons: ["Cancelar", "Confirmar"],
              dangerMode: true,
            }).then((confirmDelete) => {
              if (confirmDelete){
                form.submit();
              }
            });
          })
        });
        $('.status').each(function(){
          $(this).on('click', function(e){
            e.preventDefault();
            var form = $(this).parent().find('form.status');
            form.submit();
          })
        })
      })
    })(jQuery);
  </script>
@stop



