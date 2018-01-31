<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Overview
   |--------------------------------------------------------------------------
   --}}
   <section>
      <div class="row">
         <div class="col-12 align">
            <h2>@lang('fields.project.business_plan.overview')</h2>

            {{-- Recap --}}
            <div class="form-group">
               <table class="table">
                  <tr>
                     <th>&nbsp;</th>
                     @for( $i=0; $i<5; $i++ )
                        <th class="align-right">{{ $project->creation_year+$i }}</th>
                     @endfor
                  </tr>

                  {{-- Turnover --}}
                  <tr>
                     <td>@lang('fields.project.elements.turnover')</td>
                     @for( $i=0; $i<5; $i++ )
                        @php $attr = 'turnover_p_'.$i; @endphp
                        <td class="align-right">
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     @endfor
                  </tr>

                  {{-- Gross margin --}}
                  <tr>
                     <td>@lang('fields.project.elements.gross_margin')</td>
                     @for( $i=0; $i<5; $i++ )
                        @php $attr = 'gross_margin_p_'.$i; @endphp
                        <td class="align-right">
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     @endfor
                  </tr>

                  {{-- EBITDA --}}
                  <tr>
                     <td>@lang('fields.project.elements.ebitda')</td>
                     @for( $i=0; $i<5; $i++ )
                        @php $attr = 'ebitda_p_'.$i; @endphp
                        <td class="align-right">
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     @endfor
                  </tr>

                  {{-- EBIT --}}
                  <tr>
                     <td>@lang('fields.project.elements.ebit')</td>
                     @for( $i=0; $i<5; $i++ )
                        @php $attr = 'ebit_p_'.$i; @endphp
                        <td class="align-right">
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     @endfor
                  </tr>

                  {{-- Net profit --}}
                  <tr>
                     <td>@lang('fields.project.elements.net_profit')</td>
                     @for( $i=0; $i<5; $i++ )
                        @php $attr = 'net_profit_p_'.$i; @endphp
                        <td class="align-right">
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     @endfor
                  </tr>
               </table>
            </div>

            @if( $project->getField('development_plan_explanation') )
               <div class="form-group">
                  {!! nl2br($project->getField('development_plan_explanation')) !!}
               </div>
            @endif

            @php $businessPlan = $project->getDocument('business_plan_presentation'); @endphp
            @if( $businessPlan )
               <div class="form-group files">
                  <label>@lang('fields.project.business_plan.business_plan_presentation')</label>
                  <a class="button small red" href="{{ route('serve_document', ['id' => $businessPlan->id]) }}" target="_blank">{{ $businessPlan->name }}</a>
               </div>
            @endif
         </div>
      </div>
   </section>

   {{--
   |--------------------------------------------------------------------------
   | Sales variation
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('sales_variation') )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.business_plan.sales_variation')</h2>

               <div class="form-group">
                  {!! nl2br($project->getField('sales_variation')) !!}
               </div>
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Profitability evolution
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('gross_margin_variation') || $project->getField('cost_variation') )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.business_plan.profitability_evolution')</h2>

               @if( $project->getField('gross_margin_variation') )
                  <div class="form-group">
                     <label>@lang('fields.project.business_plan.gross_margin_variation')</label>
                     {!! nl2br($project->getField('gross_margin_variation')) !!}
                  </div>
               @endif

               @if( $project->getField('cost_variation') )
                  <div class="form-group">
                     <label>@lang('fields.project.business_plan.cost_variation')</label>
                     {!! nl2br($project->getField('cost_variation')) !!}
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Use of funds
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('use_of_funds') )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.business_plan.use_of_funds')</h2>

               <div class="form-group">
                  {!! nl2br($project->getField('use_of_funds')) !!}
               </div>
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('business_plan_misc_documents'); @endphp
   @if( $project->getField('business_plan_misc') || $miscDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('project.various_info')</h2>

               @if( $project->getField('business_plan_misc') )
                  <div class="form-group">
                     {!! nl2br($project->getField('business_plan_misc')) !!}
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
</div>
