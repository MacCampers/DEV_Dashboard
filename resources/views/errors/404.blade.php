<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="@lang('common.meta_description')" />

    <title>Equiteasy | @lang('errors.page_404.title')</title>

    <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>

<body>
   @include('front.layout.header')

   <div id="main-wrapper">
      <div id="main" class="blue-pattern">
         <div id="error-page">
            <h1>@lang('errors.page_404.title')</h1>
            <p>@lang('errors.page_404.text')</p>

            <a href="{{ route('home') }}" class="button red">@lang('errors.page_404.button')</a>
         </div>
      </div>

      @include('front.layout.footer')
   </div>

   {{-- HubSpot --}}
   <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/3863982.js"></script>

   {{-- Google Analytics --}}
   <script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

   ga('create', 'UA-105661503-1', 'auto');
   ga('send', 'pageview');
   </script>
</body>
</html>
