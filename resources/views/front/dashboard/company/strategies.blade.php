@extends('front.layout.dashboard')

@section('title', trans('fields.company'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/parameters.js') }}"></script>
@endsection

@section('content')
   <div id="parameters">
      <div id="projects">
         <div class="container">
            <div class="col-12">
               <div class="panel">
                  @include('front.dashboard.company.nav')

                  <div class="container">
                     <section>
                        <div class="row">
                           @if( $company->confirmed )
                              <div class="col-12 align-center">
                                 <p>@lang('parameters.company.strategies.subtitle')</p>
                              </div>
                           @endif
                           @if( $company->strategies->count() > 0 )
                              @foreach( $company->strategies as $strategy )
                                 <div class="col-12">
                                    <div class="strategy shadow-box">
                                       <h3>{{ $strategy->name }}</h3>
                                       @if( !$strategy->amount_max )
                                          <p>@lang('parameters.company.strategies.ticket_from', ['from' => number_format(($strategy->amount_min * 1000), 0, ',', '&nbsp;').' €'])</p>
                                       @elseif( !$strategy->amount_min )
                                          <p>@lang('parameters.company.strategies.ticket_to', ['to' => number_format(($strategy->amount_max * 1000), 0, ',', '&nbsp;').' €'])</p>
                                       @else
                                          <p>@lang('parameters.company.strategies.ticket_from_to', ['from' => number_format(($strategy->amount_min * 1000), 0, ',', '&nbsp;').' €', 'to' => number_format(($strategy->amount_max * 1000), 0, ',', '&nbsp').' €'])</p>
                                       @endif
                                       <p class="result-separator"><strong>@lang('parameters.company.strategies.locations')</strong>
                                          @foreach ($strategy->locations as $location)
                                             @if( !$loop->last )
                                                {{ $location->name }},
                                             @else
                                                {{ $location->name }}
                                             @endif
                                          @endforeach
                                       </p>
                                       <p class="result-separator"><strong>@lang('parameters.company.strategies.investment_zones')</strong>
                                          @foreach ($strategy->investment_zones as $investment)
                                             @if( !$loop->last )
                                                {{ $investment->name }},
                                             @else
                                                {{ $investment->name }}
                                             @endif
                                          @endforeach
                                       </p>
                                       <p class="result-separator"><strong>@lang('parameters.company.strategies.operation_type')</strong>
                                          @foreach ($strategy->development_stages as $dev)
                                             @if( !$loop->last )
                                                {{ $dev->name }},
                                             @else
                                                {{ $dev->name }}
                                             @endif
                                          @endforeach
                                       </p>
                                       <p class="result-separator"><strong>@lang('parameters.company.strategies.official_activity_areas')</strong>
                                          @foreach ($strategy->official_activity_areas as $officials)
                                             @if( !$loop->last )
                                                {{ $officials->name }},
                                             @else
                                                {{ $officials->name }}
                                             @endif
                                          @endforeach
                                       </p>
                                       <div class="align-center">
                                          <a href="{{ route('company_request_strategy_update', ['id' => $strategy->id]) }}" class="button blue small">@lang('buttons.edit_strategy')</a>
                                       </div>
                                    </div>
                                 </div>
                              @endforeach
                           @elseif( !Auth::user()->confirmed || !$company->confirmed )
                              <div class="col-12 align-center">
                                 <p>@lang('parameters.company.strategies.empty')</p>
                              </div>
                           @endif

                           @if( Auth::user()->confirmed && $company->confirmed )
                              <div class="col-12 align-center">
                                 <a href="{{ route('company_request_strategy_creation') }}">
                                    <div class="new strategy shadow-box">
                                       <div class="text">
                                          <img src="{{ asset('img/dashboard/plus_icon.png') }}" width="32" height="32" alt="+" />
                                          <p>@lang('buttons.add_strategy')</p>
                                       </div>
                                    </div>
                                 </a>
                              </div>
                           @endif
                        </div>
                     </section>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
