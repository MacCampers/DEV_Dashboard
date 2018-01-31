<div class="col-4 m-6 s-12">
   <div class="project">
      <div class="company">
         <span>
            {{ $project->name }}<br />
            @if( $match->matchable_type === 'strategy' )
               <span class="strategy-name">{{ $match->matchable->name }}</span>
            @else
               <span class="strategy-name">{{ $match->matchable->full_name }}</span>
            @endif
         </span>
      </div>

      <div class="flex">
         @if( $project->stopped )
            <div class="next-step">
               <div class="title">@lang('dashboard.project.stopped')</div>
            </div>
            @if( $match->isViewable() )
               <a href="{{ route('match_overview', ['id' => $match->id]) }}" class="button blue">@lang('buttons.view_project')</a>
            @else
               <div class="button disabled">@lang('buttons.view_project')</div>
            @endif
         @else
            @php $remainingTime = $project->getCurrentStepRemainingTime(); @endphp

            <div class="next-step">
               <div class="title">@lang('dashboard.project.next_step')</div>
               <p>@choice('dashboard.project.step_'. $project->current_step .'_description', $remainingTime, ['n' => $remainingTime])</p>

               <div class="progress-bar">
                  <span style="width: {{ ($project->step1_duration / $project->duration) * 100 }}%;"></span>
                  <span style="width: {{ ($project->step2_duration / $project->duration) * 100 }}%;"></span>
                  <span style="width: {{ ($project->step3_duration / $project->duration) * 100 }}%;"></span>
                  <div class="fill" style="width: {{ ($project->completion < 100) ? $project->completion : 100 }}%;"></div>
               </div>
            </div>

            @if( $match->isViewable() )
               <a href="{{ route('match_overview', ['id' => $match->id]) }}" class="button blue">@lang('buttons.view_project')</a>
            @else
               <div class="button disabled">@lang('buttons.view_project')</div>
            @endif
         @endif
      </div>
   </div>
</div>
