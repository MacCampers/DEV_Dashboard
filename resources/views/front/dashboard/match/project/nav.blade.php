<header class="project-header">
   <div class="container">
      <div class="col-6 lg-4 m-12 float-right align-right">
         <div class="logo">
            <p><span class="match-name"><span class="project">{{ $project->name }}</span> / {{ $match->matchable->full_name }}</span><br /><a href="{{ route('project_overview', ['id' => $project->id]) }}">← @lang('dashboard.project.nav.back_match')</a></p>
            <div class="logo-project"><span>{{ $project->short_name }}</span></div>
         </div>
      </div>

      <div class="col-6 lg-8 m-12">
         <nav>
            <a href="{{ route('match_overview', ['id' => $match->id]) }}"{!! Request::route()->action['as'] === 'match_overview' ? ' class="active"' : '' !!}{!! Request::route()->action['as'] === 'match_view_nda' ? ' class="active"' : '' !!}{!! Request::route()->action['as'] === 'match_edit_nda' ? ' class="active"' : '' !!}{!! Request::route()->action['as'] === 'match_cancel_nda' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.overview')</a>
            <a href="{{ route('match_discussion', ['id' => $match->id]) }}"{!! Request::route()->action['as'] === 'match_discussion' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.discussion')</a>
         </nav>
      </div>
   </div>
</header>
