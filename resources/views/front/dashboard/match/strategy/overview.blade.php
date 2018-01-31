@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.overview'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/signatory.js') }}"></script>
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
      @include('front.dashboard.match.strategy.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12 align-center">
                     <h1>@lang('dashboard.match_overview.title')</h1>

                     @if( $match->isRunning() && !$project->stopped)
                        <section>
                           @include('front.dashboard.match.strategy.timeline')
                        </section>
                     @else
                        <section>
                           @include('front.dashboard.match.project.timeline')
                        </section>
                     @endif
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
                  @if( !$match->strategy_signatory )
                     @include('front.dashboard.match.strategy.signatory')
                  @else
                     <section class="project-status{{ $match->status === 'ended' ? ' red' : '' }}">
                        <div class="container">
                           <div class="col-12 align-center">
                              @if( $match->status === 'ended' )
                                 <p>@lang('dashboard.match_overview.strategy_status.ended_' . $match->ended_by, ['with' => $with, 'date' => date('d/m/Y', strtotime($match->ended_at))])</p>
                              @else
                                 <p>@lang('dashboard.match_overview.strategy_status.' . $match->status)</p>
                              @endif

                              @if( in_array($match->status, ['nda_signature', 'nda_validation']) )
                                 <a href="{{ route('match_view_nda', ['id' => $match->id]) }}" class="button red small">@lang('buttons.view_nda')</a>
                              @elseif( $match->status === 'loi_uploaded' )
                                 <a href="{{ route('match_view_document', ['id' => $match->id, 'type' => 'loi']) }}" class="button red small">@lang('buttons.view_loi')</a>
                              @elseif( in_array($match->status, ['loi_declined', 'loi_pending']) )
                                 <a href="{{ route('match_upload_form', ['id' => $match->id, 'type' => 'loi']) }}" class="button red small">@lang('buttons.upload_loi')</a>
                              @elseif( $match->status === 'binding_offer_uploaded' )
                                 <a href="{{ route('match_view_document', ['id' => $match->id, 'type' => 'binding_offer']) }}" class="button red small">@lang('buttons.view_binding_offer')</a>
                              @elseif( in_array($match->status, ['binding_offer_declined', 'binding_offer_pending']) )
                                 <a href="{{ route('match_upload_form', ['id' => $match->id, 'type' => 'binding_offer']) }}" class="button red small">@lang('buttons.upload_binding_offer')</a>
                              @endif
                           </div>
                        </div>
                     </section>
                  @endif
               @endif

               @include('front.dashboard.match.partials.match_events')

               @if( !$match->ended_at && $match->status !== 'ended' && !$project->stopped )
                  <section class="align-center">
                     <div class="container">
                        <div class="col-12">
                           <div id="stop-match" class="button red small">@lang('buttons.strategy_stop_match')</div>
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
