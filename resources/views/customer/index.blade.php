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
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table">
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
                  @foreach($customers as $customer)
                    <tr class="{{ $customer->has_contract?'table-success':''}} {{$customer->has_restriction?'table-danger':'' }}">
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->fanstasy_name }}</td>
                      <td>{{ $customer->doc_number }}</td>
                      <td>{{ $customer->phone }}</td>
                      <td>{{ $customer->city }}</td>
                      <td>
                        <div class="btn-group btn-group-md">
                          <a href="{{ route('customer.edit', $customer->id)}}" class="btn btn-primary mr-2">Editar</a>
                          <form action="{{ route('customer.delete', $customer->id) }}" method="post" class="form-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop



