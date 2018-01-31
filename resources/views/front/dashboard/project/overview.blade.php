@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.overview'))

@section('content')
   <div id="project-overview">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel align-center">
               <div class="container">
                  <div class="row">
                     <div class="col-12">
                        <h1>@lang('dashboard.overview.welcome')</h1>
                     </div>
                  </div>

                  @if( !$project->locked )

                     {{--
                     |--------------------------------------------------------------------------
                     | Project is unlocked
                     |--------------------------------------------------------------------------
                     --}}

                     @if( $projectRole === 'admin' || $projectRole === 'representative' )
                        {{-- User is admin --}}

                        @if( !$project->hasSignedLicence() )
                           {{-- Licence warning --}}

                           @if( $project->licence )
                              <div class="col-12">
                                 <p>@lang('dashboard.overview.licence_not_signed', ['signatory_name' => $project->licence->signatories[0]->user->full_name, 'signatory_email' => $project->licence->signatories[0]->email])</p>

                                 <form method="post" action="{{ route('project_send_licence', ['id' => $project->id]) }}">
                                    {{ csrf_field() }}
                                    <input type="submit" class="blue small" value="@lang('buttons.get_licence')" />
                                 </form>
                              </div>
                           @else
                              <form method="post" action="{{ route('project_generate_licence', ['id' => $project->id]) }}">
                                 {{ csrf_field() }}

                                 <div class="col-12">
                                    <p>@lang('dashboard.overview.no_licence')</p>
                                 </div>

                                 <div class="col-4 empty"></div>
                                 <div class="col-4">
                                    <div class="form-group required">
                                       <input type="text" id="signatory-phone" name="signatory_phone" class="phone-number medium" value="{{ old('signatory_phone', Auth::user()->phone_mobile) }}"/>

                                       @if( $errors->has('signatory_phone') )
                                          <p class="form-error">{{ $errors->first('signatory_phone') }}</p>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-4 empty"></div>

                                 <div class="col-12">
                                    <input type="submit" class="blue small" value="@lang('buttons.generate_licence')" />
                                 </div>
                              </form>
                           @endif

                        @elseif( $completion['amount'] < 100 )
                           {{-- Project not completed --}}

                           <div class="col-12">
                              <p>@lang('dashboard.overview.completion_percentage', ['amount' => $completion['amount']])</p>

                              <div class="progress-bar">
                                 <div class="fill" style="width: {{ $completion['amount'] }}%;"></div>
                              </div>

                              @if( $completion['amount'] > 60 )
                                 <div class="missing-fields">
                                    <h3>@lang('dashboard.overview.missing_fields')</h3>

                                    @foreach( $completion['missing'] as $section => $fields )
                                       <div class="section">
                                          <div class="section-title">@lang('dashboard.project.'. $section)</div>

                                          <ul>
                                             @foreach( $fields as $field )
                                                <li>@lang('dashboard.overview.fields.' . $section . '.' . $field)</li>
                                             @endforeach
                                          </ul>
                                       </div>
                                    @endforeach
                                 </div>
                              @endif

                              <a href="{{ route('project_edit', ['id' => $project->id, 'step' => 'synthesis']) }}" class="button blue">@lang('buttons.edit_project')</a>
                           </div>

                        @elseif( !$project->hasDurations() )
                           {{-- Durations not set --}}

                           <div class="col-12">
                              <p>@lang('dashboard.overview.durations_missing')</p>

                              <a href="{{ route('project_steering', ['id' => $project->id]) }}" class="button blue">@lang('buttons.update_steering')</a>
                           </div>

                        @elseif( !$project->confirmed )
                           {{-- Project unconfirmed --}}

                           <div class="col-12">
                              @lang('dashboard.overview.request_validation')

                              <form method="post" action="{{ route('request_validation', ['id' => $project->id]) }}">
                                 {{ csrf_field() }}
                                 <input type="submit" class="blue" value="@lang('buttons.request_validation')" />
                              </form>
                           </div>

                        @endif

                     @else
                        {{-- User is not admin --}}

                        <div class="col-12">
                           <p>@lang('dashboard.overview.not_running')</p>

                           <a href="{{ route('project_view', ['id' => $project->id, 'step' => 'synthesis']) }}" class="button blue">@lang('buttons.view_project')</a>
                        </div>

                     @endif

                  @else

                     {{--
                     |--------------------------------------------------------------------------
                     | Project is locked
                     |--------------------------------------------------------------------------
                     --}}

                     @if( !$project->confirmed )
                        {{-- Project unconfirmed --}}

                        <div class="col-12">
                           <p>@lang('dashboard.overview.unconfirmed')</p>

                           <a href="{{ route('project_view', ['id' => $project->id, 'step' => 'synthesis']) }}" class="button blue">@lang('buttons.view_project')</a>
                        </div>

                     @elseif( !$project->getOriginal('start_date') )
                        {{-- Project ready to start --}}

                        @if( $projectRole === 'admin' || $projectRole === 'representative' )
                           {{-- User is admin --}}

                           <section>
                              <div class="row">
                                 <div class="col-12">
                                    <p>@lang('dashboard.overview.completed')</p>

                                    <a href="{{ route('project_match_making', ['id' => $project->id]) }}" class="button blue">@lang('buttons.search_investors')</a>
                                 </div>
                              </div>
                           </section>

                           <section>
                              <div class="row">
                                 <div class="col-12 align-center">
                                    <form method="post" action="{{ route('project_unlock' , ['id' => $project->id]) }}">
                                       {{ csrf_field() }}

                                       <p>@lang('dashboard.overview.unlock_warning')</p>
                                       <p><input type="submit" class="red button small" value="@lang('dashboard.overview.unlock_project')" /></p>
                                       <p>@lang('dashboard.overview.warning')</p>
                                    </form>
                                 </div>
                              </div>
                           </section>

                        @else
                           {{-- User is not admin --}}

                           <div class="col-12">
                              <p>@lang('dashboard.overview.ready')</p>

                              <a href="{{ route('project_view', ['id' => $project->id, 'step' => 'synthesis']) }}" class="button blue">@lang('buttons.view_project')</a>
                           </div>

                        @endif

                     @else
                        {{-- Project running --}}

                        <section>
                           <div id="project-timeline" class="col-12">
                              <div class="row">
                                 <div class="start-date">@lang('dashboard.steering.project_real_start_date') {{ date('d/m/Y', strtotime($project->start_date)) }}</div>
                                 <div class="end-date">@lang('dashboard.steering.project_end_date') {{ date('d/m/Y', strtotime($project->end_date)) }}</div>
                              </div>

                              <div class="timeline">
                                 <div class="step" style="width: {{ ($project->step1_duration / $project->duration) * 100 }}%;">
                                    <div class="fill"></div>
                                    <div class="title">@lang('dashboard.steering.step1')</div>
                                 </div>
                                 <div class="step" style="width: {{ ($project->step2_duration / $project->duration) * 100 }}%;">
                                    <div class="fill"></div>
                                    <div class="title">@lang('dashboard.steering.step2')</div>
                                 </div>
                                 <div class="step" style="width: {{ ($project->step3_duration / $project->duration) * 100 }}%;">
                                    <div class="fill"></div>
                                    <div class="title">@lang('dashboard.steering.step3')</div>
                                 </div>
                                 <div class="step" style="width: {{ ($project->step4_duration / $project->duration) * 100 }}%;">
                                    <div class="fill"></div>
                                    <div class="title">@lang('dashboard.steering.step4')</div>
                                 </div>

                                 <div class="cursor step-{{ $project->current_step }}" style="left: {{ ($project->completion < 100) ? $project->completion : 100 }}%;"></div>
                                 <div class="mask{{ $project->completion === 0 ? ' full' : '' }}" style="width: {{ 100 - $project->completion }}%;"></div>
                              </div>
                           </div>
                        </section>

                        @if( $project->selected_matches->count() > 0 )
                           <section>
                              <div class="col-12 align-center">
                                 <h3>@lang('dashboard.overview.matches_list')</h3>
                                 <p>@lang('dashboard.overview.document_annex')<a href="{{ route('project_view', ['projectId' => $project->id, 'step' => 'annex']) }}">Documents.</a></p>
                              </div>

                              <div class="matches row">
                                 @foreach( $project->selected_matches as $match )
                                    <div class="col-4">
                                       <a href="{{ route('match_overview', ['id' => $match->id]) }}">
                                          <div class="match shadow-box selectable{{ $match->ended_at ? ' ended' : '' }}">
                                             @if( $match->matchable_type === 'strategy' )
                                                <h3 title="{{ $match->matchable->company->name }}">{{ $match->matchable->company->name }}</h3>

                                                @if( $match->matchable->name !== $match->matchable->company->name )
                                                   <h4 title="{{ $match->matchable->name }}">{{ $match->matchable->name }}</h4>
                                                @else
                                                   <h4>&nbsp;</h4>
                                                @endif
                                             @else
                                                <h3 title="{{ $match->matchable->full_name }}">{{ $match->matchable->full_name }}</h3>
                                                <h4>&nbsp;</h4>
                                             @endif

                                             <div class="steps">
                                                <div class="step teaser">
                                                   <p>@lang('dashboard.match_overview.teaser_1')</p>
                                                   @if( $match->viewed )
                                                      <span class="icon icon-check"></span>
                                                   @elseif( !$match->viewed && $match->declined )
                                                      <span class="icon icon-delete"></span>
                                                   @else
                                                      <span class="icon icon-dot"></span>
                                                   @endif
                                                </div>
                                                <div class="step teaser">
                                                   <p>@lang('dashboard.match_overview.teaser_2')</p>
                                                   @if( $match->accepted )
                                                      <span class="icon icon-check"></span>
                                                   @elseif( $match->viewed && $match->declined )
                                                      <span class="icon icon-delete"></span>
                                                   @else
                                                      <span class="icon icon-dot"></span>
                                                   @endif
                                                </div>
                                             </div>

                                             <div class="steps">
                                                @if( $project->need_nda )
                                                   <div class="step">
                                                      <p>@lang('dashboard.match_overview.nda')</p>
                                                      <span class="icon icon-{{ $match->hasSignedNda() ? 'check' : 'dot' }}"></span>
                                                   </div>
                                                @endif
                                                <div class="step">
                                                   <p>@lang('dashboard.match_overview.loi')</p>
                                                   @if( $match->loi_accepted )
                                                      <span class="icon icon-check"></span>
                                                   @elseif( !$match->loi_accepted && !$match->isRunning() )
                                                      <span class="icon icon-delete"></span>
                                                   @else
                                                      <span class="icon icon-dot{{ $match->loi_id ? ' uploaded' : '' }}"></span>
                                                   @endif
                                                </div>
                                                <div class="step">
                                                   <p>@lang('dashboard.match_overview.offer')</p>
                                                   @if( $match->binding_offer_accepted )
                                                      <span class="icon icon-check"></span>
                                                   @elseif( !$match->binding_offer_accepted && !$match->isRunning() )
                                                      <span class="icon icon-delete"></span>
                                                   @else
                                                      <span class="icon icon-dot{{ $match->binding_offer_id ? ' uploaded' : '' }}"></span>
                                                   @endif
                                                </div>
                                             </div>

                                             <div class="last-activity">
                                                @php $lastEvent = $match->events->first(); @endphp

                                                @if( $lastEvent )
                                                   {{ $lastEvent->date }}<br />

                                                   <strong>@lang('dashboard.match_overview.events.' . $lastEvent->description, $lastEvent->initiator ? ['initiator' => $lastEvent->initiator] : [])</strong>
                                                @else
                                                   @lang('dashboard.overview.no_activity')<br />
                                                   &nbsp;
                                                @endif
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 @endforeach
                              </div>
                           </section>
                        @else
                           <section>
                              <div class="col-12 align-center">
                                 <p>@lang('dashboard.overview.no_selection')</p>
                              </div>
                           </section>
                        @endif

                        @if( ($projectRole === 'admin' || $projectRole === 'representative') && !$project->stopped )
                           <a href="{{ route('project_matching_results', ['id' => $project->id]) }}" class="button blue small">@lang('buttons.search_investors_again')</a>
                        @endif

                     @endif

                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
