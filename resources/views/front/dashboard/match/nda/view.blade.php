@extends('front.layout.dashboard')

@section('title', trans('fields.document'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/signatory.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/nda.js') }}"></script>

   <script type="text/javascript">
   var swalValidateTitle = "@lang('popups.validate_nda.title')";
   var swalValidateText = "@lang('popups.validate_nda.text')";
   var swalBypassTitle = "@lang('popups.bypass_nda.title')";
   var swalBypassText = "@lang('popups.bypass_nda.text')";
   var swalConfirmButton = "@lang('common.yes')";
   var swalCancelButton = "@lang('common.no')";
   </script>
@endsection

@section('content')
   <div id="project-nda">
      @include('front.dashboard.match.'. $matchAccess .'.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.nda.title')</h1>
                  </div>
               </div>

               @if( $match->nda )
                  {{-- The NDA is already generated --}}

                  <div class="container">
                     <div class="col-12">
                        @if( $matchAccess === 'project' )
                           <section>
                              <p><strong>@lang('dashboard.nda.signatories')</strong></p>

                              <ul class="signatories">
                                 @foreach( $match->nda->signatories as $signatory )
                                    @if( $signatory->status === 'signed' )
                                       @php $signatureDate = $signatory->getSignatureDateTime(); @endphp

                                       <li>
                                          <span class="icon-check"></span>
                                          <strong>{{ $signatory->user->full_name }}</strong> ({{ $signatory->email }})<br />
                                          @lang('dashboard.nda.signed_at', ['date' => $signatureDate['date'], 'time' => $signatureDate['time']])
                                       </li>
                                    @else
                                       <li>
                                          <span class="icon-delete"></span>
                                          <strong>{{ $signatory->user->full_name }}</strong> ({{ $signatory->email }})<br />
                                          @lang('dashboard.nda.pending')

                                          @if( $signatory->user_id === Auth::id() )
                                             - <a href="{{ route('sign_document', ['signatoryId' => $signatory->id, 'token' => $signatory->yousign_token]) }}" class="link" target="_blank">@lang('buttons.go_to_signature')</a>
                                          @endif
                                       </li>
                                    @endif
                                 @endforeach
                              </ul>

                              <a class="button blue small" download="{{ $match->nda->name }}" href="{{ route('serve_document', ['id' => $match->nda_id]) }}">@lang('dashboard.nda.download')</a>

                              @if( !$match->hasSignedNda() && ($projectRole === 'admin' || $projectRole === 'representative') )
                                 <a class="button red small" href="{{ route('match_cancel_nda', ['id' => $match->id]) }}">@lang('dashboard.nda.cancel')</a>
                              @endif
                           </section>
                        @else
                           <section class="align-center">
                              @if( $match->hasSignedNda() )
                                 <p>@lang('dashboard.nda.signed')</p>
                              @else
                                 <p>@lang('dashboard.nda.not_signed')</p>
                              @endif

                              <a class="button blue small" download="{{ $match->nda->name }}" href="{{ route('serve_document', ['id' => $match->nda_id]) }}">@lang('dashboard.nda.download')</a>
                           </section>
                        @endif

                        <section class="align-center">
                           <a href="{{ route('match_overview', ['id' => $match->id]) }}" class="back-button">@lang('buttons.back_to_overview')</a>
                        </section>
                     </div>
                  </div>

               @else
                  {{-- The NDA has not been generated yet --}}

                  <div class="container">
                     <div class="col-12 align-center">
                        @if( $matchAccess === 'strategy' || $projectRole === 'admin' || $projectRole === 'representative' )
                           @if( $isEditable )
                              @lang('dashboard.nda.edit_text_' . $matchAccess)
                           @else
                              @lang('dashboard.nda.pending_text_' . $matchAccess)
                           @endif
                        @endif

                        <div id="nda">
                           {!! $match->nda_text !!}
                        </div>
                     </div>
                  </div>

                  @if( $matchAccess === 'strategy' && !$match->strategy_signatory )

                     {{-- Strategy has no signatory --}}
                     @include('front.dashboard.match.strategy.signatory')

                  @elseif( $matchAccess === 'strategy' && $match->strategy_signatory && !$match->strategy_signatory->phone_mobile )

                     {{-- Strategy has a signatory but no phone number --}}
                     <div class="container">
                        <div class="col-12 align-center">
                           <p>@lang('dashboard.nda.no_phone_number')</p>

                           <a href="{{ route('parameters_personal') }}" class="button red small">@lang('buttons.go_to_parameters')</a>
                        </div>
                     </div>

                  @elseif( $matchAccess === 'strategy' || $projectRole === 'admin' || $projectRole === 'representative' )

                     <div class="container">
                        <div class="col-12 align-center">
                           <section>
                              @if( $matchAccess === 'strategy' && $match->mustEditNda() )
                                 <a href="{{ route('match_edit_nda', ['id' => $match->id]) }}" class="button blue">@lang('buttons.edit_nda')</a>
                              @elseif( $isEditable )
                                 <form id="validate-nda" method="post" action="{{ route('match_accept_nda', ['id' => $match->id]) }}">
                                    {{ csrf_field() }}
                                    <input type="submit" class="blue" value="@lang('buttons.accept_nda_version')" />

                                    <a href="{{ route('match_edit_nda', ['id' => $match->id]) }}" class="button red">@lang('buttons.edit_nda_version')</a>
                                 </form>
                              @else
                                 <div class="button disabled">@lang('dashboard.nda.pending')</div>
                              @endif

                              <p>@lang('dashboard.upload_document.discuss_' . $matchAccess, ['link' => route('match_discussion', ['id' => $match->id])])</p>
                           </section>
                        </div>
                     </div>

                  @endif

                  @if( $matchAccess === 'project' && $projectRole === 'admin' || $projectRole === 'representative' )
                     <div class="container">
                        <div class="col-12 align-center">
                           <section>
                              <form id="bypass-nda" method="post" action="{{ route('match_bypass_nda', ['id' => $match->id]) }}">
                                 {{ csrf_field() }}
                                 <input type="submit" class="blue small" value="@lang('buttons.bypass_nda')" />
                              </form>
                           </section>
                        </div>
                     </div>
                  @endif

               @endif
            </div>
         </div>
      </div>
   </div>
@endsection
