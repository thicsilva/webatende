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
          <div class="row">
            <div class="col-md-4">
              <a href="{{ route('schedule.create') }}" class="btn btn-primary btn-block">Adicionar Evento
                <i class="mdi mdi-plus"></i>
              </a>
              <div class="wrapper mt-4">
              @foreach($schedules as $schedule)
                <div class="item-wrapper d-flex pb-4 border-bottom">
                  <div class="status-wrapper d-flex align-items-start pr-3">
                    <span class="bg-warning rounded-circle p-1 mt-2 mx-auto"></span>
                  </div>
                  <div class="text-wrapper">
                    <h6>{{ $schedule->description }}</h6>
                    <small class="d-block mb-2"><strong>{{ $schedule->initial_date->format('d/m/Y, H:i') }}</strong></small>
                    <small class="text-gray d-block">{{ $schedule->customer->name }}</small>
                  </div>
                </div>
              @endforeach
              </div>
            </div>
            <div class="col-md-8">
              <div id="calendar">
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
        $('#calendar').fullCalendar({
          locale: 'pt',
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
          },
          events: function(start,end,timezone,callback){
            $.ajax({
              url: "{{ route('schedule.json') }}",
              dataType: 'json',
              data: {
                start: start.unix(),
                end: end.unix(),
              },
              success: function(doc){
                console.log(doc);
                var events = [];
                $(doc).each(function(){
                  events.push({
                    title: $(this).attr('description'),
                    start: $(this).attr('initial_date'),
                    end: $(this).attr('final_date'),
                  });
                });
                callback(events);
              }
            })
          }
        });
      })
    })(jQuery);
  </script>
@stop



