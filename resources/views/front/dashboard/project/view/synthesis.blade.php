<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Company
   |--------------------------------------------------------------------------
   --}}
   @if( ($project->company_name && $project->company_address_1 && $project->company_zipcode && $project->company_city && $project->company_country->name) || $project->company_registration_number || $project->representative || $project->representative_first_name || $project->representative_last_name || $project->activity_areas->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.identification')</h2>

               @if( $project->company_name && $project->company_address_1 && $project->company_zipcode && $project->company_city && $project->company_country->name )
                  <div class="form-group">
                     <strong>{{ $project->company_name }}</strong><br />
                     {{ $project->company_address_1 }}<br />
                     @if( $project->company_address_2 )
                        {{ $project->company_address_2 }}<br />
                     @endif
                     {{ $project->company_zipcode }} {{ $project->company_city }}<br />
                     {{ $project->company_country->name }}
                  </div>
               @endif

               @if( $project->company_registration_number )
                  <div class="form-group">
                     <label>@lang('fields.registration_number')</label>
                     {{ $project->company_registration_number }}
                  </div>
               @endif

               @if( $project->activity_areas->count() > 0 )
                  <div class="form-group">
                     <label>@choice('project.synthesis.activity_areas', $project->activity_areas->count())</label>
                     @foreach( $project->activity_areas as $activityArea )
                        {{ $activityArea->name }}<br />
                     @endforeach
                  </div>
               @endif


               @if( $project->representative || $project->representative_first_name || $project->representative_last_name )
                  <div class="form-group">
                     <label>@lang('project.synthesis.representative')</label>

                     @if( $project->representative )
                        <strong>{{ $project->representative->full_name }}</strong> ({{ $project->representative_status }})<br />
                        @lang('fields.email') : {{ $project->representative->email }}<br />
                        @lang('fields.phone_mobile') : {{ $project->representative->phone_mobile }}
                     @else
                        <strong>{{ $project->representative_first_name }} {{ $project->representative_last_name }}</strong> ({{ $project->representative_status }})<br />
                        @lang('fields.email') : {{ $project->representative_email }}<br />
                        @lang('fields.phone_mobile') : {{ $project->representative_phone }}
                     @endif
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Project type
   |--------------------------------------------------------------------------
   --}}
   @if( $project->company_name || $project->type ||  $$project->social_impact || $project->development_stage->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.type')</h2>

               @if( $project->type === 'fundraising' )
                  <div class="form-group">
                     <label>@lang('project.synthesis.fundraising', ['company' => $project->company_name, 'amount' => number_format($project->amount_searched, 0, ',', ' ') .' '. $project->currency_symbol])</label>
                     <blockquote>{!! nl2br($project->getField('fundraising_objective')) !!}</blockquote>
                  </div>
               @elseif( $project->type === 'handover' )
                  <div class="form-group">
                     <label>@lang('project.synthesis.handover', ['company' => $project->company_name])</label>
                     <blockquote>{!! nl2br($project->getField('handover_objective')) !!}</blockquote>
                  </div>

                  <div class="form-group">
                     @if( $project->dilution )
                        @lang('project.synthesis.majority')<br />
                     @endif
                     @if( $project->mbi )
                        @lang('project.synthesis.mbi')<br />
                     @endif
                     @if( $project->industrial_merge )
                        @lang('project.synthesis.industrial_merge')<br />
                     @endif
                  </div>
               @endif

               @if( $project->development_stage )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.development_stage')</label>
                     {{ $project->development_stage->name }}
                  </div>
               @endif

               <div class="form-group">
                  @if( $project->social_impact )
                     @lang('project.synthesis.social_impact')
                  @else
                     @lang('project.synthesis.no_social_impact')
                  @endif
               </div>

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
            </div>
         </div>
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
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.legal_documents')</h2>

               <div class="form-group files">
                  @if( $kbis )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $kbis->id]) }}" target="_blank">@lang('project.structure.kbis')</a>
                  @endif

                  @if( $statutes )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $statutes->id]) }}" target="_blank">@lang('project.structure.statutes')</a>
                  @endif

                  @if( $shareholdAgreement )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $shareholdAgreement->id]) }}" target="_blank">@lang('project.structure.sharehold_agreement')</a>
                  @endif
               </div>
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | History
   |--------------------------------------------------------------------------
   --}}
   @if( $project->company_creation_date || $project->events->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.history')</h2>

               @if( $project->company_creation_date )
                  <div class="form-group">
                     @lang('project.synthesis.company_creation_date', ['date' => date('d/m/Y', strtotime($project->company_creation_date))])
                  </div>
               @endif

               @if( $project->events->count() > 0 )
                  <div class="form-group">
                     <label>@lang('project.synthesis.events')</label>

                     <ol class="timeline">
                        @foreach( $project->events as $event )
                           <li class="event">
                              <div class="event-title">{{ $event->name }}</div>
                              <div class="event-date">{{ $event->date }}</div>
                              <p class="event-description">{!! nl2br($event->description) !!}</p>
                           </li>
                        @endforeach
                     </ol>
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | SWOT
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('swot_strengths') || $project->getField('swot_weaknesses') || $project->getField('swot_opportunities') || $project->getField('swot_threats') )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.swot')</h2>

               @if( $project->getField('swot_strengths') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.strengths')</label>
                     {!! nl2br($project->getField('swot_strengths')) !!}
                  </div>
               @endif

               @if( $project->getField('swot_weaknesses') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.weaknesses')</label>
                     {!! nl2br($project->getField('swot_weaknesses')) !!}
                  </div>
               @endif

               @if( $project->getField('swot_opportunities') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.opportunities')</label>
                     {!! nl2br($project->getField('swot_opportunities')) !!}
                  </div>
               @endif

               @if( $project->getField('swot_threats') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.threats')</label>
                     {!! nl2br($project->getField('swot_threats')) !!}
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('synthesis_misc_documents'); @endphp
   @if( $project->getField('synthesis_misc') || $miscDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('project.various_info')</h2>

               @if( $project->getField('synthesis_misc') )
                  <div class="form-group">
                     {!! nl2br($project->getField('synthesis_misc')) !!}
                  </div>
               @endif

               @if( $miscDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $miscDocuments->count())</label>

                     @foreach( $miscDocuments as $document )
                        <a class="button small red" href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a>
                     @endforeach
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Teasers
   |--------------------------------------------------------------------------
   --}}
   @if( Auth::guard('admin') && ($project->getField('teaser_mail') || $project->getField('teaser_welcome')) )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.teasers')</h2>

               @if( $project->getField('teaser_mail') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.teaser_mail')</label>
                     {!! nl2br($project->getField('teaser_mail')) !!}
                  </div>
               @endif

               @if( $project->getField('teaser_welcome') )
                  <div class="form-group">
                     <label>@lang('fields.project.synthesis.teaser_welcome')</label>
                     {!! nl2br($project->getField('teaser_welcome')) !!}
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif
</div>
