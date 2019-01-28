@extends('layouts.app')

@section('title', 'Chamadas')

@section('content')
<!-- content-wrapper -->
<div class="content-wrapper">
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
          <form class="forms-sample" action="{{ route('call.index') }}" method="get" id="search-call">
            <div class="row mb-5">
              <div class="col">
                <input type="text" name="customer" id="customer" class="form-control" placeholder="Cliente" value="{{ Request::input('customer') }}">
              </div>
              <div class="col">
                <input type="text" name="to_user" id="to_user" class="form-control" placeholder="Para" value="{{ Request::input('to_user') }}">
              </div>
              <div class="col">
                  <input type="date" name="initial_date" id="initial_date" class="form-control" placeholder="Data Inicial" value="{{ Request::input('initial_date') }}">
              </div>
              <div class="col">
                <input type="date" name="final_date" id="final_date" class="form-control" placeholder="Data Inicial" value="{{ Request::input('final_date') }}">
              </div>
              <div class="col">
                <button class="btn btn-inverse-dark">
                  <i class="mdi mdi-magnify"></i>
                  Pesquisar
                </button>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <!-- table component -->
            <table class="table sortable-table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>#ID</th>
                  <th>Cliente</th>
                  <th>Status</th>
                  <th>Para</th>
                  <th>Data</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach($calls as $call)
                <tr>
                  <td>
                    <a href="{{ route('call.show', $call->id) }}">#{{ $call->id }}</a>
                  </td>
                  <td>
                    {{ $call->customer->name }}
                  @if($call->customer->has_contract)
                    <span class="badge badge-success">Contrato</span>
                  @endif
                  @if($call->customer->has_restriction)
                    <span class="badge badge-danger">Restrição</span>
                  @endif
                  </td>
                  <td>
                    <span class="status-indicator {{$call->status?'online':'away'}}"></span>
                    {{$call->status?'Encerrada':'Aberta'}}
                  </td>
                  <td> {{ $call->toUser->name}}</td>
                  <td> {{ $call->created_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <div class="btn-group" role="group">
                      @if (($call->to_user_id == auth()->user()->id or auth()->user()->is_admin) and (!$call->status))
                      <form action="{{ route('call.close', $call->id) }}" method="post">
                        @csrf
                        <button class="btn btn-inverse-dark" type="submit">
                          <i class="mdi mdi-close-outline"></i>
                          Encerrar
                        </button>
                      </form>
                      @else
                      <a href="{{ route('call.show', $call->id) }}" class="btn btn-inverse-primary">
                        <i class="mdi mdi-eye"></i>
                        Visualizar
                      </a>
                      @endif
                    </div>
                    @if($call->fromUser->id==auth()->user()->id)
                    <div class="btn-group" role="group">
                      <form action="{{ route('call.delete', $call->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-inverse-danger" type="submit">
                          <i class="mdi mdi-delete"></i>
                            Excluir
                        </button>
                      </form>
                    </div>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row mt-5">
            {{ $calls->appends(Request::except('page'))->links()}}
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

        $('.btn-inverse-danger').each(function(){
          $(this).on('click', function(e){
            e.preventDefault();
            let form = $(this).parents('form');
            swal({
              title: "Confirma a exclusão?",
              text: "Após excluído, não será possível recuperar os dados",
              icon: "warning",
              buttons: ["Cancelar", "Confirmar"],
              dangerMode: true,
            }).then((confirmDelete) => {
              if (confirmDelete){
                form.submit();
              }
            });
          })
        })
      })
    })(jQuery);
  </script>
@stop



