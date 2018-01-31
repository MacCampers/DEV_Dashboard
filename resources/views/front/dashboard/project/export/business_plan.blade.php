<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Overview
   |--------------------------------------------------------------------------
   --}}
   <section>
      <h2>@lang('fields.project.business_plan.overview')</h2>

      <section>
         {{-- Recap --}}
         <table class="table">
            <tr>
               <th>&nbsp;</th>
               @for( $i=0; $i<5; $i++ )
                  <th class="align-right">{{ $project->creation_year+$i }}</th>
               @endfor
            </tr>

            {{-- Turnover --}}
            <tr>
               <td class="align-left">@lang('fields.project.elements.turnover')</td>
               @for( $i=0; $i<5; $i++ )
                  @php $attr = 'turnover_p_'.$i; @endphp
                  <td class="align-right">
                     @if( $project->$attr )
                        {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                     @else
                        <span class="missing">@lang('common.missing')</span>
                     @endif
                  </td>
               @endfor
            </tr>

            {{-- Gross margin --}}
            <tr>
               <td class="align-left">@lang('fields.project.elements.gross_margin')</td>
               @for( $i=0; $i<5; $i++ )
                  @php $attr = 'gross_margin_p_'.$i; @endphp
                  <td class="align-right">
                     @if( $project->$attr )
                        {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                     @else
                        <span class="missing">@lang('common.missing')</span>
                     @endif
                  </td>
               @endfor
            </tr>

            {{-- EBITDA --}}
            <tr>
               <td class="align-left">@lang('fields.project.elements.ebitda')</td>
               @for( $i=0; $i<5; $i++ )
                  @php $attr = 'ebitda_p_'.$i; @endphp
                  <td class="align-right">
                     @if( $project->$attr )
                        {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                     @else
                        <span class="missing">@lang('common.missing')</span>
                     @endif
                  </td>
               @endfor
            </tr>

            {{-- EBIT --}}
            <tr>
               <td class="align-left">@lang('fields.project.elements.ebit')</td>
               @for( $i=0; $i<5; $i++ )
                  @php $attr = 'ebit_p_'.$i; @endphp
                  <td class="align-right">
                     @if( $project->$attr )
                        {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                     @else
                        <span class="missing">@lang('common.missing')</span>
                     @endif
                  </td>
               @endfor
            </tr>

            {{-- Net profit --}}
            <tr>
               <td class="align-left">@lang('fields.project.elements.net_profit')</td>
               @for( $i=0; $i<5; $i++ )
                  @php $attr = 'net_profit_p_'.$i; @endphp
                  <td class="align-right">
                     @if( $project->$attr )
                        {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                     @else
                        <span class="missing">@lang('common.missing')</span>
                     @endif
                  </td>
               @endfor
            </tr>
         </table>
      </section>

      @if( $project->getField('development_plan_explanation') )
         <div class="group">
            <label>@lang('fields.project.business_plan.development_plan_explanation')</label>
            <p>{!! nl2br($project->getField('development_plan_explanation')) !!}</p>
         </div>
      @endif
   </section>

   {{--
   |--------------------------------------------------------------------------
   | Sales variation
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('sales_variation') )
      <section>
         <h2>@lang('fields.project.business_plan.sales_variation')</h2>

         <div class="group">
            <p>{!! nl2br($project->getField('sales_variation')) !!}</p>
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
         <h2>@lang('fields.project.business_plan.profitability_evolution')</h2>

         @if( $project->getField('gross_margin_variation') )
            <div class="group">
               <label>@lang('fields.project.business_plan.gross_margin_variation')</label>
               <p>{!! nl2br($project->getField('gross_margin_variation')) !!}</p>
            </div>
         @endif

         @if( $project->getField('cost_variation') )
            <div class="group">
               <label>@lang('fields.project.business_plan.cost_variation')</label>
               <p>{!! nl2br($project->getField('cost_variation')) !!}</p>
            </div>
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Use of funds
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('use_of_funds') )
      <section>
         <h2>@lang('fields.project.business_plan.use_of_funds')</h2>

         <div class="group">
            <p>{!! nl2br($project->getField('use_of_funds')) !!}</p>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('business_plan_misc'); @endphp
   @if( $project->getField('business_plan_misc') || $miscDocuments->count() > 0 )
      <section>
         <h2>@lang('project.various_info')</h2>

         @if( $project->getField('business_plan_misc') )
            <div class="group">
               <p>{!! nl2br($project->getField('business_plan_misc')) !!}</p>
            </div>
         @endif

         @if( $miscDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $miscDocuments->count())</label>

               @foreach( $miscDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>
         @endif
      </section>
   @endif
</div>
