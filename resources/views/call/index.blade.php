@extends('layouts.app')

@section('title', 'Chamadas para você')

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
                <input type="text" name="name" id="name" class="form-control" placeholder="Razão" value="{{ Request::input('name') }}">
              </div>
              <div class="col">
                <input type="text" name="fantasy_name" id="fantasy_name" class="form-control" placeholder="Fantasia" value="{{ Request::input('fantasy_name') }}">
              </div>
              <div class="col">
                  <input type="text" name="doc_number" id="doc_number" class="form-control" placeholder="CNPJ/CPF" value="{{ Request::input('doc_number') }}">
              </div>
              <div class="col">
                <input type="text" name="city" id="city" class="form-control" placeholder="Cidade" value="{{ Request::input('city') }}">
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
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Contato</th>
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
                    <a href="{{ route('call.show', $call->id) }}">{{ $call->customer->name }}</a>
                  </td>
                  <td>{{ $call->contact }}</td>
                  <td>
                    <span class="status-indicator {{$call->status?'online':'away'}}"></span>
                    {{$call->status?'Encerrada':'Aberta'}}
                  </td>
                  <td> {{ $call->toUser->name}}</td>
                  <td> {{ $call->created_at->format('d/m/Y h:i') }}</td>
                  <td>
                    <div class="btn-group" role="group">
                      @if (($call->to_user_id == auth()->user()->id or auth()->user()->is_admin) and (!$call->status))
                      <form action="{{ route('call.close', $call->id) }}" method="post">
                        @csrf
                        <button class="btn btn-inverse-primary" type="submit">
                          <i class="mdi mdi-close-outline"></i>
                          Encerrar
                        </button>
                      </form>
                      @else
                      <a href="{{ route('call.show', $call->id) }}" class="btn btn-inverse-success">
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
        let docNumber = document.getElementById('doc_number');
        let phone = document.getElementById('phone');
        Inputmask({"mask": ['999.999.999-99', '99.999.999/9999-99'], "keepstatic":true}).mask(docNumber);
        Inputmask({"mask": ['(99)9999-9999', '(99)99999-9999'], "keepstatic":true}).mask(phone);
        $('#restriction').hide();

        $('#has_restriction').on('click', function(){
          if (this.checked){
            $('#restriction').show();
          } else {
            $('#restriction').hide();
          }
        });

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



