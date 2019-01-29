@extends('layouts.app')

@section('title', 'Cadastrar Entrada')

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
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Entrada de Equipamento</h4>
          <form id="so-create" action="{{ route('so.store')}}" method="post" class="forms-sample">
            @csrf
            <div>
              <h3>Dados do Cliente</h3>
              <section>
                <h6>Dados do Cliente</h6>
                <div class="form-group">
                  <label for="customer_id">Cliente</label>
                  <div class="input-group">
                    <select name="customer_id" id="customer_id" class="form-control">
                    </select>
                    <div class="input-group-append text-white">
                      <button class="btn btn-icons btn-inverse-success" type="button" data-toggle="modal" data-target="#create-customer">
                        <i class="mdi mdi-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="contact">Contato</label>
                  <input type="text" class="form-control" id="contact" name="contact">
                </div>
              </section>
              <h3>Dados do Relógio</h3>
              <section>
                <h6>Dados do Relógio</h6>
                <div class="form-group row">
                  <label for="equipment_id" class="col-md-3">Equipamento</label>
                  <div class="col-md-3">
                    <select name="equipment_id" id="equipment_id" class="form-control select2">

                    </select>
                  </div>
                  <label for="serial" class="col-md-3">Número Série</label>
                  <div class="col-md-3">
                    <input type="text" name="serial" id="serial" class="form-control">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="situation_id" class="col-md-3">Situação</label>
                  <div class="col-md-3">
                    <select name="situation_id" id="situation_id" class="form-control select2">
                    @foreach($situations as $situation)
                      <option value="{{$situation->id}}">{{$situation->description}}</option>
                    @endforeach
                    </select>
                  </div>
                  <label for="accessories" class="col-md-3">Acessórios</label>
                  <div class="col-md-3">
                    <select name="accessories[]" id="accessories" class="form-control select2" multiple>
                    @foreach($accessories as $accessory)
                      <option value="{{$accessory->id}}">{{$accessory->description}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entrance_date"  class="col-md-3">Data Entrada</label>
                  <div class="col-md-3">
                    <input type="date" name="entrance_date" id="entrance_date" class="form-control">
                  </div>
                  <label for="entrance_movement_id" class="col-md-3">Tipo de Entrada</label>
                  <div class="col-md-3">
                    <select name="entrance_movement_id" id="entrance_movement_id" class="form-control select2">
                    @foreach($movements as $movement)
                      <option value="{{$movement->id}}">{{$movement->description}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="fault" class="col-md-3">Defeito apresentado</label>
                  <div class="col-md-9">
                    <textarea name="fault" id="fault" class="form-control"></textarea>
                  </div>
                </div>
              </section>
              <h3>Dados Internos</h3>
              <section>
                <h6>Dados Internos</h6>
                <div class="form-group">
                  <label for="os_number">Número OS</label>
                  <input type="text" name="os_number" id="os_number" class="form-control">
                </div>
                <div class="form-group">
                  <label for="documents">Documentos (NF, Pedido)</label>
                  <textarea name="documents" id="documents" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label for="factory">Enviar para fábrica?</label>
                  <select name="factory" id="factory" class="form-control select2">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                  </select>
                </div>
              </section>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="create-customer">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cadastro de clientes</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route('customer.store')}}" method="post" class="forms-sample">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                <label for="name">Razão Social</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
              </div>
              <div class="form-group {{ $errors->has('fantasy_name') ? 'has-danger' : '' }}">
                <label for="fantasy_name">Fantasia</label>
                <input type="text" name="fantasy_name" id="fantasy_name" class="form-control" value="{{ old('fantasy_name') }}">
              </div>
              <div class="form-group {{ $errors->has('doc_number') ? 'has-danger' : '' }}">
                <label for="doc_number">CPF/CNPJ</label>
                <input type="text" name="doc_number" id="doc_number" class="form-control" value="{{ old('doc_number') }}" required>
              </div>
              <div class="form-group {{ $errors->has('city') ? 'has-danger' : '' }}">
                <label for="city">Cidade</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('phone') ? 'has-danger' : '' }}">
                <label for="phone">Fone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
              </div>
              <div class="form-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <div class="form-check form-check-flat">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="has_contract" id="has_contract" value="1" {{ old('has_contract')?'checked':'' }}>
                    Possui Contrato
                    <i class="input-helper"></i>
                  </label>
                </div>
                <div class="form-check form-check-flat">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="has_restriction" id="has_restriction" value="1" {{ old('has_restriction')?'checked':'' }}>
                    Possui Restrição
                    <i class="input-helper"></i>
                  </label>
                </div>
              </div>
              <div class="form-group" id="restriction">
                <label for="restriction_annotation">Detalhes da Restrição</label>
                <textarea name="restriction_annotation" id="restriction_annotation" cols="30" rows="3" class="form-control">{{ old('restriction_annotation')}}</textarea>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
            <button class="btn btn-success" type="submit">Salvar</button>
            <button class="btn btn-light mr-2" data-dismiss="modal">Cancelar</a>
          </div>
        </form>
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

      var options = [
        @foreach($equipments as $equipment)
        {
          'id': {{$equipment->id}},
          'text': "{{$equipment->model}}",
          'serial': "{{$equipment->serial}}"
        },
        @endforeach
      ]
      var form = $("#so-create");
      form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        stepsOrientation: "vertical",
        onFinished: function (event, currentIndex) {
          form.submit();
        },
        labels: {
          cancel: "Cancelar",
          current: "Etapa atual:",
          pagination: "Paginação",
          finish: "Finalizar",
          next: "Próximo",
          previous: "Anterior",
          loading: "Carregando ..."
      }
      });

      $('#equipment_id').select2({
        placeholder: 'Selecione...',
        data: options,
      });
      $('#equipment_id').on('select2:select', function(e){
        var data = e.params.data;
        $('#serial').val();
        $('#serial').val(data.serial);
      })
      $('#entrance_movement_id').select2({
        placeholder: 'Selecione...'
      });
      $('#accessories').select2({
        tags: true,
        tokenSeparators: [',']
      });

      $('#customer_id').select2({
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
          url: "{{ route('customer.search') }}",
          dataType: 'json',
          type: 'GET',
          data: function(params){
            return {
              term: params.term
            };
          },
          processResults: function(data){
            return {
              results: $.map(data, function(item) {
                return {
                  text: item.name,
                  city: item.city,
                  docNumber: item.doc_number,
                  id: item.id,
                }
              })
            };
          },
          cache: true,
        },
        placeholder: 'Digite Razão, Fantasia ou CNPJ',
        escapeMarkup: function (markup) { return markup; },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
        language: 'pt'
      });

      $('#to_user_id').select2();

      function formatRepo (repo) {
        if (repo.loading) {
          return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
          "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.text + "</div>";

        if (repo.city) {
          markup += "<div class='select2-result-repository__description text-gray'>" + repo.city + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
          "<div class='select2-result-repository__forks text-gray'><small>" + repo.docNumber + "</small></div>" +
        "</div>" +
        "</div>"+
        "</div>";

        return markup;
      }

      function formatRepoSelection (repo) {
        return repo.text;
      }

    })
  })(jQuery);
</script>
@stop
