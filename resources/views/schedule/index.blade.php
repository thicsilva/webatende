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
              <a href="{{ route('schedule.create') }}" class="btn btn-primary btn-block">Novo Agendamento
                <i class="mdi mdi-plus"></i>
              </a>
              <div class="wrapper mt-4">
              @foreach($schedules as $schedule)
                <div class="item-wrapper d-flex pb-2 mt-2 border-bottom">
                  <div class="status-wrapper d-flex align-items-start pr-3">
                    <span class="bg-success rounded-circle p-1 mt-2 mx-auto"></span>
                  </div>
                  <div class="text-wrapper">
                    <h6>{{ $schedule->description }}: {{ $schedule->customer->name }}</h6>
                    <small class="d-block mb-2"><strong>{{ $schedule->initial_date->format('d/m/Y, H:i') }}</strong></small>
                    <small class="text-gray d-block">{{$schedule->final_date->format('d/m/Y, H:i')>date('d/m/Y, H:i')?'Encerra':'Encerrado'}} {{ $schedule->final_date->diffForHumans() }}</small>
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
          firstDay: 0,
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
          },
          navLinks: true,
          eventLimit: true,
          events: function(start,end,timezone,callback){
            $.ajax({
              url: "{{ route('schedule.json') }}",
              dataType: 'json',
              success: function(doc){
                var events = [];
                $(doc).each(function(){
                  events.push({
                    title: $(this).attr('description'),
                    start: $(this).attr('initial_date'),
                    end: $(this).attr('final_date'),
                    url: "{{ url('/schedule/show') }}/" + $(this).attr('id'),
                    user: $(this).attr('to_user_id'),
                    color: getRandomColor(),
                  });
                });
                callback(events);
              },
            })
          },
        });

        function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '#';
          for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        };
      })
    })(jQuery);
  </script>
@stop



