@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.overview'))

@section('js')
   <script type="text/javascript">
   $(function() {
      $('#stop-match').on('click', function() {
         openPopup($('#stop-match-popup'))
      });
   });
   </script>
@endsection

@section('content')
   <div id="match-overview">
      @include('front.dashboard.match.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.match_overview.title')</h1>

                     <section>
                        @include('front.dashboard.match.project.timeline')
                     </section>
                  </div>
               </div>

               @if( $project->stopped )
                  <section class="project-status red">
                     <div class="container">
                        <div class="col-12 align-center">
                           <p>@lang('dashboard.match_overview.project_status.stopped_project')</p>
                        </div>
                     </div>
                  </section>
               @else
                  <section class="project-status{{ $match->status === 'ended' || $match->status === 'declined' ? ' red' : '' }}">
                     <div class="container">
                        <div class="col-12 align-center">
                           @if( $match->status === 'ended' )
                              <p>@lang('dashboard.match_overview.project_status.ended_' . $match->ended_by, ['with' => $with, 'date' => date('d/m/Y', strtotime($match->ended_at))])</p>
                           @else
                              <p>@lang('dashboard.match_overview.project_status.' . $match->status)</p>
                           @endif

                           @if( in_array($match->status, ['nda_signature', 'nda_validation']) )
                              <a href="{{ route('match_view_nda', ['id' => $match->id]) }}" class="button red small">@lang('buttons.view_nda')</a>
                           @elseif( in_array($match->status, ['loi_uploaded', 'loi_declined']) )
                              <a href="{{ route('match_view_document', ['id' => $match->id, 'type' => 'loi']) }}" class="button red small">@lang('buttons.view_loi')</a>
                           @elseif( in_array($match->status, ['binding_offer_uploaded', 'binding_offer_declined']) )
                              <a href="{{ route('match_view_document', ['id' => $match->id, 'type' => 'binding_offer']) }}" class="button red small">@lang('buttons.view_binding_offer')</a>
                           @endif
                        </div>
                     </div>
                  </section>
               @endif

               @include('front.dashboard.match.partials.match_events')

               @if( ($projectRole === 'admin' || $projectRole === 'representative') && !$match->ended_at && !$match->declined && !$match->binding_offer_accepted && !$project->stopped )
                  <section class="align-center">
                     <div class="container">
                        <div class="col-12">
                           <div id="stop-match" class="button red small">@lang('buttons.project_stop_match')</div>
                        </div>
                     </div>
                  </section>
               @endif
            </div>
         </div>
      </div>
   </div>

   @include('front.dashboard.match.partials.popup_stop')
@endsection
