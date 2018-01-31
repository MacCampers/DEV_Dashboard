@php $count = 0; @endphp
<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Company
   |--------------------------------------------------------------------------
   --}}
   @if( ($project->company_name && $project->company_address_1 && $project->company_zipcode && $project->company_city && $project->company_country->name) || $project->company_registration_number || $project->representative || $project->representative_first_name || $project->representative_last_name || $project->activity_areas->count() > 0 )
      <section>
         <h2>@lang('fields.project.synthesis.identification')</h2>

         @if( $project->company_name && $project->company_address_1 && $project->company_zipcode && $project->company_city && $project->company_country->name )
            <div class="group">
               <strong>{{ $project->company_name }}</strong><br />
               <p>
                  {{ $project->company_address_1 }}<br />
                  {!! $project->company_address_2 ? $project->company_address_2.'<br />' : '' !!}
                  {{ $project->company_zipcode }} {{ $project->company_city }}<br />
                  {{ $project->company_country->name }}
               </p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->company_registration_number )
            <div class="group">
               <label>@lang('fields.registration_number')</label>
               <p>{{ $project->company_registration_number }}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->activity_areas->count() > 0 )
            <div class="group">
               <label>@choice('project.synthesis.activity_areas', $project->activity_areas->count())</label>
               <ul>
                  @foreach( $project->activity_areas as $activityArea )
                     <li>{{ $activityArea->name }}</li>
                  @endforeach
               </ul>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->representative || $project->representative_first_name || $project->representative_last_name )
            <div class="group">
               <label>@lang('project.synthesis.representative')</label>

               <p>
                  @if( $project->representative )
                     <strong>{{ $project->representative->full_name }}</strong>, {{ $project->representative_status ? $project->representative_status : ''}}<br />
                     @if( $project->representative->email )
                        @lang('fields.email') : {{ $project->representative->email }}<br />
                     @endif
                     @if( $project->representative->phone_mobile )
                        @lang('fields.phone_mobile') : {{ $project->representative->phone_mobile }}
                     @endif
                  @else
                     <strong>{{ $project->representative_first_name }} {{ $project->representative_last_name }}</strong>, {{ $project->representative_status ? ($project->representative_status) : ''}}<br />
                     @if( $project->representative_email )
                        @lang('fields.email') : {{ $project->representative_email }}<br />
                     @endif
                     @if( $project->representative_phone )
                        @lang('fields.phone_mobile') : {{ $project->representative_phone }}
                     @endif
                  @endif
               </p>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Project type
   |--------------------------------------------------------------------------
   --}}
   @if( $project->company_name || $project->type ||  $$project->social_impact || $project->development_stage->count() > 0 )
      <section>
         <h2>@lang('fields.project.synthesis.type')</h2>

         <div class="group">
            @if( $project->type === 'fundraising' )
               <label>@lang('project.synthesis.fundraising', ['company' => $project->company_name, 'amount' => number_format($project->amount_searched, 0, ',', ' ') .' '. $project->currency_symbol])</label>
               <p>{!! nl2br($project->getField('fundraising_objective')) !!}</p>

               @php $count++; @endphp
            @elseif( $project->type === 'handover' )
               <label>@lang('project.synthesis.handover', ['company' => $project->company_name])</label>
               <p>{!! nl2br($project->getField('handover_objective')) !!}</p>

               @if( $project->dilution )
                  <p>@lang('project.synthesis.majority')</p>
               @endif
               @if( $project->mbi )
                  <p>@lang('project.synthesis.mbi')</p>
               @endif
               @if( $project->industrial_merge )
                  <p>@lang('project.synthesis.industrial_merge')</p>
               @endif

               @php $count++; @endphp
            @endif
         </div>

         @if( $project->development_stage )
            <div class="group">
               <label>@lang('fields.project.synthesis.development_stage')</label>
               <p>{{ $project->development_stage->name }}</p>
            </div>
         @endif

         @if( $project->social_impact )
            <p>@lang('project.synthesis.social_impact')</p>
         @else
            <p>@lang('project.synthesis.no_social_impact')</p>
         @endif

         <?php /*
         @if( $project->valuation_expected_min || $project->valuation_expected_max )
         <div class="form-group">
         @if( $project->valuation_expected_min && $project->valuation_expected_max )
         @lang('project.synthesis.valuation_expected_between', ['min' => number_format($project->valuation_expected_min, 0, ',', ' ') .' '. $project->currency_symbol, 'max' => number_format($project->valuation_expected_max, 0, ',', ' ') .' '. $project->currency_symbol])
         @elseif( $project->valuation_expected_min && !$project->valuation_expected_max )
         @lang('project.synthesis.valuation_expected_from', ['min' => number_format($project->valuation_expected_min, 0, ',', ' ') .' '. $project->currency_symbol])
         @else
         @lang('project.synthesis.valuation_expected_max', ['max' => number_format($project->valuation_expected_max, 0, ',', ' ') .' '. $project->currency_symbol])
         @endif
         </div>
         @endif
         */ ?>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Legal documents
   |--------------------------------------------------------------------------
   --}}
   @php $kbis = $project->getDocument('kbis'); @endphp
   @php $statutes = $project->getDocument('statutes'); @endphp
   @php $shareholdAgreement = $project->getDocument('sharehold_agreement'); @endphp
   @if( $kbis || $statutes || $shareholdAgreement )
      <section>
         <h2>@lang('fields.project.structure.legal_documents')</h2>

         @if( $kbis )
            <div class="group">
               <label>@lang('project.structure.kbis')</label>
               <div class="document">{{ $kbis->name }}</div>
            </div>

            @php $count++; @endphp
         @endif

         @if( $statutes )
            <div class="group">
               <label>@lang('project.structure.statutes')</label>
               <div class="document">{{ $statutes->name }}</div>
            </div>

            @php $count++; @endphp
         @endif

         @if( $shareholdAgreement )
            <div class="group">
               <label>@lang('project.structure.sharehold_agreement')</label>
               <div class="document">{{ $shareholdAgreement->name }}</div>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | History
   |--------------------------------------------------------------------------
   --}}
   @if( $project->company_creation_date || $project->events->count() > 0 )
      <section>
         <h2>@lang('fields.project.synthesis.history')</h2>

         @if( $project->company_creation_date )
            <div class="group">
               <p>@lang('project.synthesis.company_creation_date', ['date' => date('d/m/Y', strtotime($project->company_creation_date))])</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->events->count() > 0 )
            <div class="group">
               <label>@lang('project.synthesis.events')</label>

               <ol class="timeline">
                  @foreach( $project->events as $event )
                     <li class="event">
                        <div class="event-name">{{ $event->name }}</div>
                        <div class="event-date">{{ $event->date }}</div>
                        <p>{!! nl2br($event->description) !!}</p>
                     </li>
                  @endforeach
               </ol>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | SWOT
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('swot_strengths') || $project->getField('swot_weaknesses') || $project->getField('swot_opportunities') || $project->getField('swot_threats') )
      <section>
         <h2>@lang('fields.project.synthesis.swot')</h2>

         @if( $project->getField('swot_strengths') )
            <div class="group">
               <label>@lang('fields.project.synthesis.strengths')</label>
               <p>{!! nl2br($project->getField('swot_strengths')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('swot_weaknesses') )
            <div class="group">
               <label>@lang('fields.project.synthesis.weaknesses')</label>
               <p>{!! nl2br($project->getField('swot_weaknesses')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('swot_opportunities') )
            <div class="group">
               <label>@lang('fields.project.synthesis.opportunities')</label>
               <p>{!! nl2br($project->getField('swot_opportunities')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('swot_threats') )
            <div class="group">
               <label>@lang('fields.project.synthesis.threats')</label>
               <p>{!! nl2br($project->getField('swot_threats')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('synthesis_misc'); @endphp
   @if( $project->getField('synthesis_misc') || $miscDocuments->count() > 0 )
      <section>
         <h2>@lang('project.various_info')</h2>

         @if( $project->getField('synthesis_misc') )
            <div class="group">
               <p>{!! nl2br($project->getField('synthesis_misc')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $miscDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $miscDocuments->count())</label>
               @foreach( $miscDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   @if( $count === 0 )
      <p>@lang('fields.no_information_given')</p>
   @endif
</div>
