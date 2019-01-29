@extends('layouts.app')

@section('title', 'Situações')
@section('css')

@stop
@section('content')
<!-- content-wrapper -->
<div class="content-wrapper">
  <div class="add-button">
    <button class="main" data-toggle="modal" data-target="#add">
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
                  <th>Descrição</th>
                  <th>Cor</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
              @foreach($situations as $situation)
                <tr>
                  <td>{{ $situation->description }}</td>
                  <td bgcolor="{{ $situation->color }}"></td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="#" data-toggle="modal" data-target="#edit" data-id="{{$situation->id}}" data-description="{{$situation->description}}" data-color="{{$situation->color}}" class="btn btn-icons btn-inverse-primary" title="Editar">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </div>
                    <div class="btn-group" role="group">
                      <form action="{{ route('situation.delete', $situation->id )}}" method="post" class="form-inline">
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
            <!-- Modal -->
            <div class="modal fade" id="add" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="post" action="{{route('situation.store')}}">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="commentLabel">Situações</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="description">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description">
                      </div>
                      <div class="form-group">
                        <label for="color">Cor</label>
                        <input type="color" class="form-control" id="color" name="color">
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
            <!-- Modal -->
            <div class="modal fade" id="edit" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form method="post" action="#" id="edit-type">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                      <h5 class="modal-title" id="commentLabel">Situações</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="description">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="color">Cor</label>
                        <input type="color" class="form-control" id="color" name="color">
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
        $('#edit').on('show.bs.modal', function(e){
          var modal = $(e.relatedTarget);
          var id = modal.data('id');
          var description = $(this).find('#description');
          var color = $(this).find('#color');
          $('#edit-type').attr('action', "{{ url('situations')}}/" + id);
          description.val(modal.data('description'));
          color.val(modal.data('color'));
        })
      })
    })(jQuery);
  </script>
@stop



