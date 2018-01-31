<header class="project-header">
   <div class="container">
      <div class="col-6 lg-4 m-12 float-right align-right">
         <div class="logo">
            <p><span class="match-name"><span class="project">{{ $project->name }}</span></span><br /><a href="{{ route('projects') }}">← @lang('dashboard.project.nav.back')</a></p>
            <div class="logo-project"><span>{{ $project->short_name }}</span></div>
         </div>
      </div>

      <div class="col-6 lg-8 m-12">
         <nav>
            <a href="{{ route('project_overview', ['id' => $project->id]) }}"{!! Request::route()->action['as'] === 'project_overview' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.overview')</a>

            @if( $projectRole === 'admin' || $projectRole === 'representative' )
               <a href="{{ route('project_edit', ['id' => $project->id, 'step' => 'synthesis']) }}"{!! Request::route()->action['as'] === 'project_edit' || Request::route()->action['as'] === 'project_view' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.project')</a>
            @else
               <a href="{{ route('project_view', ['id' => $project->id, 'step' => 'synthesis']) }}"{!! Request::route()->action['as'] === 'project_view' || Request::route()->action['as'] === 'project_edit' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.project')</a>
            @endif
            @if( $projectRole )
               <a href="{{ route('project_steering', ['id' => $project->id]) }}"{!! Request::route()->action['as'] === 'project_steering' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.steering')</a>
            @endif
            @if( $projectRole === 'admin' || $projectRole === 'representative' )
               <a href="{{ route('project_guests', ['id' => $project->id]) }}"{!! Request::route()->action['as'] === 'project_guests' ? ' class="active"' : '' !!}>@lang('dashboard.project.nav.guests')</a>
            @endif
         </nav>
      </div>
   </div>
</header>
