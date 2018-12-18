@extends('layouts.app')

@section('title', 'Agendamentos')

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
          <div class="fluid-container">
            <div class="row">
              <div class="col-md-2">
                <p class="text-gray">Criado por {{$schedule->fromUser->name }}</p>
                <img src="{{ asset('storage/' . $schedule->fromUser->avatar )}}" alt="profile image" class="img-sm rounded-circle ml-4">
              </div>
              <div class="col-md-8">
                <h4 class="card-title">{{ $schedule->description }}: {{ $schedule->customer->name }}</h4>
                <address>
                  <p>Data Inicial: <strong>{{ $schedule->initial_date->format('d/m/Y \à\s H:i')}}</strong></p>
                  <p>Data Final: <strong>{{ $schedule->final_date->format('d/m/Y \à\s H:i')}}</strong></p>
                </address>
              </div>
              <div class="col-md-2">
                @if ($schedule->to_user_id)
                  <p class="font-weight-bold">Para {{ $schedule->toUser->name }}</p>
                  <img src="{{ asset('storage/' . $schedule->toUser->avatar )}}" alt="profile image" class="img-sm rounded-circle ml-4">
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-inverse-primary mr-2">
              <i class="mdi mdi-pencil"></i>
              Alterar
            </a>
            <form action="{{ route('schedule.delete', $schedule->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button class="btn btn-inverse-danger" type="submit">
                <i class="mdi mdi-delete"></i>
                Excluir
              </button>
            </form>
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
        $('.btn-inverse-danger').click(function(e){
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
        });

      })
    })(jQuery);
  </script>
@stop



