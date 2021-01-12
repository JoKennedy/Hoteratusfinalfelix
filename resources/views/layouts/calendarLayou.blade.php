{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading"
    lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
    data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{env('APP_DISPLAY_NAME')}}</title>
    <link rel="apple-touch-icon" href="{{asset('images/favicon/logo2.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/logo2.png')}}">
    <link href="{{asset('vendors/CalendarJnS/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Include core + vendor Styles -->
 
</head>
<body>
    <header class="page-topbar" id="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
            <ul class="navbar-brand">
                <li>
                  <h2 class="logo-wrapper">
                    <a class="brand-logo darken-1" href="{{asset('/')}}">
                      @if(!empty ($configData['templateTitle']))
                      <img src="{{asset($configData['smallScreenLogo'])}}" alt="logo">
                      <span class="logo-text hide-on-med-and-down" >
                        @else
                        {{env('APP_NAME')}}
                        @endif
                      </span>
                    </a>
                  </h2>
                </li>
              </ul>

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse" id="navbarToggle">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" href="{{asset("calendar")}}"><i class="fas fa-desktop"></i> Frontdesk</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{asset("calendar/housekeeping")}}">Housekeeping</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link list-item-collapse" href="#" id="navbarDropdownOthers" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Others
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownOthers">
                      <a class="dropdown-item" href="{{asset("restaurant")}}"><i class="fas fa-utensils"></i> Restaurant</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-glass-cheers"></i> Bar</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-route"></i> Travel Desk</a>
                    </div>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">Report</a>
                  </li>
                  <li class="nav-item dropdown user-log">
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-user-alt"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="#"><i class="fas fa-sort-numeric-up"></i> Close Counter</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-terminal"></i> Admin Console</a>
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="fas fa-sign-out-alt"></i> Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </div>
                  </li>
                </ul>
          </nav>
      </header>
    <div class="main">
            <div class="col-md-12">
             <div class="row">
                <!--  main content -->
                @yield('content')
             </div>
        </div>
    </div>
    <div class="row loading-status hide">
      <div class="col">
          <div class="d-flex justify-content-center">
              <div role="status" class="spinner-border">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
          <div class="col-12">
              <p>Updating...</p>
              <span>Wait a moment, updating your information.</span>
          </div>
      </div>
  </div>
  <div id="content-alert"></div>
</body>

{{-- scripts --}}

<script>
  var csrf_token = "{{ csrf_token() }}";
</script>
<script src="{{asset('vendors/CalendarJnS/js/jquery.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/lib/popper.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/lib/query-ui.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/lib/jquery.poink.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/validation.calendar.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/app-calendar.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/miniCalendar.js')}}"></script>
<script src="{{asset('vendors/CalendarJns/js/scripts.js')}}"></script>

<script src="{{asset('vendors/CalendarJnS/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/datatables-demo.js')}}"></script>
<script src="{{asset('vendors/CalendarJnS/js/draggable.js')}}"></script>
<script src="{{asset('vendors/lib/jquery/jquery-migrate.min.js')}}"></script>
<script>
    $(document).ready(function(){
        let path = window.location.pathname
        let item = $(`header .nav-item a[href$='${path}']`).closest("li").addClass("active");
    });
</script> 
</html>