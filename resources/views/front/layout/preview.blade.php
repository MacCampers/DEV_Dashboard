<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

   <title>BenoitTabry | @yield('title')</title>

   <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
   <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">
</head>

<body class="dashboard">
   <div id="main-wrapper">
      <div id="main" class="preview">
         @yield('content')
      </div>
   </div>

   <script type="text/javascript" src="{{ asset('/js/front/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/app.js') }}"></script>
</body>
</html>
