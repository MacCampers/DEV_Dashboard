<section class="nav-wrapper">
   <nav class="project-nav">
      <div class="container">
         <div class="col-12">
            <a href="{{ route('company_information') }}"{{ Request::route()->action['as'] === 'company_information' ? ' class=active' : '' }}>@lang('parameters.company.information.title')</a>

            @if( Auth::user()->type === 'investor' )
               <a href="{{ route('company_strategies') }}"{{ Request::route()->action['as'] === 'company_strategies' ? ' class=active' : '' }}{{ Request::route()->action['as'] === 'company_request_strategy_creation' ? ' class=active' : '' }}{{ Request::route()->action['as'] === 'company_request_strategy_update' ? ' class=active' : '' }}>@lang('parameters.company.strategies.title')</a>
               <a href="{{ route('company_members') }}"{{ Request::route()->action['as'] === 'company_members' ? ' class=active' : '' }}>@lang('parameters.company.members.title')</a>
            @endif
         </div>
      </div>
   </nav>
</section>
