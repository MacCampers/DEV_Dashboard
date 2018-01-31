<div class="col-4 m-6 s-12">
   <div class="project">
      <div class="company">
         <span>{{ $project->name }}</span>
      </div>

      <div class="flex">
         @if( $project->stopped )
            <div class="next-step">
               <div class="title">@lang('dashboard.project.stopped')</div>
            </div>

            @if( $project->initiator->company->isSubscribed() && !$project->canceled )
               <a href="{{ route('project_overview', ['id' => $project->id]) }}" class="button blue">@lang('buttons.view_project')</a>
            @else
               <div class="button disabled">@lang('buttons.view_project')</div>
            @endif
         @else
            @if( !$project->locked )
               <div class="next-step">
                  @if( !$project->confirmed )
                     <div class="title">@lang('dashboard.project.in_progress')</div>
                  @else
                     <div class="title">@lang('dashboard.project.ready')</div>
                  @endif
               </div>
            @elseif ($project->confirmed)
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
            @else
               <div class="next-step">
                  <div class="title">@lang('dashboard.project.waiting_phase')</div>
               </div>
            @endif

            @if( $project->initiator->company->isSubscribed() && !$project->canceled )
               <a href="{{ route('project_overview', ['id' => $project->id]) }}" class="button blue">@lang('buttons.view_project')</a>
            @else
               <div class="button disabled">@lang('buttons.view_project')</div>
            @endif
         @endif
      </div>
   </div>
</div>
