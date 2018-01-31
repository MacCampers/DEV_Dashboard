@extends('front.layout.dashboard')

@section('title', trans('dashboard.select'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/match.js') }}"></script>
@endsection

@section('content')
   <div id="matching-results">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel{{ session()->has('selection_error') ? ' with-alert' : '' }}"{!! $project->pending_matches->count() === 0 ? ' style="padding-bottom: 0;"' : '' !!}>
               @if( session()->has('selection_error')  )
                  @include('front.dashboard.partials.error', ['message' => trans('dashboard.matching.selection_error')])
               @endif

               <div class="container">
                  <div class="col-12 align-center">
                     <h1>@lang('dashboard.matching.investors_selection')</h1>
                     <p>@lang('dashboard.matching.investors_identified')</p>
                  </div>
               </div>

               @if( $project->selected_matches->count() > 0 )
                  <section id="selected-matches" class="matches">
                     <div class="container">
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('dashboard.matching.selected_matches')</h2>
                           </div>

                           @foreach( $project->selected_matches as $match )
                              <div class="col-4">
                                 <div class="match shadow-box selected">
                                    @if( $match->matchable_type === 'strategy' )
                                       <h3 title="{{ $match->matchable->company->name }}">{{ $match->matchable->company->name }}</h3>
                                       @if( $match->matchable->name !== $match->matchable->company->name )
                                          <h4 title="{{ $match->matchable->name }}">{{ $match->matchable->name }}</h4>
                                       @else
                                          <h4>&nbsp;</h4>
                                       @endif

                                       @if( $match->matchable->company->category )
                                          <h5>@lang('fields.company_categories.'. $match->matchable->company->category)</h5>
                                       @else
                                          <h5>&nbsp;</h5>
                                       @endif

                                       @if( $match->matchable->company->website )
                                          <a href="{{ $match->matchable->company->website }}" target="_blank">@lang('buttons.view_website')</a>
                                       @else
                                          <span>&nbsp;</span>
                                       @endif

                                       <div class="score">#{{ ($matches->search($match->id)+1) }}</div>
                                    @else
                                       <h3 title="{{ $match->matchable->full_name }}">{{ $match->matchable->full_name }}</h3>
                                       <h4 title="{{ $match->matchable->company->name }}">{{ $match->matchable->company->name }}</h4>

                                       @if( $match->matchable->company->category )
                                          <h5>@lang('fields.company_categories.'. $match->matchable->company->category)</h5>
                                       @else
                                          <h5>&nbsp;</h5>
                                       @endif

                                       <span>&nbsp;</span>

                                       <div class="score">&nbsp;</div>
                                    @endif

                                    @if( $match->canResendEmail() )
                                       <form method="post" action="{{ route('match_send_mail', ['id' => $match->id]) }}">
                                          {{ csrf_field() }}
                                          <input type="submit" class="red small" value="@lang('buttons.contact_again')" />
                                       </form>
                                    @else
                                       <div class="button grey disabled small">@lang('buttons.contact_again')</div>
                                    @endif
                                 </div>
                              </div>
                           @endforeach
                        </div>
                     </div>
                  </section>
               @endif

               @if( $project->pending_matches->count() > 0 )
                  <form id="matches-selection" method="post" action="{{ route('store_selection', ['id' => $project->id]) }}">
                     {{ csrf_field() }}

                     {{-- Available matches --}}
                     <section id="pending-matches" class="matches">
                        <div class="container">
                           <div class="col-12">
                              @if( $errors->has('strategies') )
                                 <section class="message error-message">
                                    <p>@lang('dashboard.matching.select_error')</p>
                                    <span class="icon-cross"></span>
                                 </section>
                              @endif
                           </div>

                           <div class="row">
                              <div class="col-12">
                                 <h2>@lang('dashboard.matching.pending_matches')</h2>
                              </div>

                              @foreach( $project->pending_matches as $match )
                                 <div class="col-4">
                                    <div class="match shadow-box selectable{{ session('selected_matches') && in_array($match->id, session('selected_matches')) ? ' selected' : '' }}">
                                       @if( $match->matchable_type === 'strategy' )
                                          <h3 title="{{ $match->matchable->company->name }}">{{ $match->matchable->company->name }}</h3>
                                          @if( $match->matchable->name !== $match->matchable->company->name )
                                             <h4 title="{{ $match->matchable->name }}">{{ $match->matchable->name }}</h4>
                                          @else
                                             <h4>&nbsp;</h4>
                                          @endif

                                          @if( $match->matchable->company->category )
                                             <h5>@lang('fields.company_categories.'. $match->matchable->company->category)</h5>
                                          @else
                                             <h5>&nbsp;</h5>
                                          @endif

                                          @if( $match->matchable->company->website )
                                             <a href="{{ $match->matchable->company->website }}" target="_blank">@lang('buttons.view_website')</a>
                                          @else
                                             <span>&nbsp;</span>
                                          @endif

                                          <div class="score">#{{ ($matches->search($match->id)+1) }}</div>
                                       @else
                                          <h3 title="{{ $match->matchable->full_name }}">{{ $match->matchable->full_name }}</h3>
                                          <h4 title="{{ $match->matchable->company->name }}">{{ $match->matchable->company->name }}</h4>

                                          @if( $match->matchable->company->category )
                                             <h5>@lang('fields.company_categories.'. $match->matchable->company->category)</h5>
                                          @else
                                             <h5>&nbsp;</h5>
                                          @endif

                                          <span>&nbsp;</span>

                                          <div class="score">&nbsp;</div>
                                       @endif

                                       <div class="checkbox">
                                          <input type="checkbox" id="match-{{ $loop->index }}" name="matches[]" value="{{ $match->id }}"{{ session('selected_matches') && in_array($match->id, session('selected_matches')) ? ' checked' : '' }} />
                                          <label for="match-{{ $loop->index  }}">&nbsp;</label>
                                          <span class="checkmark"></span>
                                       </div>
                                    </div>
                                 </div>
                              @endforeach
                           </div>
                        </div>
                     </section>
                  </form>
               @endif

               {{-- Manually adding investors --}}
               <section id="add-investors-section" class="blue-pattern">
                  <div class="container">
                     <div class="row">
                        <div class="col-12 align-center">
                           <h2>@lang('dashboard.matching.add_investors')</h2>
                           <p>@lang('dashboard.matching.add_investors_subtitle')</p>

                           <div id="add-investor" class="button red small">@lang('buttons.add_investor')</div>
                        </div>
                     </div>
                  </div>
               </section>

               @if( $project->pending_matches->count() > 0 )
                  <section>
                     <div class="container">
                        <div class="col-12">
                           <h2>@lang('dashboard.matching.visible_informations')</h2>

                           <div class="email-preview">
                              <div class="email-container">
                                 <img class="logo" src="{{ asset('img/logo_v.png') }}" width="200" />

                                 <div class="title">@lang('emails.match.title')</div>
                                 <div class="teaser">{{ $project->getField('teaser_mail') }}</div>

                                 <table class="table">
                                    <tr>
                                       <th colspan="2">@lang('emails.match.project_data')</th>
                                    </tr>

                                    <tr>
                                       <td style="font-weight: 700;">@lang('emails.match.fields.code_name')</td>
                                       <td>{{ $project->code_name }}</td>
                                    </tr>
                                    <tr>
                                       <td style="font-weight: 700;">@lang('emails.match.fields.country')</td>
                                       <td>{{ $project->company_country->name }}</td>
                                    </tr>
                                    <tr>
                                       <td style="font-weight: 700;">@lang('emails.match.fields.type')</td>
                                       <td>@lang('fields.project.synthesis.'. $project->type)</td>
                                    </tr>
                                    @if( $project->type === 'fundraising' )
                                       <tr>
                                          <td style="font-weight: 700;">@lang('emails.match.fields.amount_searched')</td>
                                          <td>{{ number_format($project->amount_searched, 0, ',', ' ') . ' ' . $project->currency_symbol }}</td>
                                       </tr>
                                    @else
                                       <tr>
                                          <td style="font-weight: 700;">@lang('emails.match.fields.turnover')</td>
                                          <td>{{ number_format(round($project->turnover_m_1, -5), 0, ',', ' ') . ' ' . $project->currency_symbol }}</td>
                                       </tr>
                                    @endif
                                    <tr>
                                       <td style="font-weight: 700;">@lang('emails.match.fields.development_stage')</td>
                                       <td>{{ $project->development_stage->name }}</td>
                                    </tr>
                                    <tr>
                                       <td style="font-weight: 700;">@lang('emails.match.fields.activity_areas')</td>
                                       <td>
                                          @foreach( $project->activity_areas as $activityArea )
                                             {{ $activityArea->name }}<br />
                                          @endforeach
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>

                     <section>
                        <div class="container">
                           <div class="row">
                              <div class="col-12 align-center">
                                 <p>@lang('dashboard.matching.contact_investors')</p>

                                 <div id="submit-selection" class="button blue">@lang('buttons.contact_investors')</div>
                              </div>
                           </div>
                        </div>
                     </section>
                  @endif
               </section>
            </div>
         </div>
      </div>
   </div>

   @include('front.dashboard.project.matching.add_investor_popup')
@endsection
