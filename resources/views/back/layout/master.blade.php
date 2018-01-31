<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

   <title>Equiteasy Admin | @yield('title')</title>

   <link rel="stylesheet" href="{{ asset('/css/back/vendor.css') }}" />
   <link rel="stylesheet" href="{{ asset('/css/back/main.css') }}" />
</head>

<body>
   <div id="sidebar">
      @include('back.layout.sidebar')
   </div>

   <div id="view">
      <div class="container">
         @yield('content')
      </div>

      <div class="clearfix"></div>
   </div>

   @if( session()->has('flash_notification.message') )
      <div class="popup-container">
         <div class="popup">
            <span class="icon-close"></span>

            <p>{!! session('flash_notification.message') !!}</p>
         </div>
      </div>
   @endif

   <div id="loading">
      <img src="{{ asset('img/loading.gif') }}" width="50" height="50" alt="Chargement" />
   </div>

   <script type="text/javascript" src="{{ asset('/js/back/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/back/app.js') }}"></script>

   @yield('js')

   @if (session()->has('flash_notification.message'))
      <script type="text/javascript">
      $(function() {
         openPopup( $('.popup-container') );
      });
      </script>
   @endif
</body>
</html>
