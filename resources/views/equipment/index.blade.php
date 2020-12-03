@extends('layouts.app')

@section('title', 'Equipamentos')
@section('css')

@stop
@section('content')
<!-- content-wrapper -->
<div class="content-wrapper">
  <div class="add-button">
    <button class="main" data-toggle="modal" data-edit="false" data-target="#modal">
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
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>Modelo</th>
                  <th>Tipo</th>
                  <th>Série</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              @foreach($equipments as $equipment)
                <tr>
                  <td>{{ $equipment->model }}</td>
                  <td>{{ $equipment->type->description }}</td>
                  <td>{{ $equipment->serial }}</td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="#" data-toggle="modal" data-target="#modal" data-edit="true" data-id="{{$equipment->id}}" data-model="{{$equipment->model}}" data-type="{{$equipment->type_id}}" data-serial="{{$equipment->serial}}" class="btn btn-icons btn-inverse-primary" title="Editar">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </div>
                    <div class="btn-group" role="group">
                      <form action="{{ route('equipment.delete', $equipment->id )}}" method="post" id="equipment-delete-{{$equipment->id}}" class="form-inline">
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
		  <div class="row mt-5 center">		
            {{ $equipments->appends(Request::except('page'))->links()}}			
          </div>
          <div class="row mt-5">
            <!-- Modal -->
            <div class="modal fade" id="modal" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="post" action="{{route('equipment.store')}}" id="add-equipment">
                    @csrf
                    <input type="hidden" name="_method" id="method">
                    <div class="modal-header">
                      <h5 class="modal-title" id="commentLabel">Equipamentos</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="model">Modelo</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                      </div>

                      <div class="form-group">
                        <label for="type_id" class="col-md-4">Tipo</label>
                        <select name="type_id" id="type_id" class="form-control select2" required>
                        @foreach ($types as $type)
                          <option value="{{$type->id}}">{{$type->description}}</option>
                        @endforeach
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="serial" class="col-md-4">Número Série</label>
                        <input type="text" class="form-control" id="serial" name="serial">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

        $('.select2').select2();
        $('.btn-inverse-danger').each(function(){
          $(this).on('click', function(e){
            e.preventDefault();
            let form = $(this).parents('form');
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
        $('#modal').on('show.bs.modal', function(e){
          var modal = $(e.relatedTarget);
          var id = modal.data('id');
          var model = $(this).find('#model');
          var serial = $(this).find('#serial');
          var type = $(this).find('#type_id');
          if (modal.data('edit')){
            $('#method').attr('value', 'PUT');
            $('#add-equipment').attr('action', "{{ url('equipments')}}/" + id);
            model.val(modal.data('model'));
            serial.val(modal.data('serial'));
            type.val(modal.data('type'));
          } else {
            $('#method').attr('value', 'POST');
            $('#add-equipment').attr('action', "{{ route('equipment.store') }}");
            model.val('');
            serial.val('');
            type.val('');
          }
        })
      })
    })(jQuery);
  </script>
@stop



