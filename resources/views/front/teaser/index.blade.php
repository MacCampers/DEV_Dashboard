<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   <meta name="csrf-token" content="{{ csrf_token() }}" />

   <meta name="description" content="@yield('description', trans('common.meta_description'))" />

   <title>Equiteasy | @lang('teaser.title')</title>

   <link rel="stylesheet" href="{{ asset('css/front/vendor.css') }}">
   <link rel="stylesheet" href="{{ asset('css/front/main.css') }}">

   <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
   <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>

<body>
   <div id="main-wrapper">
      <div id="main" class="blue-pattern">
         <div class="container">
            <div class="col-12">
               <div id="project-teaser">
                  <div class="logo">
                     <a href="{{ route('home') }}" target="_blank"><img src="{{ asset('img/logo_v_white.png') }}" height="90" alt="Equiteasy" /></a>
                  </div>

                  <div class="flex">
                     <div class="left-panel">
                        <div class="content">
                           <div>
                              <h3>@lang('teaser.teaser_title')</h3>
                              <p>{!! nl2br($teaser) !!}</p>
                           </div>

                           <div class="align-center">
                              @if( $match->accepted)
                                 <a href="{{ route('match_overview', ['id' => $match->id]) }}" class="button blue">@lang('buttons.view_project')</a>
                              @else
                                 @if( $projectPast )
                                    <div class="button disabled" disabled>@lang('buttons.end_project')</div>
                                 @else
                                    <div id="accept-button" class="button blue">@lang('buttons.accept_project')</div>
                                    <div id="decline-button">
                                       <a href="#">@lang('buttons.decline_project')</a>
                                    </div>
                                 @endif
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="right-panel">
                        <div class="slider">
                           <div class="slide">
                              <h3>@lang('teaser.text.title')</h3>
                              @lang('teaser.text.content')
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      @if( $user )
         @if( !$user->password )
            @include('front.teaser.popups.password')
         @else
            @include('front.teaser.popups.login')
         @endif
      @endif
      @include('front.teaser.popups.decline')
   </div>

   <script type="text/javascript">
   var swalTitle = "@lang('popups.teaser_decline.title')";
   var swalText = "@lang('popups.teaser_decline.text')";
   var swalConfirmButton = "@lang('common.yes')";
   var swalCancelButton = "@lang('common.no')";
   </script>

   <script type="text/javascript" src="{{ asset('/js/front/vendor.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/app.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/teaser.js') }}"></script>

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
