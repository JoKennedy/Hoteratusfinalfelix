<body
  class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass']) && isset($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif"
  data-open="click" data-menu="horizontal-menu" data-col="2-columns">
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
  <!-- BEGIN: Header-->
  <header class="page-topbar" id="header">
    @include('panels.horizontalNavbar')
  </header>
  <!-- BEGIN: SideNav-->
  @include('panels.sidebar')
  <!-- END: SideNav-->

  <!-- BEGIN: Page Main-->
  <div id="main">
    <div class="row">
      @if($configData["navbarLarge"] === true && isset($configData["navbarLarge"]))
      {{-- navabar large  --}}
      <div class="content-wrapper-before {{$configData["navbarLargeColor"]}}"></div>
      @endif

      @if ($configData["pageHeader"] === true && isset($breadcrumbs))
        {{-- breadcrumb --}}
        @include('panels.breadcrumb')
      @endif
      <div class="col s12">
        <div class="container">
          {{-- main page content  --}}
          @yield('content')
          {{-- right sidebar  --}}
          @include('layouts.sidebar.right-sidebar')

          @if($configData["isFabButton"] === true)
            @include('layouts.sidebar.fab-menu')
          @endif
        </div>
        {{-- overlay --}}
        <div class="content-overlay"></div>
      </div>
    </div>
  </div>

  <!-- END: Page Main-->


  @if($configData['isCustomizer'] === true && isset($configData['isCustomizer']))
    <!-- Theme Customizer -->
    @include('layouts.partials.customizer')
    <!--/ Theme Customizer -->
    {{-- buy now button section --}}
    @include('layouts.partials.buy-now')
  @endif



  {{-- main footer  --}}
  @include('panels.footer')

  {{-- vendors and page scripts file   --}}
  @include('panels.scripts')
</body>
