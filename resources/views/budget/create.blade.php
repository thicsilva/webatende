@extends('layouts.app')

@section('title', 'Cadastrar Orçamento')

@section('css')
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
@stop

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
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Cadastro de Orçamento</h4>
              <form action="{{ route('budget.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="call_id" value="{{$call->id}}">
                <div class="row">
                  <div class="form-group col-md-12 {{ $errors->has('customer_name') ? 'has-danger' : '' }}">
                    <label for="customer_name">Razão Social</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_contact') }}" required>
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('customer_contact') ? 'has-danger' : '' }}">
                    <label for="customer_contact">Contato</label>
                    <input type="text" name="customer_contact" id="customer_contact" class="form-control" value="{{ old('customer_contact') }}" required>
                  </div>
                  <div class="form-group col-md-6 {{ $errors->has('customer_document') ? 'has-danger' : '' }}">
                    <label for="customer_document">CNPJ/CPF</label>
                    <input type="text" name="customer_document" id="customer_document" class="form-control" value="{{ old('customer_document') }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-danger' : '' }}">
                      <label for="description">Descrição</label>
                      <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                  </div>
                  <div class="form-group col-md-12 {{ $errors->has('filename') ? 'has-danger' : '' }}">
                      <label for="filename">Anexar Arquivo</label>
                      <input type="file" name="filename" id="filename" class="form-control" accept="application/pdf">
                  </div>
                </div>
                <div class="d-flex flex-row-reverse">
                  <button class="btn btn-success" type="submit">Salvar</button>
                  <a href="{{ route('call.show', $call->id) }}" class="btn btn-light mr-2">Cancelar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop


@section('js')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>

<script>
  (function($){
    'use strict';

    $(function(){
      let docNumber = document.getElementById('customer_document');

      Inputmask({"mask": ['999.999.999-99', '99.999.999/9999-99'], "keepstatic":true}).mask(docNumber);

      $('#description').summernote({
        height: 300,
        tabsize: 2
      });

    })
  })(jQuery);
</script>
@stop
