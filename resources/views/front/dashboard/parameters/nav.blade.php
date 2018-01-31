<section class="nav-wrapper">
   <nav class="project-nav">
      <div class="container">
         <div class="col-12">
            <a href="{{ route('parameters_personal') }}"{!! Request::route()->action['as'] === 'parameters_personal' ? ' class="active"' : '' !!}>@lang('parameters.personal.title')</a>

            @if( Auth::user()->isProjectManager() && Auth::user()->company_role === 'representative' )
               <a href="{{ route('parameters_subscription') }}"{!! Request::route()->action['as'] === 'parameters_subscription' ? ' class="active"' : '' !!}>@lang('parameters.subscription.title')</a>
               @if( Auth::user()->type !== 'contractor' )
                  <a href="{{ route('parameters_users') }}"{!! Request::route()->action['as'] === 'parameters_users' ? ' class="active"' : '' !!}>@lang('parameters.users.title')</a>
               @endif
            @endif
         </div>
      </div>
   </nav>
</section>
