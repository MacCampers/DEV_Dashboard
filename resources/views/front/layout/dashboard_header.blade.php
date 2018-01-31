<header class="dashboard">
   <div class="container row">
      <div class="col-12">
         <a class="equiteasy-logo" href="{{ route('projects') }}"><img src="{{ asset('img/logo_h_white.svg') }}" height="40" alt="Equiteasy" /></a>

         <div id="menu-icon">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
         </div>

         <div id="menu" class="float-right">
            @php $url = Request::url() @endphp
            <nav id="main-nav">
               <a href="{{ route('projects') }}" class="{{ preg_match('/^project/', Request::route()->action['as']) ? 'active' : '' }} {{ preg_match('/^match/', Request::route()->action['as']) ? 'active' : '' }} ">@lang('dashboard.projects')</a>

               <a href="{{ route('parameters_personal') }}" class="{{ preg_match('/^parameters/', Request::route()->action['as']) ? 'active' : ''}}">@lang('parameters.title')</a>

               @if( Auth::user()->is_admin  )
                  <a href="{{ route('company_information') }}" class="{{ preg_match('/^company/', Request::route()->action['as']) ? 'active' : ''}}">@lang('parameters.company.title')</a>
               @endif

               <a href="{{ route('help_dashbord') }}" class="{{ preg_match('/^help/', Request::route()->action['as']) ? 'active' : ''}}">@lang('dashboard.help')</a>
            </nav>

            <div class="authenticated">
               <div class="user">
                  <p class="name">{{ Auth::user()->full_name }}</p>
                  <p class="type">@lang('fields.account_types.'.Auth::user()->type)</p>
               </div>

               <a class="logout" href="{{ route('logout') }}"><span class="icon-logout"></span></a>
            </div>
         </div>
      </div>
   </div>
</header>
