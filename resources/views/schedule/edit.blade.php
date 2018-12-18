@extends('layouts.app')

@section('title', 'Agendamento')
@section('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Agendamento</h4>
          <form action="{{ route('schedule.update', $schedule->id)}}" method="post" class="forms-sample">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="form-group col-md-6 {{ $errors->has('description') ? 'has-danger' : '' }}">
                <label for="name">Descrição</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $schedule->description) }}" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('customer_id') ? 'has-danger' : '' }}">
                <label for="name">Cliente</label>
                <div class="input-group">
                  <select name="customer_id" id="customer_id" class="form-control">
                    <option value="{{ $schedule->customer_id }}">{{$schedule->customer->name}}</option>
                  </select>
                  <div class="input-group-append text-white">
                    <button class="btn btn-icons btn-inverse-success" type="button" data-toggle="modal" data-target="#create-customer">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('dates') ? 'has-danger' : '' }}">
                <label for="dates">Data</label>
                <input type="text" name="dates" id="dates" class="form-control" value="{{ old('dates', $schedule->initial_date->format('d/m/Y H:i:s') . ' - ' . $schedule->final_date->format('d/m/Y H:i:s')) }}" required>
              </div>
              <div class="form-group col-md-6{{ $errors->has('to_user_id') ? 'has-danger' : '' }}">
                <label for="to_user_id">Para usuário (opcional)</label>
                <select name="to_user_id" id="to_user_id" class="form-control">
                  <option value="">Selecione</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" {{old('to_user_id', $schedule->to_user_id)==$user->id?'selected':''}}>{{ $user->name}} </option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-success" type="submit">Salvar</button>
              <a href="{{ route('schedule.index') }}" class="btn btn-light mr-2">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal" id="create-customer">
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
        $('#dates').daterangepicker({
          timePicker: true,
          minDate: moment().startOf('hour'),
          startDate: moment().startOf('hour'),
          endDate: moment().startOf('hour').add(32, 'hour'),
          timePicker: true,
          timePicker24Hour: true,
          timePickerIncrement: 15,
          locale: {
            format: 'DD/MM/YYYY HH:mm:ss',
            separator: " - ",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            fromLabel: "De",
            toLabel: "Para",
            daysOfWeek: [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            monthNames: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
            firstDay: 0
          }
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

        $('#user_id').select2();

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
      });
    })(jQuery);
  </script>
@stop
