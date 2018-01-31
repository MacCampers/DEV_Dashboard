<!doctype html>
<html>
<head>
    @include('front.layout.meta')

    <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>


<body class="dashboard">
   @include('front.layout.dashboard_header')

   @if( session('popup') )
      <div id="session-popup" class="popup-container">
         <div class="popup">
            <p>{!! session('popup') !!}</p>
         </div>
      </div>
   @endif

   <div id="main-wrapper">
      <div id="main" class="@yield('main_class')">
         @yield('content')
      </div>

      @include('front.layout.footer')
   </div>

   <script type="text/javascript" src="{{ asset('/js/front/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/app.js') }}"></script>

   @yield('js')

   @if( session('popup') )
      <script type="text/javascript">openPopup($('#session-popup'));</script>
   @endif

   {{-- HubSpot --}}
   <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/3863982.js"></script>
</body>
</html>
