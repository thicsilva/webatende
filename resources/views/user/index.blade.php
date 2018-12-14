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
          <div class="table-responsive">
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th>Usuário</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                <tr>
                  <td class="py-1">
                    <img src="{{ asset('images/upload/' . $user->avatar)}}" alt="user profile">
                  </td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="#" class="btn btn-icons btn-inverse-primary" title="Editar">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                    </div>
                    <div class="btn-group" role="group">
                      <form action="{{ route('user.delete', $user->id )}}" method="post" class="form-inline">
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
              text: "Após excluído, todas as chamadas originadas ou destinadas por esse usuário serão removidas e não será possível recuperar os dados. ",
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



