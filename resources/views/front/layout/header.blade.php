<header>
   <div class="container row">
      <div class="col-12">
         <a class="equiteasy-logo" href="{{ route('home') }}"><img src="{{ asset('img/header/logo.png') }}" height="40" alt="Equiteasy" /></a>

         <div id="menu-icon">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
         </div>

         <div id="menu" class="float-right">
            <nav>
               <a href="{{ route('home') }}"{!! Request::route() && Request::route()->action['as'] === 'home' ? ' class="selected"' : '' !!}>@lang('pages.home')</a>
               <a href="{{ route('cursus') }}"{!! Request::route() && Request::route()->action['as'] === 'cursus' ? ' class="selected"' : '' !!}>@lang('pages.cursus')</a>
               <a href="{{ route('document') }}"{!! Request::route() && Request::route()->action['as'] === 'document' ? ' class="selected"' : '' !!}>@lang('pages.document')</a>
               <a href="{{ route('contact') }}"{!! Request::route() && Request::route()->action['as'] === 'contact' ? ' class="selected"' : '' !!}>@lang('pages.contact')</a>
            </nav>

            <!-- <ul class="language-selector">
               @foreach( LaravelLocalization::getSupportedLocales() as $localeCode => $properties )
                  <li>
                     <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"{!! LaravelLocalization::getCurrentLocale() === $localeCode ? 'class="active"' : '' !!}>{{ $localeCode }}</a>
                  </li>
               @endforeach
            </ul> -->

            <!-- @if( Auth::check() )
               <div class="authenticated">
                  <div class="user">
                     <p>{{ Auth::user()->full_name }}</p>
                     <a href="{{ route('projects') }}">@lang('dashboard.title')</a>
                  </div>

                  <a class="logout" href="{{ route('logout') }}"><span class="icon-logout"></span></a>
               </div>
            @else
               <div class="signup">
                  <div class="item">
                     <a class="button round blue-border signup-button" href="{{ route('register') }}">@lang('buttons.signup')</a>
                  </div>
                  <div class="item">
                     <div class="button round blue login-button">@lang('buttons.login')</div>
                  </div>
               </div>
            @endif -->
         </div>
      </div>
   </div>
</header>
