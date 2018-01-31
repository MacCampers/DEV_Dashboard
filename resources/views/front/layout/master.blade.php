<!doctype html>
<html>
<head>
   @include('front.layout.meta')

   <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
   <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">

   <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
   <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

   <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
   @include('front.layout.header')

   @if( session('popup') )
      <div id="session-popup" class="popup-container">
         <div class="popup">
            <span class="close icon-cross"></span>
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

   @if( !Auth::check() )
      @include('front.auth.login.popup')
   @endif

   <script type="text/javascript" src="{{ asset('/js/front/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/app.js') }}"></script>

   @yield('js')

   @if( session('popup') )
      <script type="text/javascript">openPopup($('#session-popup'));</script>
   @endif
</body>
</html>
