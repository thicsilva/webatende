@extends('layouts.app')

@section('title', 'Welcome')

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
              <i class="mdi mdi-cube text-danger icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Total Revenue</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">$65,650</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> 65% lower growth
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
              <p class="mb-0 text-right">Orders</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">3455</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales
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
              <p class="mb-0 text-right">Sales</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">5693</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales
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
              <p class="mb-0 text-right">Employees</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">246</h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales
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
            <h3>Monday</h3>
            <p class="text-gray">
              <span class="weather-date">25 October, 2016</span>
              <span class="weather-location">London, UK</span>
            </p>
          </div>
          <div class="weather-data d-flex">
            <div class="mr-auto">
              <h4 class="display-3">21
                <span class="symbol">&deg;</span>C</h4>
              <p>
                Mostly Cloudy
              </p>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="d-flex weakly-weather">
            <div class="weakly-weather-item">
              <p class="mb-0">
                Sun
              </p>
              <i class="mdi mdi-weather-cloudy"></i>
              <p class="mb-0">
                30°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Mon
              </p>
              <i class="mdi mdi-weather-hail"></i>
              <p class="mb-0">
                31°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Tue
              </p>
              <i class="mdi mdi-weather-partlycloudy"></i>
              <p class="mb-0">
                28°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Wed
              </p>
              <i class="mdi mdi-weather-pouring"></i>
              <p class="mb-0">
                30°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Thu
              </p>
              <i class="mdi mdi-weather-pouring"></i>
              <p class="mb-0">
                29°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Fri
              </p>
              <i class="mdi mdi-weather-snowy-rainy"></i>
              <p class="mb-0">
                31°
              </p>
            </div>
            <div class="weakly-weather-item">
              <p class="mb-1">
                Sat
              </p>
              <i class="mdi mdi-weather-snowy"></i>
              <p class="mb-0">
                32°
              </p>
            </div>
          </div>
        </div>
      </div>
      <!--weather card ends-->
    </div>
    <div class="col-lg-5 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-primary mb-5">Performance History</h2>
          <div class="wrapper d-flex justify-content-between">
            <div class="side-left">
              <p class="mb-2">The best performance</p>
              <p class="display-3 mb-4 font-weight-light">+45.2%</p>
            </div>
            <div class="side-right">
              <small class="text-muted">2017</small>
            </div>
          </div>
          <div class="wrapper d-flex justify-content-between">
            <div class="side-left">
              <p class="mb-2">Worst performance</p>
              <p class="display-3 mb-5 font-weight-light">-35.3%</p>
            </div>
            <div class="side-right">
              <small class="text-muted">2015</small>
            </div>
          </div>
          <div class="wrapper">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Sales</p>
              <p class="mb-2 text-primary">88%</p>
            </div>
            <div class="progress">
              <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 88%" aria-valuenow="88"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="wrapper mt-4">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Visits</p>
              <p class="mb-2 text-success">56%</p>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 56%" aria-valuenow="56"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="row d-none d-sm-flex mb-4">
            <div class="col-4">
              <h5 class="text-primary">Unique Visitors</h5>
              <p>34657</p>
            </div>
            <div class="col-4">
              <h5 class="text-primary">Bounce Rate</h5>
              <p>45673</p>
            </div>
            <div class="col-4">
              <h5 class="text-primary">Active session</h5>
              <p>45673</p>
            </div>
          </div>
          <div class="chart-container">
            <canvas id="dashboard-area-chart" height="80"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Orders</h4>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    First name
                  </th>
                  <th>
                    Progress
                  </th>
                  <th>
                    Amount
                  </th>
                  <th>
                    Sales
                  </th>
                  <th>
                    Deadline
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="font-weight-medium">
                    1
                  </td>
                  <td>
                    Herman Beck
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $ 77.99
                  </td>
                  <td class="text-danger"> 53.64%
                    <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                    May 15, 2015
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-medium">
                    2
                  </td>
                  <td>
                    Messsy Adam
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $245.30
                  </td>
                  <td class="text-success"> 24.56%
                    <i class="mdi mdi-arrow-up"></i>
                  </td>
                  <td>
                    July 1, 2015
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-medium">
                    3
                  </td>
                  <td>
                    John Richards
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $138.00
                  </td>
                  <td class="text-danger"> 28.76%
                    <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                    Apr 12, 2015
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-medium">
                    4
                  </td>
                  <td>
                    Peter Meggik
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $ 77.99
                  </td>
                  <td class="text-danger"> 53.45%
                    <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                    May 15, 2015
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-medium">
                    5
                  </td>
                  <td>
                    Edward
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $ 160.25
                  </td>
                  <td class="text-success"> 18.32%
                    <i class="mdi mdi-arrow-up"></i>
                  </td>
                  <td>
                    May 03, 2015
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-medium">
                    6
                  </td>
                  <td>
                    Henry Tom
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    $ 150.00
                  </td>
                  <td class="text-danger"> 24.67%
                    <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                    June 16, 2015
                  </td>
                </tr>
              </tbody>
            </table>
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
          @foreach($calls as $call)
            <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
              <div class="col-md-1">
                <img class="img-sm rounded-circle mb-4 mb-md-0" src="{{ asset('storage/' . $call->fromUser->avatar) }}" alt="profile image">
              </div>
              <div class="ticket-details col-md-9">
                <div class="d-flex">
                  <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">{{ $call->fromUser->name }}</p>
                  <p class="text-primary mr-1 mb-0"><a href="{{route('call.show', $call->id) }}">#{{ $call->id }}</a></p>
                  <p class="mb-0 ellipsis">{{ $call->customer->name }}</p>
                </div>
                <p class="text-gray ellipsis mb-2">{{ $call->subject }}
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
                    <a class="dropdown-item fast-comment" href="#" data-callid="{{ $call->id }}">
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
        })
      })
    })(jQuery);
  </script>
@stop
