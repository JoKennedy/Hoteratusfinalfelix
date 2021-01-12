<aside
  class="{{$configData['sidenavMain']}} @if(!empty($configData['activeMenuType'])) {{$configData['activeMenuType']}} @else {{$configData['activeMenuTypeClass']}}@endif @if(($configData['isMenuDark']) === true) {{'sidenav-dark'}} @elseif(($configData['isMenuDark']) === false){{'sidenav-light'}}  @else {{$configData['sidenavMainColor']}}@endif">
  <div class="brand-sidebar gradient-45deg-green-teal">
    <h1 class="logo-wrapper">
      <a class="brand-logo darken-1" href="{{asset('/')}}">
        @if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
          @if($configData['mainLayoutType']=== 'vertical-modern-menu')
          <img class="hide-on-med-and-down" style="height: 120px" src="{{asset($configData['largeScreenLogo'])}}" alt="materialize logo" />
          <img class="show-on-medium-and-down hide-on-med-and-up" style="height: 120px" src="{{asset($configData['smallScreenLogo'])}}"
            alt="materialize logo" />

          @elseif($configData['mainLayoutType'] === 'vertical-menu-nav-dark')
          <img src="{{asset($configData['smallScreenLogo'])}}" alt="materialize logo" />

          @elseif($configData['mainLayoutType']=== 'vertical-gradient-menu')
          <img class="show-on-medium-and-down hide-on-med-and-up" src="{{asset($configData['largeScreenLogo'])}}"
            alt="materialize logo" />
          <img class="hide-on-med-and-down" src="{{asset($configData['smallScreenLogo'])}}" alt="materialize logo" />

          @elseif($configData['mainLayoutType']=== 'vertical-dark-menu')
          <img class="show-on-medium-and-down hide-on-med-and-up" src="{{asset($configData['largeScreenLogo'])}}"
            alt="materialize logo" />
          <img class="hide-on-med-and-down" src="{{asset($configData['smallScreenLogo'])}}" alt="materialize logo" />
          @endif
        @endif

        <span class="logo-text hide-on-med-and-down">
          @if(!empty ($configData['templateTitle']) && isset($configData['templateTitle']))
          {{$configData['templateTitle']}}
          @else
          Materialize
          @endif
        </span>
      </a>
      <a class="navbar-toggler" href="javascript:void(0)"><i class="material-icons">radio_button_checked</i></a></h1>
  </div>
  <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out"
    data-menu="menu-navigation" data-collapsible="menu-accordion" style="margin-bottom: 200px;">
    {{-- Foreach menu item starts --}}
    @php
        $user= Auth::user();
        $level3 =0;
        $level4 =0;

       

        $menus = session()->get('menu');


    @endphp

    @if(!empty($menus) && isset($menus))

      @foreach ($menus as $menu)

        @if($menu->order2 == 0)
            @php
                if ($level3 !=0)
                {
                    $level3 = 0;
                    echo '</li>';
                }
                if ($level4 !=0)
                {
                    $level4 = 0;
                    echo '</ul></div>';
                }

            @endphp
            <li class="navigation-header">
            <a class="navigation-header-text" href="{{ session()->get('hotel_name') }}"></a>
            <i class="navigation-header-icon material-icons">{{$menu->icon }}</i>
            </li>
        @elseif($menu->order3 == 0)
            @php
                if ($level3 !=0)
                {
                    $level3 = 0;
                    echo '</li>';
                }
                if ($level4 !=0)
                {
                    $level4 = 0;
                    echo '</ul></div>';
                }
            $custom_classes="";
            if($menu->class != "")
            {
                $custom_classes = $menu->class;
            }
            @endphp


      <li class="bold {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
        <a class="{{$custom_classes}} {{ (request()->is($menu->url.'*')) ? 'active '.$configData['activeMenuColor'] : ''}}"
          @if(!empty($configData['activeMenuColor'])) {{'style=background:none;box-shadow:none;'}} @endif
          href="@if(($menu->url)==='javascript:void(0)'){{$menu->url}} @else{{url($menu->url)}} @endif"
          {{isset($menu->newTab) ? 'target="_blank"':''}}>
          <i class="material-icons">{{$menu->icon}}</i>
          <span class="menu-title">{{ __('locale.'.$menu->name)}}</span>
          @if(isset($menu->tag))
          <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
          @endif
        </a>

         @elseif($menu->order4 == 0)
            @php
             $custom_classes="";
            @endphp
            @if ($level4 == 0)
                <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @php
                    $level4 = 1;
                    if($menu->class !="")
                    {
                        $custom_classes = $menu->class;
                    }
                    @endphp

            @endif

                <li class=" {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
                <a href="@if(($menu->url) === 'javascript:void(0)')
                        {{$menu->url}}
                    @else
                        @if ($menu->url == 'hotel-information')
                            {{'/hotel-manager'}}
                            @if($user->last_hotel_id){{''}}@endif
                        @else
                            {{url($menu->url)}}
                        @endif
                    @endif"
                    class="{{$custom_classes}} {{(request()->is($menu->url.'*')) ? 'active '.$configData['activeMenuColor'] : '' }}"
                    @if(!empty($configData['activeMenuColor'])) {{'style=background:none;box-shadow:none;'}} @endif
                    {{isset($menu->newTab) ? 'target="_blank"':''}}>
                    <i class="material-icons">radio_button_unchecked</i>
                    <span>{{ __('locale.'.$menu->name)}}</span>
                </a>
                </li>


        @endif
      @endforeach
      @php

              if ($level4 !=0)
            {
                $level4 = 0;
                echo '</ul></div>';
            }
              if ($level3 !=0)
            {
                $level3 = 0;
                echo '</li>';
            }
      @endphp
    @endif
    {!! $MyNavBar->asUl() !!}
    <li class="navigation-header">
        <a class="navigation-header-text"></a>
        <i class="navigation-header-icon material-icons"></i>
      </li>
      <li class="navigation-header">
        <a class="navigation-header-text"></a>
        <i class="navigation-header-icon material-icons"></i>
      </li>
  </ul>
  <div class="navigation-background"></div>
  <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only"
    href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
