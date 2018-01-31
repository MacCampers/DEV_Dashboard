@extends('front.layout.dashboard')

@section('title', trans('fields.document'))

@section('js')
   <script type="text/javascript">
   $(function() {
      $('#accept-document').on('click', function() {
         openPopup($('#accept-document-popup'));
      });
      $('#decline-document').on('click', function() {
         openPopup($('#decline-document-popup'));
      });
   });
   </script>
@endsection

@section('content')
   <div id="match-document">
      @include('front.dashboard.match.'. $matchAccess .'.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.view_'. $type .'.title')</h1>
                  </div>

                  <section>
                     <div class="row">
                        <div class="col-6 align-center">
                           @php $acceptedAttr = $type . '_accepted'; @endphp
                           @if( $matchAccess === 'project' && !$match->$acceptedAttr && $match->isRunning() && ($projectRole === 'admin' || $projectRole === 'representative') )
                              <div id="document">
                                 <iframe src="{{ route('serve_document', ['id' => $match->$type->id]) }}"></iframe>

                                 <p>@lang('dashboard.upload_document.discuss_' . $matchAccess, ['link' => route('match_discussion', ['id' => $match->id])])</p>
                              </div>

                              @if( !$currentOffer->declined )
                                 <div class="document-actions">
                                    <div class="action">
                                       <div id="accept-document" class="button blue">@lang('buttons.accept')</div>
                                    </div>
                                    <div class="action">
                                       <div id="decline-document" class="button red small">@lang('buttons.decline_offer')</div>
                                    </div>
                                 </div>
                              @endif
                           @else
                              <div id="document">
                                 <iframe src="{{ route('serve_document', ['id' => $match->$type->id]) }}"></iframe>

                                 <a href="{{ route('serve_document', ['id' => $match->$type->id]) }}" class="button blue small" download="{{ $match->$type->name }}">@lang('buttons.download_file')</a>
                              </div>
                           @endif
                        </div>

                        <div class="col-6">
                           @if( $offers->count() > 0 )
                              @include('front.dashboard.match.document.history')
                           @endif
                        </div>
                     </div>
                  </section>

                  @if( $matchAccess === 'strategy' && !$match->$acceptedAttr && $match->isRunning() )
                     <section>
                        <div class="row">
                           <div class="col-12 align-center">
                              <a href="{{ route('match_upload_form', ['id' => $match->id, 'type' => $type]) }}" class="button blue">@lang('buttons.upload_new_' . $type)</a>
                           </div>
                        </div>
                     </section>
                  @endif

                  <section>
                     <div class="col-12 align-center">
                        <a href="{{ route('match_overview', ['id' => $match->id]) }}" class="back-button">@lang('buttons.back_to_overview')</a>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>

      @if( $match->$type )
         @include('front.dashboard.match.document.popups.accept')
         @include('front.dashboard.match.document.popups.decline')
      @endif
   </div>
@endsection
