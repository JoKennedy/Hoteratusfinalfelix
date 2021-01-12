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

  <!-- Include core + vendor Styles -->
  @include('panels.styles')

</head>
<!-- END: Head-->

<body   class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif"
  data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
    <style>
        .row3 {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px
        }

        .h-100 {
            height: 100% !important
        }

        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(206, 226, 187, 0.9);
            color: #000;
            z-index: 9999
        }

        .loader .loader-ripple {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px
        }

        .loader .loader-ripple div {
            position: absolute;
            border: 4px solid #000;
            opacity: 1;
            border-radius: 50%;
            animation: loader-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite
        }

        .loader .loader-ripple div:nth-child(2) {
            animation-delay: -0.5s
        }

        @keyframes loader-ripple {
            0% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 1
            }
            100% {
                top: -1px;
                left: -1px;
                width: 58px;
                height: 58px;
                opacity: 0
            }
        }

        .container-fluid {
            max-width: 100%
        }

        .container-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }

        .col-auto {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px
        }

        .col-auto {
            flex: 0 0 auto;
            width: 100%;
            max-width: 100%
        }

        .align-self-center {
            align-self: center !important
        }

        .text-center {
            text-align: center !important
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto !important;
        }
    </style>


    <div class="loader container-fluid">
        <div class="row3 h-100">
            <div class="col-auto align-self-center  mx-auto text-center">
                <div class="loader-ripple">
                    <div></div>
                    <div></div>
                </div>
                <h2>Lifestyle</h2>
                <p>Hoteratus</p>
            </div>
        </div>
    </div>

  <div class="row">
    <div class="col s12">
      <div class="container">
             @if(Session::has('message_success'))
        <div class="row" >
            <div class="card-alert card gradient-45deg-green-teal">
                <div class="card-content white-text">
                    <p>
                    <i class="material-icons">check</i> {{Session::get('message_success') }}.
                    </p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    @endif
    @if(Session::has('message_warning'))
        <div class="row" >
            <div class="card-alert card gradient-45deg-green-teal">
                <div class="card-content white-text">
                    <p>
                    <i class="material-icons">check</i> {{Session::get('message_warning') }}.
                    </p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    @endif
        <!--  main content -->
        @yield('content')
      </div>
      {{-- overlay --}}
      <div class="content-overlay"></div>
    </div>
  </div>
  {{-- vendor scripts and page scripts included --}}
  @include('panels.scripts')

</body>

</html>
