<header class="project-header">
   <div class="container">
      <div class="col-6 lg-4 m-12 float-right align-right">
         <div class="logo">
            <p><span class="match-name"><span class="project">{{ $project->name }}</span> / {{ $match->matchable_type === 'strategy' ? $match->matchable->name : $match->matchable->full_name }}</span></span><br /><a href="{{ route('projects') }}">← @lang('dashboard.project.nav.back')</a></p>
            <div class="logo-project"><span>{{ $project->short_name }}</span></div>
         </div>
      </div>

      <div class="col-6 lg-8 m-12">
         <nav>
            <a href="{{ route('match_overview', ['id' => $match->id]) }}"{!! Request::route()->action['as'] === 'match_overview' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.overview')</a>
            <a href="{{ route('match_discussion', ['id' => $match->id]) }}"{!! Request::route()->action['as'] === 'match_discussion' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.discussion')</a>

            @if( $matchAccess === 'project' || $matchAccess === 'strategy' && $match->hasSignedNda() && $match->isViewable() )
               <a href="{{ route('match_project', ['id' => $match->id, 'step' => 'synthesis']) }}"{!! Request::route()->action['as'] === 'match_project' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.project')</a>
            @endif
         </nav>
      </div>
   </div>
</header>
