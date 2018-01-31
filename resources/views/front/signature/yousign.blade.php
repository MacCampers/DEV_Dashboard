<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

   <meta name="description" content="@yield('description', trans('common.meta_description'))" />

   <title>Equiteasy | @lang('signature.title')</title>

   <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
   <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">

   <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
   <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>

<body>
   <div id="main-wrapper">
      <div id="main" class="blue-pattern signature">
         <div class="container">
            <div class="col-12">
               <div id="document-signature">
                  <div class="logo">
                     <a href="{{ route('home') }}" target="_blank"><img src="{{ asset('img/logo_v_white.png') }}" height="60" alt="Equiteasy" /></a>
                  </div>

                  <iframe src="{{ $iframeUrl }}"></iframe>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script type="text/javascript" src="{{ asset('/js/front/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/app.js') }}"></script>

   {{-- HubSpot --}}
   <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/3863982.js"></script>
</body>
</html>
