@extends('front.layout.dashboard')

@section('title', trans('dashboard.matching.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/match.js') }}"></script>
@endsection

@section('content')
   <div id="matching-results">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.matching.title')</h1>
                  </div>
               </div>

               @if( $strategies->count() > 0 )
                  <div class="container">
                     <div class="row">
                        <div class="col-12 align-center">
                           <div class="investors-number">@lang('dashboard.matching.investors_found')</div>

                           <div class="matching-image">
                              <div class="logo-project"><span>{{ $project->short_name }}</span></div>
                              <img class="relation" src="{{ asset('img/dashboard/relation.png')}}" width="60" alt="match with" />
                              <img src="{{ asset('img/home/investor.png')}}" width="90" alt="investor" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <section>
                     <div class="container">
                        <div class="row">
                           <div class="col-3 empty"></div>
                           <div class="col-6 align-center">
                              <p>@lang('dashboard.matching.choice')</p>
                           </div>
                        </div>
                     </div>
                  </section>

                  <div class="alert">
                     <div class="container">
                        <div class="col-12">
                           <p>@lang('dashboard.matching.warning')</p>
                        </div>
                     </div>
                  </div>

                  <section>
                     <div class="row">
                        <div class="col-1 empty"></div>
                        <div class="col-10 align-center">
                           <div class="checkbox centered">
                              <input type="checkbox" id="certified" />
                              <label for="certified" class="align-center">@lang('dashboard.matching.project_validation')</label>
                              <span class="checkmark"></span>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-4 empty"></div>
                        <div class="col-4 align-center">
                           <form method="post" action="{{ route('project_lock', ['id' => $project->id]) }}">
                              {{ csrf_field() }}
                              <input id="submit-button" type="submit" class="blue disabled" value="@lang('dashboard.matching.lock_project')" />
                           </form>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-4 empty"></div>
                        <div class="col-4 align-center">
                           <div class="cancel">
                              <a href="{{ route('project_overview', ['id' => $project->id]) }}">@lang('buttons.cancel')</a>
                           </div>
                        </div>
                     </div>
                  </section>
               @else
                  <div class="container">
                     <div class="row">
                        <div class="col-12 align-center">
                           <div class="investors-number">@lang('dashboard.matching.no_investors')</div>

                           <div class="matching-image">
                              <div class="logo-project"><span>{{ $project->short_name }}</span></div>
                              <img class="relation" src="{{ asset('img/dashboard/relation.png')}}" width="60" alt="match with" />
                              <img src="{{ asset('img/home/investor.png')}}" width="90" alt="investor" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <section class="alert">
                     <div class="container">
                        <div class="col-12">
                           <p>@lang('dashboard.matching.warning_without_investors')</p>
                        </div>
                     </div>
                  </section>

                  <section>
                     <div class="row">
                        <div class="col-4 empty"></div>
                        <div class="col-4 align-center">
                           <a href="{{ route('project_overview', ['id' => $project->id]) }}" class="button blue">@lang('buttons.edit_project')</a>
                        </div>
                     </div>
                  </section>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection
