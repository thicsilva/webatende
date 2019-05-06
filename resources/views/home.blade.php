@extends('layouts.app')

@section('title', 'Bem Vindo')

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
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-phone-classic text-danger icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Chamadas do Mês</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{$callsMonth}}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> {{ number_format(abs($compareMonth)) }}% {{$compareMonth<0?'menos':'mais'}} que {{ utf8_encode(ucfirst($lastMonth)) }}
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-poll-box text-success icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Agendamentos</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{$schedules}}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Neste mês
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-receipt text-warning icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Chamadas</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{$callsForYou}}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Chamadas para você
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-account-location text-info icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Clientes</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">{{$customers}}</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Clientes cadastrados
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-7 grid-margin stretch-card">
      <!--weather card-->
      <div class="card card-weather">
        <div class="card-body">
          <div class="weather-date-location">
            <h3>{{ ucfirst(strftime('%A'))}}</h3>

            <p class="text-gray">
              <span class="weather-date">{{ utf8_encode(strftime('%d de %B, %Y')) }}</span>
              <span class="weather-location"> - {{$weather->city->name}}</span>
            </p>
          </div>
          <div class="weather-data d-flex">
            <div class="mr-auto">
              <h4 class="display-3">{{number_format($weather->list[0]->temp->day)}}
                <span class="symbol">&deg;</span>C</h4>
              <p>
                {{ ucfirst($weather->list[0]->weather[0]->description) }}
              </p>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="d-flex weakly-weather">
          @for($i=1; $i<8; $i++)
              <div class="weakly-weather-item">
              <p class="mb-0">
                {{ utf8_encode(\Carbon\Carbon::now()->addDay($i)->formatLocalized('%a')) }}
              </p>
              <img src="http://openweathermap.org/img/w/{{$weather->list[$i]->weather[0]->icon}}.png" alt="{{ $weather->list[$i]->weather[0]->description }}" title="{{ $weather->list[$i]->weather[0]->description }}">
              <p class="mb-0">
              {{number_format($weather->list[$i]->temp->day)}}&deg;
              </p>
            </div>
          @endfor
          </div>
        </div>
      </div>
      <!--weather card ends-->
    </div>
    <div class="col-lg-5 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-primary mb-5">Histórico do Mês</h2>
          <div class="wrapper d-flex justify-content-between">
            <canvas id="chart"></canvas>
          </div>
          <div class="wrapper">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Seus Atendimentos</p>
              @if($callsMonth>0)
              <p class="mb-2 text-primary">{{ number_format(($callsForYou * 100) / $callsMonth)}}%</p>
              @else
              <p class="mb-2 text-primary">0%</p>
              @endif
            </div>
            <div class="progress">
              @if($callsMonth>0)
              <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ number_format(($callsForYou * 100) / $callsMonth)}}%" aria-valuenow="{{ number_format(($callsForYou * 100) / $callsMonth)}}"
                aria-valuemin="0" aria-valuemax="100"></div>
              @else
              <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$callsMonth}}%" aria-valuenow="{{ $callsMonth}}"
                aria-valuemin="0" aria-valuemax="100"></div>
              @endif
            </div>
          </div>
          <div class="wrapper mt-4">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Seus Agendamentos</p>
              @if ($schedules>0)
              <p class="mb-2 text-success">{{ number_format(($schedulesForYou * 100) / $schedules)}}%</p>
              @else
              <p class="mb-2 text-success">{{ $schedules }}%</p>
              @endif
            </div>
            <div class="progress">
            @if ($schedules>0)
              <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ number_format(($schedulesForYou * 100) / $schedules)}}%" aria-valuenow="{{ number_format(($schedulesForYou * 100) / $schedules)}}"
                aria-valuemin="0" aria-valuemax="100"></div>
            @else
            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $schedules}}%" aria-valuenow="{{ $schedules}}"
                aria-valuemin="0" aria-valuemax="100"></div>
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if($calls->count()>0)
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4">Gerenciar Chamadas</h5>
          <div class="fluid-container">
            <!-- Modal -->
            <div class="modal fade" id="show-comment" role="dialog" aria-labelledby="commentLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form id="comment">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="commentLabel">Comentário</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="comment">Comentário</label>
                        <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Comentar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @foreach($calls as $call)
            <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
              <div class="col-md-1">
                <img class="img-sm rounded-circle mb-4 mb-md-0" src="{{ asset('uploads/users/' . $call->fromUser->avatar) }}" alt="profile image">
              </div>
              <div class="ticket-details col-md-9">
                <div class="d-flex">
                  <p class="text-gray font-weight-semibold mr-2 mb-0 no-wrap">{{ $call->fromUser->name }}</p>
                  <p class="text-primary mr-1 mb-0"><a href="{{route('call.show', $call->id) }}">#{{ $call->id }}</a></p>
                  <p class="mb-0">{{ $call->customer->name }}</p>
                </div>
                <p class="text-gray mb-2">{{ $call->subject }}
                </p>
                <div class="row text-gray d-md-flex d-none">
                  <div class="col-4 d-flex">
                    <small class="mb-0 mr-2 text-muted text-muted">Criado :</small>
                    <small class="Last-responded mr-2 mb-0 text-muted text-muted">{{ $call->created_at->diffForHumans() }}</small>
                  </div>
                  @if($call->comments->count()>0)
                  <div class="col-4 d-flex">
                    <small class="mb-0 mr-2 text-muted text-muted">Último comentário :</small>
                    <small class="Last-responded mr-2 mb-0 text-muted text-muted">{{$call->comments->last()->created_at->diffForHumans() }}</small>
                  </div>
                  @endif
                </div>
              </div>
              <div class="ticket-actions col-md-2">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gerenciar
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item fast-comment" href="#show-comment" data-toggle="modal" data-target="#show-comment" data-callid="{{ $call->id }}">
                      <i class="fa fa-reply fa-fw"></i>Comentar</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item fast-close" href="#" data-callid="{{ $call->id }}">
                      <i class="fa fa-times text-danger fa-fw"></i>Encerrar</a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </div>

        </div>
      </div>
    </div>
  </div>
  @endif
</div>
<!-- content-wrapper ends -->

@stop

@section('js')
  <script>
    (function($){
      'use strict';
      $(function(){

        getLocation();
        /* function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          }
        } */

        function getLocation() {
          if (location.protocol != 'https:') {
            if (window.chrome) {
              var position = {
                coords: {
                  latitude: '',
                  longitude: '',
                }
              };

              $.getJSON('http://ip-api.com/json', function(data, status){
                if (status==='success') {
                  if (data) {
                    position.coords.latitude = data.lat;
                    position.coords.longitude = data.lon;
                    setCookie('lat', data.lat, 30);
                    setCookie('long', data.lon, 30);
                    showPosition(position);
                  } else {
                    locationOnError();
                  }
                } else {
                  locationOnError();
                }
              });
            } else {
              navigator.geolocation.getCurrentPosition(showPosition);
            }
          } else {
            navigator.geolocation.getCurrentPosition(showPosition);
          }
        }
        function showPosition(position) {
          var latitude  = position.coords.latitude;
          var longitude = position.coords.longitude;
          setCookie('lat', latitude, 30);
          setCookie('long', longitude, 30);
        }

        //define a function to set cookies
        function setCookie(name,value,days) {
          var expires = "";
          if (days) {
              var date = new Date();
              date.setTime(date.getTime() + (days*24*60*60*1000));
              expires = "; expires=" + date.toUTCString();
          }
          document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        $.get("{{route('home.chart')}}", function(response){
          var names = new Array();
          var cvalues = new Array();
          response.forEach(function(data){
            names.push(data.name);
            cvalues.push(data.total);
          });
          var chartCanvas = $("#chart").get(0).getContext("2d");
          var doughnutChart = new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
              datasets: [{
                data: cvalues,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.5)',
                  'rgba(54, 162, 235, 0.5)',
                  'rgba(255, 206, 86, 0.5)',
                  'rgba(75, 192, 192, 0.5)',
                  'rgba(153, 102, 255, 0.5)',
                  'rgba(255, 159, 64, 0.5)',
                  'rgba(1, 255, 112, 0.5)',
                  'rgba(0, 31, 63, 0.5)',
                  'rgba(133, 20, 75, 0.5)',
                ],
                borderColor: [
                  'rgba(255,99,132,1)', //rosa
                  'rgba(54, 162, 235, 1)',//azul
                  'rgba(255, 206, 86, 1)',//amarelo
                  'rgba(75, 192, 192, 1)',//verde agua
                  'rgba(153, 102, 255, 1)',//lilas
                  'rgba(255, 159, 64, 1)',//laranja
                  'rgba(1, 255, 112, 1)', //lime
                  'rgba(0, 31, 63, 1)', //navy
                  'rgba(133, 20, 75, 1)', //maroon
                ],
              }],
              labels: names,
            },
            options: {
              responsive: true,
              animation: {
                animateScale: true,
                animateRotate: true
              }
            }
          });

        });

        $('.fast-close').each(function(){
          $(this).on('click', function(e){
            var callid = $(this)[0].dataset.callid;
            $.ajax({
              url: "{{ url('/call/close') }}/" + callid,
              type: 'POST',
              data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: $(this)[0].dataset.callid,
              },
              success: function(data){
                location.reload();
              }
            });
          });
        });
        $('#show-comment').on('show.bs.modal', function(e){
          var modal = $(e.relatedTarget);
          var id = modal.data('callid');
          $('#comment').attr('data-call', id);
        })
        $('#comment').on('submit', function(e){
          var form = $('#comment');
          var data = form.serialize();
          var id=$(this).data('call');
          $.ajax({
            'method': 'POST',
            'url': "{{ url('/call/comment/')}}/" + id,
            'data': data,
            'success': function(response){
              location.reload();
            }
          })
        })
      })
    })(jQuery);
  </script>
@stop
