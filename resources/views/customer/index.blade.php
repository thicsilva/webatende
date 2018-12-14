@extends('layouts.app')

@section('title', 'Clientes')
@section('css')

@stop
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
          <form action="{{ route('customer.index') }}" method="get" id="search-customer">
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
            <table class="table table-striped table-responsive" id="table">
              <thead>
                <tr>
                  <th>Razão Social</th>
                  <th>Fantasia</th>
                  <th>CNPJ/CPF</th>
                  <th>Fone</th>
                  <th>Cidade</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              @if (empty($customers))
                <h4 class="class-title">Não há registros</h4>
              @endif
              @foreach($customers as $customer)
                <tr class="{{ $customer->has_contract?'table-success':''}} {{$customer->has_restriction?'table-danger':'' }}">
                  <td>{{ $customer->name }}</td>
                  <td>{{ $customer->fantasy_name }}</td>
                  <td>{{ $customer->doc_number }}</td>
                  <td>{{ $customer->phone }}</td>
                  <td>{{ $customer->city }}</td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="{{ route('customer.edit', $customer->id)}}" class="btn btn-icons btn-inverse-primary" title="Editar">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </div>
                    <div class="btn-group" role="group">
                      <form action="{{ route('customer.delete', $customer->id) }}" method="post" class="form-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-icons btn-inverse-danger" type="submit" title="Excluir">
                            <i class="mdi mdi-delete"></i>
                          </button>
                        </form>
                    </div>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div class="row mt-5">
            {{ $customers->appends(Request::except('page'))->links()}}
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
        Inputmask({"mask": ['999.999.999-99', '99.999.999/9999-99'], "keepstatic":true}).mask(docNumber);
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



