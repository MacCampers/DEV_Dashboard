<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Overview
   |--------------------------------------------------------------------------
   --}}
   <section>
      <div class="row">
         <div class="col-12">
            <h2>@lang('fields.project.elements.overview')</h2>

            {{-- Recap --}}
            <div class="form-group">
               <table class="table">
                  <tr>
                     <th>&nbsp;</th>
                     @for( $i=3; $i>0; $i-- )
                        <th class="align-right">{{ $project->creation_year-$i }}</th>
                     @endfor
                  </tr>

                  {{-- Turnover --}}
                  <tr>
                     <td>@lang('fields.project.elements.turnover')</td>
                     @for( $i=3; $i>0; $i-- )
                        @php $attr = 'turnover_m_'.$i; @endphp
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
                     @for( $i=3; $i>0; $i-- )
                        @php $attr = 'gross_margin_m_'.$i; @endphp
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
                     @for( $i=3; $i>0; $i-- )
                        @php $attr = 'ebitda_m_'.$i; @endphp
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
                     @for( $i=3; $i>0; $i-- )
                        @php $attr = 'ebit_m_'.$i; @endphp
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
                     @for( $i=3; $i>0; $i-- )
                        @php $attr = 'net_profit_m_'.$i; @endphp
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

            @if( $project->getField('company_involved_in_transaction') )
               <div class="form-group">
                  <label>@lang('project.elements.company_involved_in_transaction')</label>
                  {!! nl2br($project->getField('company_involved_in_transaction')) !!}
               </div>
            @endif

            @if( $project->getField('accounts_explanation') )
               <div class="form-group">
                  <label>@lang('project.elements.accounts_explanation')</label>
                  {!! nl2br($project->getField('accounts_explanation')) !!}
               </div>
            @endif

            @if( $project->has_account )
               <div class="form-group">
                  <table class="table">
                     <tr>
                        <th colspan="2" class="align-center">@lang('project.elements.accounts')</th>
                     </tr>

                     @for( $i=1; $i<=3; $i++ )
                        @php $accountDocuments = $project->getDocuments('account_m_'. $i .'_documents'); @endphp

                        <tr>
                           <td width="150">@lang('fields.project.elements.account_year', ['year' => ($project->creation_year-$i)])</td>
                           <td>
                              @if( $accountDocuments->count() > 0 )
                                 @foreach( $accountDocuments as $document )
                                    <a class="button small red" href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a>
                                 @endforeach
                              @else
                                 <div class="button small disabled">@lang('common.missing')</div>
                              @endif
                           </td>
                        </tr>
                     @endfor
                  </table>
               </div>
            @else
               @php $lastReports = $project->getDocuments('last_report_documents'); @endphp

               <div class="form-group files">
                  <label>@lang('fields.last_reporting')</label>
                  @foreach( $lastReports as $lastReport )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $lastReport->id]) }}" target="_blank">{{ $lastReport->name }}</a>
                  @endforeach
               </div>
            @endif

            @if( $project->getField('financial_organization') )
               <div class="form-group">
                  <label>@lang('project.elements.financial_organization')</label>
                  {!! nl2br($project->getField('financial_organization')) !!}
               </div>
            @endif
         </div>
      </div>
   </section>

   {{--
   |--------------------------------------------------------------------------
   | Turnover
   |--------------------------------------------------------------------------
   --}}
   <section>
      <div class="row">
         <div class="col-12">
            <h2>@lang('fields.project.elements.turnover')</h2>

            @if( $project->getField('turnover_description') )
               <div class="form-group">
                  <label>@lang('fields.project.elements.turnover_description')</label>
                  {!! nl2br($project->getField('turnover_description')) !!}
               </div>
            @endif

            <div class="form-group">
               <table class="table small">
                  <tr>
                     <th colspan="2" class="align-center">@lang('fields.project.elements.turnover')</th>
                  </tr>

                  @for( $i=1; $i<=3; $i++ )
                     @php $attr = 'turnover_m_'.$i; @endphp

                     <tr>
                        <td>{{ $project->creation_year-$i }}</td>
                        <td>
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     </tr>
                  @endfor
               </table>
            </div>

            @if( $project->getField('turnover_explanation') )
               <div class="form-group">
                  <label>@lang('fields.project.elements.turnover_explanation')</label>
                  {!! nl2br($project->getField('turnover_explanation')) !!}
               </div>
            @endif

            @php $turnoverDocuments = $project->getDocuments('elements_turnover_documents'); @endphp
            @if( $turnoverDocuments->count() > 0 )
               <div class="form-group files">
                  <label>@choice('fields.attached_documents', $turnoverDocuments->count())</label>

                  @foreach( $turnoverDocuments as $document )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a>
                  @endforeach
               </div>
            @endif
         </div>
      </div>
   </section>

   {{--
   |--------------------------------------------------------------------------
   | Gross margin
   |--------------------------------------------------------------------------
   --}}
   @php $marginDocuments = $project->getDocuments('elements_margin_documents'); @endphp
   @if( $project->getField('gross_margin_description') || $project->getField('gross_margin_explanation') || $project->gross_margin_m_1 || $project->gross_margin_m_2 || $project->gross_margin_m_3 || $marginDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.elements.gross_margin')</h2>

               @if( $project->getField('gross_margin_description') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.gross_margin_description')</label>
                     {!! nl2br($project->getField('gross_margin_description')) !!}
                  </div>
               @endif

               <div class="form-group">
                  <table class="table small">
                     <tr>
                        <th colspan="2" class="align-center">@lang('fields.project.elements.gross_margin')</th>
                     </tr>

                     @for( $i=1; $i<=3; $i++ )
                        @php $attr = 'gross_margin_m_'.$i; @endphp

                        <tr>
                           <td>{{ $project->creation_year-$i }}</td>
                           <td>
                              @if( $project->$attr !== null )
                                 {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                              @else
                                 <span class="missing">@lang('common.missing')</span>
                              @endif
                           </td>
                        </tr>
                     @endfor
                  </table>
               </div>

               @if( $project->getField('gross_margin_explanation') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.gross_margin_explanation')</label>
                     {!! nl2br($project->getField('gross_margin_explanation')) !!}
                  </div>
               @endif

               @if( $marginDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $marginDocuments->count())</label>

                     @foreach( $marginDocuments as $document )
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
   | EBITDA
   |--------------------------------------------------------------------------
   --}}
   <section>
      <div class="row">
         <div class="col-12">
            <h2>@lang('fields.project.elements.ebitda')</h2>

            <div class="form-group">
               <table class="table small">
                  <tr>
                     <th colspan="2" class="align-center">@lang('fields.project.elements.ebitda')</th>
                  </tr>

                  @for( $i=1; $i<=3; $i++ )
                     @php $attr = 'ebitda_m_'.$i; @endphp

                     <tr>
                        <td>{{ $project->creation_year-$i }}</td>
                        <td>
                           @if( $project->$attr !== null )
                              {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                           @else
                              <span class="missing">@lang('common.missing')</span>
                           @endif
                        </td>
                     </tr>
                  @endfor
               </table>
            </div>

            @if( $project->getField('ebitda_explanation') )
               <div class="form-group">
                  <label>@lang('fields.project.elements.ebitda_explanation')</label>
                  {!! nl2br($project->getField('ebitda_explanation')) !!}
               </div>
            @endif

            @php $ebitdaDocuments = $project->getDocuments('elements_ebitda'); @endphp
            @if( $ebitdaDocuments->count() > 0 )
               <div class="form-group files">
                  <label>@choice('fields.attached_documents', $ebitdaDocuments->count())</label>

                  @foreach( $ebitdaDocuments as $document )
                     <a class="button small red" href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a>
                  @endforeach
               </div>
            @endif
         </div>
      </div>
   </section>

   {{--
   |--------------------------------------------------------------------------
   | EBIT
   |--------------------------------------------------------------------------
   --}}
   @php $ebitDocuments = $project->getDocuments('elements_ebit_documents'); @endphp
   @if( $project->getField('ebit_explanation') || $project->ebit_m_1 || $project->ebit_m_2 || $project->ebit_m_3 || $ebitDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.elements.ebit')</h2>

               <div class="form-group">
                  <table class="table small">
                     <tr>
                        <th colspan="2" class="align-center">@lang('fields.project.elements.ebit')</th>
                     </tr>

                     @for( $i=1; $i<=3; $i++ )
                        @php $attr = 'ebit_m_'.$i; @endphp

                        <tr>
                           <td>{{ $project->creation_year-$i }}</td>
                           <td>
                              @if( $project->$attr !== null )
                                 {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                              @else
                                 <span class="missing">@lang('common.missing')</span>
                              @endif
                           </td>
                        </tr>
                     @endfor
                  </table>
               </div>

               @if( $project->getField('ebit_explanation') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.ebit_explanation')</label>
                     {!! nl2br($project->getField('ebit_explanation')) !!}
                  </div>
               @endif

               @if( $ebitDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $ebitDocuments->count())</label>

                     @foreach( $ebitDocuments as $document )
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
   | Net profit
   |--------------------------------------------------------------------------
   --}}
   @php $netProfitDocuments = $project->getDocuments('elements_net_profit_documents'); @endphp
   @if( $project->net_profit_m_1 || $project->net_profit_m_2 || $project->net_profit_m_3 || $project->getField('net_profit_explanation') || $netProfitDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.elements.net_profit')</h2>

               <div class="form-group">
                  <table class="table small">
                     <tr>
                        <th colspan="2" class="align-center">@lang('fields.project.elements.net_profit')</th>
                     </tr>

                     @for( $i=1; $i<=3; $i++ )
                        @php $attr = 'net_profit_m_'.$i; @endphp

                        <tr>
                           <td>{{ $project->creation_year-$i }}</td>
                           <td>
                              @if( $project->$attr !== null )
                                 {{ number_format($project->$attr, 0, ',', ' ') . ' ' . $project->currency_symbol }}
                              @else
                                 <span class="missing">@lang('common.missing')</span>
                              @endif
                           </td>
                        </tr>
                     @endfor
                  </table>
               </div>

               @if( $project->getField('net_profit_explanation') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.net_profit_explanation')</label>
                     {!! nl2br($project->getField('net_profit_explanation')) !!}
                  </div>
               @endif

               @if( $netProfitDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $netProfitDocuments->count())</label>

                     @foreach( $netProfitDocuments as $document )
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
   | Current trading
   |--------------------------------------------------------------------------
   --}}
   @if( $project->getField('last_reporting_elements') || $project->getField('current_budget_confidence') || $project->getField('short_term_perspectives') || $project->getField('other_elements') )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.elements.current_trading')</h2>

               @if( $project->getField('last_reporting_elements') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.last_reporting_elements')</label>
                     {!! nl2br($project->getField('last_reporting_elements')) !!}
                  </div>
               @endif

               @if( $project->getField('current_budget_confidence') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.current_budget_confidence')</label>
                     {!! nl2br($project->getField('current_budget_confidence')) !!}
                  </div>
               @endif

               @if( $project->getField('short_term_perspectives') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.short_term_perspectives')</label>
                     {!! nl2br($project->getField('short_term_perspectives')) !!}
                  </div>
               @endif

               @if( $project->getField('other_elements') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.other_elements')</label>
                     {!! nl2br($project->getField('other_elements')) !!}
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Balance sheet
   |--------------------------------------------------------------------------
   --}}
   @php $reviewDocuments = $project->getDocuments('elements_review_documents'); @endphp
   @if( $project->getField('wcr_description') || $project->getField('off_balance_sheet_items') || $project->getField('balance_sheet_explanation') || $project->getField('cash_and_debts') || $reviewDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.elements.review')</h2>

               @if( $project->getField('wcr_description') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.wcr_description')</label>
                     {!! nl2br($project->getField('wcr_description')) !!}
                  </div>
               @endif

               @if( $project->getField('off_balance_sheet_items') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.off_balance_sheet_items')</label>
                     {!! nl2br($project->getField('off_balance_sheet_items')) !!}
                  </div>
               @endif

               @if( $project->getField('cash_and_debts') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.cash_and_debts')</label>
                     {!! nl2br($project->getField('cash_and_debts')) !!}
                  </div>
               @endif

               @if( $project->getField('balance_sheet_explanation') )
                  <div class="form-group">
                     <label>@lang('fields.project.elements.balance_sheet_explanation')</label>
                     {!! nl2br($project->getField('balance_sheet_explanation')) !!}
                  </div>
               @endif

               @if( $reviewDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $reviewDocuments->count())</label>

                     @foreach( $reviewDocuments as $document )
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
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('elements_misc_documents'); @endphp
   @if( $project->getField('elements_misc') || $miscDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('project.various_info')</h2>

               @if( $project->getField('elements_misc') )
                  <div class="form-group">
                     {!! nl2br($project->getField('elements_misc')) !!}
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
