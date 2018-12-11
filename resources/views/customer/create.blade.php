@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')

  <!-- content-wrapper -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Cadastro de Cliente</h4>
              <form action="{{ route('customer.store')}}" method="post" class="forms-sample">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Razão Social</label>
                      <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                      <label for="fantasy_name">Fantasia</label>
                      <input type="text" name="fantasy_name" id="fantasy_name" class="form-control" value="{{ old('fantasy_name') }}">
                    </div>
                    <div class="form-group">
                      <label for="doc_number">CPF/CNPJ</label>
                      <input type="text" name="doc_number" id="doc_number" class="form-control" value="{{ old('doc_number') }}" required>
                    </div>
                    <div class="form-group">
                      <label for="city">Cidade</label>
                      <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Fone</label>
                      <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
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
                      <textarea name="restriction_annotation" id="restriction_annotation" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-row-reverse">
                  <button class="btn btn-success" type="submit">Salvar</button>
                  <a href="{{ route('customer.index') }}" class="btn btn-light mr-2">Cancelar</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
  (function($){
    'use strict';

    $(function(){
      $('#restriction').hide();

      $('#has_restriction').on('click', function(){
        if (this.checked){
          $('#restriction').show();
        } else {
          $('#restriction').hide();
        }
      });

    })
  })(jQuery);
</script>
@stop
