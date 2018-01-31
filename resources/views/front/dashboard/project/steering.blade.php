@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.steering'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/steering.js') }}"></script>
@endsection

@section('content')
   <div id="project-steering">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel{{ $warning && ($projectRole === 'admin' || $projectRole === 'representative') ? ' with-alert' : '' }}">
               @if( $warning && ($projectRole === 'admin' || $projectRole === 'representative') )
                  @include('front.dashboard.partials.warning', ['message' => trans('dashboard.steering.durations_warning')])
               @endif

               <div class="container">
                  @if( session('success_message') )
                     @include('front.dashboard.project.form.partials.success_message')
                  @endif

                  @if( count($errors) > 0 )
                     @include('front.dashboard.project.form.partials.error_message', ['message' => $project->locked ? trans('dashboard.steering.update_previous_steps_error') : trans('dashboard.project.update_error')])
                  @endif

                  <div class="col-12">
                     <h1>@lang('dashboard.steering.title')</h1>
                  </div>

                  <section>
                     <form method="post" action="{{ route('project_update_steering', ['id' => $project->id]) }}">
                        {{ csrf_field() }}

                        <div class="row">
                           <div class="col-12 align-center">
                              <div id="project-timeline">
                                 <div class="row">
                                    @if( $project->getOriginal('start_date') )
                                       <div class="start-date">@lang('dashboard.steering.project_real_start_date') <span>{{ date('d/m/Y', strtotime($project->start_date)) }}</span></div>
                                    @else
                                       <div class="start-date">@lang('dashboard.steering.project_start_date') <span>{{ date('d/m/Y', strtotime($project->start_date)) }}</span></div>
                                    @endif
                                    <div class="end-date">@lang('dashboard.steering.project_end_date') <span>{{ date('d/m/Y', strtotime($project->end_date)) }}</span></div>
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
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div id="steps" class="row">
                           <div class="col-6">
                              <div class="step step-1">
                                 <div class="step-title">
                                    <label for="step1-duration">@lang('dashboard.steering.step1')</label>
                                    <p>@lang('dashboard.steering.step1_description')</p>
                                 </div>

                                 @if( !$project->locked && ($projectRole === 'admin' || $projectRole === 'representative') )
                                    <div class="slider-wrapper row">
                                       <div class="slider" data-input="step1-duration"></div>
                                       <div class="slider-value"><span>{{ $project->step1_duration }}</span> @choice('common.day', 2, [])</div>

                                       <input type="hidden" id="step1-duration" name="step1_duration" min="20" max="120" value="{{ $project->step1_duration }}" readonly />
                                    </div>
                                 @else
                                    <div class="slider-value">{{ $project->step1_duration }} @choice('common.day', 2, [])</div>
                                 @endif
                              </div>

                              <div class="step step-2">
                                 <div class="step-title">
                                    <label for="step2-duration">@lang('dashboard.steering.step2')</label>
                                    <p>@lang('dashboard.steering.step2_description')</p>
                                 </div>

                                 @if( !$project->locked && ($projectRole === 'admin' || $projectRole === 'representative') )
                                    <div class="slider-wrapper row">
                                       <div class="slider" data-input="step2-duration"></div>
                                       <div class="slider-value"><span>{{ $project->step2_duration }}</span> @choice('common.day', 2, [])</div>

                                       <input type="hidden" id="step2-duration" name="step2_duration" min="2" max="30" value="{{ $project->step2_duration }}" readonly />
                                    </div>
                                 @else
                                    <div class="slider-value">{{ $project->step2_duration }} @choice('common.day', 2, [])</div>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="step step-3">
                                 <div class="step-title">
                                    <label for="step1-duration">@lang('dashboard.steering.step3')</label>
                                    <p>@lang('dashboard.steering.step3_description')</p>
                                 </div>

                                 @if( !$project->locked && ($projectRole === 'admin' || $projectRole === 'representative') )
                                    <div class="slider-wrapper row">
                                       <div class="slider" data-input="step3-duration"></div>
                                       <div class="slider-value"><span>{{ $project->step3_duration }}</span> @choice('common.day', 2, [])</div>

                                       <input type="hidden" id="step3-duration" name="step3_duration" min="20" max="120" value="{{ $project->step3_duration }}" readonly />
                                    </div>
                                 @else
                                    <div class="slider-value">{{ $project->step3_duration }} @choice('common.day', 2, [])</div>
                                 @endif
                              </div>

                              <div class="step step-4">
                                 <div class="step-title">
                                    <label for="step2-duration">@lang('dashboard.steering.step4')</label>
                                    <p>@lang('dashboard.steering.step4_description')</p>
                                 </div>

                                 @if( !$project->locked && ($projectRole === 'admin' || $projectRole === 'representative') )
                                    <div class="slider-wrapper row">
                                       <div class="slider" data-input="step4-duration"></div>
                                       <div class="slider-value"><span>{{ $project->step4_duration }}</span> @choice('common.day', 2, [])</div>

                                       <input type="hidden" id="step4-duration" name="step4_duration" min="20" max="120" value="{{ $project->step4_duration }}" readonly />
                                    </div>
                                 @else
                                    <div class="slider-value">{{ $project->step4_duration }} @choice('common.day', 2, [])</div>
                                 @endif
                              </div>
                           </div>
                        </div>

                        @if( !$project->locked && ($projectRole === 'admin' || $projectRole === 'representative') )
                           <div class="row">
                              <div class="col-12 align-center">
                                 <p class="hint">@lang('dashboard.steering.steps_hint')</p>

                                 <input type="submit" class="blue" value="@lang('buttons.submit')" />
                              </div>
                           </div>
                        @endif
                     </form>
                  </section>

                  @if( ($projectRole === 'admin' || $projectRole === 'representative') && !$project->locked )
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('dashboard.steering.loi_requirements')</h2>

                              <form method="post" action="{{ route('project_loi_requirements', ['id' => $project->id]) }}">
                                 {{ csrf_field() }}

                                 <ul id="loi-requirements" class="recursive-list">
                                    @php $selectedRequirements = $project->loi_requirements()->pluck('loi_requirement_id')->toArray(); @endphp

                                    @foreach( $loiRequirements as $requirement )
                                       {!! $requirement->recursiveList('loi-requirements', 'loi_requirements[]', old('loi_requirements', $selectedRequirements)) !!}
                                    @endforeach
                                 </ul>

                                 <div class="align-center">
                                    <input type="submit" class="blue" value="@lang('buttons.submit')" />
                                 </div>
                              </form>
                           </div>
                        </div>
                     </section>
                  @elseif( $project->loi_requirements->count() > 0 )
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('dashboard.steering.loi_requirements')</h2>

                              @include('front.dashboard.partials.loi_requirements', ['loiRequirements' => $loiRequirements, 'selectedRequirements' => $project->loi_requirements])
                           </div>
                        </div>
                     </section>
                  @endif
                  @if( $project->getOriginal('start_date') && !$project->stopped )
                     <section>
                        <div class="col-12 align-center">
                           <div class="button red small" id="cancel-project">@lang('buttons.project_cancel')</div>
                        </div>
                     </section>
                     @include('front.partials.cancel_project_popup')
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
