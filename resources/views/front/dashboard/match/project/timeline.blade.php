<div id="match-timeline">
   <div class="row">
      <div class="start-date">@lang('dashboard.steering.project_real_start_date') {{ date('d/m/Y', strtotime($project->start_date)) }}</div>
      <div class="end-date">@lang('dashboard.steering.project_end_date') {{ date('d/m/Y', strtotime($project->end_date)) }}</div>
   </div>

   <div class="timeline">
      <div class="step has-action" style="width: {{ ($project->step1_duration / $project->duration) * 100 }}%;">
         @if( $project->need_nda && !$match->nda_bypass )
            <div class="title nda">
               <a href="{{ route('match_view_nda', ['id' => $match->id]) }}">@lang('buttons.view_nda')</a>
            </div>
         @endif

         <div class="fill"></div>
         <div class="title">
            @if( !$match->loi )
               @lang('dashboard.match_overview.loi')
            @else
               <a href="{{ route('match_view_document', ['id' => $match->id, 'document' => 'loi']) }}"><span class="icon icon-document"></span>@lang('buttons.view_loi')</a>
            @endif
         </div>
      </div>
      <div class="step" style="width: {{ ($project->step2_duration / $project->duration) * 100 }}%;">
         <div class="fill"></div>
         <div class="title" title="@lang('dashboard.match_overview.loi_selection')">
            @if( $match->loi_accepted )
               <span class="icon icon-check"></span>
            @elseif( !$match->loi_accepted && !$match->isRunning() )
               <span class="icon icon-delete"></span>
            @endif

            @lang('dashboard.match_overview.loi_selection')
         </div>
      </div>
      <div class="step has-action" style="width: {{ ($project->step3_duration / $project->duration) * 100 }}%;">
         <div class="fill"></div>
         <div class="title">
            @if( !$match->binding_offer )
               @lang('dashboard.match_overview.binding_offer')
            @else
               <a href="{{ route('match_view_document', ['id' => $match->id, 'document' => 'binding_offer']) }}"><span class="icon icon-document"></span>@lang('buttons.view_binding_offer')</a>
            @endif
         </div>
      </div>
      <div class="step" style="width: {{ ($project->step4_duration / $project->duration) * 100 }}%;">
         <div class="fill"></div>
         <div class="title" title="@lang('dashboard.match_overview.binding_offer_selection')">
            @if( $match->binding_offer_accepted )
               <span class="icon icon-check"></span>
            @elseif( !$match->binding_offer_accepted && !$match->isRunning() )
               <span class="icon icon-delete"></span>
            @endif

            @lang('dashboard.match_overview.binding_offer_selection')
         </div>
      </div>

      <div class="cursor step-{{ $project->current_step }}" style="left: {{ ($project->completion < 100) ? $project->completion : 100 }}%;"></div>
      <div class="mask{{ $match->completion === 0 ? ' full' : '' }}" style="width: {{ 100 - $match->completion }}%;"></div>
   </div>
</div>
