@extends('layouts.app')

@section('title', 'Exibir Chamada')

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
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Dados do Cliente</h4>
           <address>
            <p class="font-weight-bold">{{ $call->customer->name }}</p>
            <p>{{ $call->customer->doc_number }}</p>
            <p>{{ $call->customer->city }}</p>
            <p>{{ $call->customer->phone }}</p>
            <p>{{ $call->customer->email }}</p>
            <p class="text-gray"><i>Última atualização: {{optional($call->customer->updated_at)->diffForHumans()}} </i></p>
          </address>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            Observações
          </h4>
          <p class="text-muted"><small>Criado por: </small> {{$call->fromUser->name}}</p>
          <p>Contato: <strong>{{ $call->contact }}</strong></p>
          <p>Assunto: <strong>{{ $call->subject }}</strong></p>
          <ul>
            <li class="font-weight-semibold {{ $call->customer->has_contract?'text-success':'text-danger'}}">Cliente {{ $call->customer->has_contract?'possui contrato':'não possui contrato'}}</li>
            <li class="font-weight-semibold {{ $call->customer->has_restriction?'text-danger':'text-success'}}">Cliente {{ $call->customer->has_restriction?'possui restrições':'não possui restrições'}}</li>
            @if($call->customer->has_restriction)
            <li class="font-weight-semibold">{{ $call->customer->restriction_annotation }}</li>
            @endif
          </ul>
          @if($call->status)
            <p>Chamada <mark class="bg-danger text-white">Encerrada</mark></p>
          @else
            <p>Chamada <mark class="bg-success text-white">Aberta</mark></p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Orçamento</h4>
          @if(!$call->status && $call->toUser->id == auth()->user()->id)
            @if($call->budgets->count()>0)
            <a href="{{ route('budget.edit', $call->budgets->first()->id) }}" class="btn btn-info">Editar orçamento</a>
            @else
            <a href="{{ route('budget.create', $call->id) }}" class="btn btn-info">Inserir orçamento</a>
            @endif
          @else
            @if($call->budgets->count()>0)
            <a href="{{ route('budget.show', $call->budgets->first()->id) }}" class="btn btn-info">Visualizar</a>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="fluid-container">
            @foreach($call->comments as $comment)
            <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">

              <div class="col-md-1">
                <img src="{{ asset('uploads/users/' . $comment->user->avatar )}}" alt="profile image" class="img-sm rounded-circle mb-4 mb-md-0">
              </div>
              <div class="ticket-details col-md-9">
                <div class="d-flex">
                  <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">{{ $comment->user->name}}</p>
                </div>
                <p class="text-gray mb-2">
                  {{ $comment->comment }}
                </p>
                <div class="row text-gray d-md-flex d-none">
                  <div class="col-4 d-flex">
                    <small class="mb-0 mr-2 text-muted">
                      {{ $comment->created_at->diffForHumans() }}
                    </small>
                  </div>
                </div>
              </div>

              <div class="ticket-details col-md-2">
                <div class="btn-group">
                  @if (auth()->user()->id==$comment->user_id && !$call->status)
                  <form action="{{ route('comment.delete', $comment->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-inverse-danger" type="submit">
                      <i class="mdi mdi-delete">
                      </i>
                      Excluir
                    </button>
                  </form>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @if(!$call->status)
          <form action="{{ route('call.close', $call->id) }}" method="post" id="close-call" class="forms-sample" style="display:none">
          @csrf
          </form>
          <form action="{{ route('comment.store', $call->id)}}" method="post" class="forms-sample">
            @csrf
            <div class="form-group">
              <label for="comment">Comentário</label>
              <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="d-flex flex-row-reverse">
              <button class="btn btn-success">
                <i class="mdi mdi-message-reply-text"></i>
                Comentar
              </button>
              @if($call->comments->count()>0)
              <a href="#" class="mr-2 btn btn-inverse-dark" onclick="event.preventDefault(); document.getElementById('close-call').submit();"><i class="mdi mdi-close-outline"></i> Encerrar</a>
              @endif
            </div>
          </form>
          @endif
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
