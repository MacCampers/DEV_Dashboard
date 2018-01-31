{{-- <div class="summary">
   <div id="summary-project">
      <ol>
         <li><a href="#C1">@lang('fields.project.list.business_plan')</a></li>
         <li><a href="#C2">@lang('fields.project.elements.turnover')</a></li>
         <li><a href="#C3">@lang('fields.project.elements.gross_margin')</a></li>
         <li><a href="#C4">@lang('fields.project.list.ebitda')</a></li>
         <li><a href="#C5">@lang('fields.project.list.ebit')</a></li>
         <li><a href="#C6">@lang('fields.project.list.net_income')</a></li>
         <li><a href="#C7">@lang('fields.project.list.sales')</a></li>
         <li><a href="#C8">@lang('fields.project.list.profitability')</a></li>
         <li><a href="#C9">@lang('fields.project.business_plan.use_of_funds')</a></li>
         <li><a href="#C10">@lang('fields.project.synthesis.various')</a></li>
      </ol>
   </div>
</div> --}}
<form id="project-form" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'business_plan']) }}" data-section="business_plan" autocomplete="off" enctype="multipart/form-data" />
   {{ csrf_field() }}

   <div class="container">
      @if( session('success_message') )
         @include('front.dashboard.project.form.partials.success_message')
      @endif

      @if( count($errors) > 0 )
         @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
      @endif

      {{--
      |--------------------------------------------------------------------------
      | Overview
      |--------------------------------------------------------------------------
      --}}
      <section id="C1">
         <div class="row">
            <div class="col-6 lg-12 align-right float-right">
               @include('front.dashboard.partials.switch')
            </div>

            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.overview')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('development_plan_explanation') ? ' has-error' : '' }}">
                  <label for="development-plan-explanation">@lang('fields.project.business_plan.development_plan_explanation')</label>
                  <textarea id="development-plan-explanation" maxlength="5000</span></span>" name="development_plan_explanation" placeholder="@lang('fields.project.business_plan.development_plan_explanation_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('development_plan_explanation', $project->getField('development_plan_explanation')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></span></div>

                  @if( $errors->has('development_plan_explanation') )
                     <p class="form-error">{{ $errors->first('development_plan_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>
         <div class="optional">
            <div class="row">
               <div class="col-8 lg-12">
                  <div class="form-group{{ $errors->has('business_plan_presentation') ? ' has-error' : '' }}">
                     <label for="business-plan-presentation-documents">@lang('fields.project.business_plan.business_plan_presentation')</label>
                     <div class="hint">@lang('fields.project.business_plan.upload_plan_presentation')<br />@lang('fields.document_mimes')</div>

                     <div class="single-file row">
                        @php $businessPlan = $project->getDocument('business_plan_presentation'); @endphp

                        @if( $businessPlan )
                           <div class="file-input">
                              <input type="file" id="business-plan-presentation" class="uploaded" name="business_plan_presentation" data-id="{{ $businessPlan->id }}" disabled />
                              <label for="business-plan-presentation" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $businessPlan->id]) }}" target="_blank">{{ $businessPlan->name }}</a></label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @else
                           <div class="file-input">
                              <input type="file" id="business-plan-presentation" name="business_plan_presentation" />
                              <label for="business-plan-presentation" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @endif
                     </div>

                     @if( $errors->has('business_plan_presentation') )
                        <p class="form-error">{{ $errors->first('business_plan_presentation') }}</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Turnover forecast
      |--------------------------------------------------------------------------
      --}}
      <section id="C2">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.turnover_forecast')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=0; $i<5; $i++ )
               @php $attr = 'turnover_p_'.$i; @endphp

               <div class="col-4 lg-6 m-12">
                  <div class="form-group{{ $i < 1 ? ' required' : ' optional' }}{{ $errors->has('turnover_p_'.$i) ? ' has-error' : '' }}">
                     <label for="turnover-p-{{ $i }}">@lang('fields.project.business_plan.turnover_n_year', ['year' => $project->creation_year+$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="turnover-p-{{ $i }}" class="autonumeric" name="turnover_p_{{ $i }}" value="{{ old('turnover_p_'.$i, $project->$attr) }}"{{ ($project->locked && $i === 0) ? ' disabled' : '' }} />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>

                     @if( $errors->has('turnover_p_'.$i) )
                        <p class="form-error">{{ $errors->first('turnover_p_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Gross margin forecast
      |--------------------------------------------------------------------------
      --}}
      <section id="C3" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.gross_margin_forecast')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=0; $i<5; $i++ )
               @php $attr = 'gross_margin_p_'.$i; @endphp

               <div class="col-4 lg-6 m-12">
                  <div class="form-group{{ $errors->has('gross_margin_p_'.$i) ? ' has-error' : '' }}">
                     <label for="gross-margin-p-{{ $i }}">@lang('fields.project.business_plan.gross_margin_n_year', ['year' => $project->creation_year+$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="gross-margin-p-{{ $i }}" class="autonumeric" name="gross_margin_p_{{ $i }}" value="{{ old('gross_margin_p_'.$i, $project->$attr) }}" />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>
                     @if( $errors->has('gross_margin_p_'.$i) )
                        <p class="form-error">{{ $errors->first('gross_margin_p_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | EBITDA forecast
      |--------------------------------------------------------------------------
      --}}
      <section id="C4">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.ebitda_forecast')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=0; $i<5; $i++ )
               @php $attr = 'ebitda_p_'.$i; @endphp

               <div class="col-4 lg-6 m-12">
                  <div class="form-group{{ $i < 1 ? ' required' : ' optional' }}{{ $errors->has('ebitda_p_'.$i) ? ' has-error' : '' }}">
                     <label for="ebitda-p-{{ $i }}">@lang('fields.project.business_plan.ebitda_n_year', ['year' => $project->creation_year+$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="ebitda-p-{{ $i }}" class="autonumeric" name="ebitda_p_{{ $i }}" value="{{ old('ebitda_p_'.$i, $project->$attr) }}"{{ ($project->locked && $i === 0) ? ' disabled' : '' }} />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>

                     @if( $errors->has('ebitda_p_'.$i) )
                        <p class="form-error">{{ $errors->first('ebitda_p_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | EBIT forecast
      |--------------------------------------------------------------------------
      --}}
      <section id="C5">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.ebit_forecast')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=0; $i<5; $i++ )
               @php $attr = 'ebit_p_'.$i; @endphp

               <div class="col-4 lg-6 m-12">
                  <div class="form-group{{ $i < 1 ? ' required' : ' optional' }}{{ $errors->has('ebit_p_'.$i) ? ' has-error' : '' }}">
                     <label for="ebit-p-{{ $i }}">@lang('fields.project.business_plan.ebit_n_year', ['year' => $project->creation_year+$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="ebit-p-{{ $i }}" class="autonumeric" name="ebit_p_{{ $i }}" value="{{ old('ebit_p_'.$i, $project->$attr) }}"{{ ($project->locked && $i === 0) ? ' disabled' : '' }} />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>

                     @if( $errors->has('ebit_p_'.$i) )
                        <p class="form-error">{{ $errors->first('ebit_p_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Net profit forecast
      |--------------------------------------------------------------------------
      --}}
      <section id="C6" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.net_profit_forecast')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=0; $i<5; $i++ )
               @php $attr = 'net_profit_p_'.$i; @endphp

               <div class="col-4 lg-6 m-12">
                  <div class="form-group{{ $errors->has('net_profit_p_'.$i) ? ' has-error' : '' }}">
                     <label for="net-profit-p-{{ $i }}">@lang('fields.project.business_plan.net_profit_n_year', ['year' => $project->creation_year+$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="net-profit-p-{{ $i }}" class="autonumeric" name="net_profit_p_{{ $i }}" value="{{ old('net_profit_p_'.$i, $project->$attr) }}" />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>

                     @if( $errors->has('net_profit_p_'.$i) )
                        <p class="form-error">{{ $errors->first('net_profit_p_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Sales variation
      |--------------------------------------------------------------------------
      --}}
      <section id="C7">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.sales_variation')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('sales_variation') ? ' has-error' : '' }}">
                  <label for="sales-variation">@lang('fields.project.business_plan.sales_variation')</label>
                  <div class="hint">@lang('fields.project.business_plan.sales_variation_subtitles')</div>
                  <textarea id="sales-variation" maxlength="5000</span>" name="sales_variation" placeholder="@lang('fields.project.business_plan.sales_variation')"{{ $project->locked ? ' disabled' : '' }}>{{ old('sales_variation', $project->getField('sales_variation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('sales_variation') )
                     <p class="form-error">{{ $errors->first('sales_variation') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Profitability evolution
      |--------------------------------------------------------------------------
      --}}
      <section id="C8">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.profitability_evolution')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('gross_margin_variation') ? ' has-error' : '' }}">
                  <label for="gross-margin-variation">@lang('fields.project.business_plan.gross_margin_variation')</label>
                  <div class="hint">@lang('fields.project.business_plan.gross_margin_variation_subtitles')</div>
                  <textarea id="gross-margin-variation" maxlength="5000</span>" name="gross_margin_variation" placeholder="@lang('fields.project.business_plan.gross_margin_variation')"{{ $project->locked ? ' disabled' : '' }}>{{ old('gross_margin_variation', $project->getField('gross_margin_variation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('gross_margin_variation') )
                     <p class="form-error">{{ $errors->first('gross_margin_variation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('cost_variation') ? ' has-error' : '' }}">
                  <label for="cost-variations">@lang('fields.project.business_plan.cost_variation')</label>
                  <div class="hint">@lang('fields.project.business_plan.cost_variation_hint')</div>
                  <textarea id="cost-variations" maxlength="5000</span>" name="cost_variation" placeholder="@lang('fields.project.business_plan.cost_variation')"{{ $project->locked ? ' disabled' : '' }}>{{ old('cost_variation', $project->getField('cost_variation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('cost_variation') )
                     <p class="form-error">{{ $errors->first('cost_variation') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Use of funds
      |--------------------------------------------------------------------------
      --}}
      <section id="C9">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.business_plan.use_of_funds')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('use_of_funds') ? ' has-error' : '' }}">
                  <label for="use-of-funds">@lang('fields.project.business_plan.investment_details')</label>
                  <div class="hint">@lang('fields.project.business_plan.investment_details_subtitles')</div>
                  <textarea id="use-of-funds" maxlength="5000</span>" name="use_of_funds" placeholder="@lang('fields.project.business_plan.investment_details')"{{ $project->locked ? ' disabled' : '' }}>{{ old('use_of_funds', $project->getField('use_of_funds'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('use_of_funds') )
                     <p class="form-error">{{ $errors->first('use_of_funds') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Various
      |--------------------------------------------------------------------------
      --}}
      <section id="C10" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.synthesis.various')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('business_plan_misc') ? ' has-error' : '' }}">
                  <label for="business-plan-misc">@lang('fields.project.business_plan.various_info')</label>
                  <textarea id="business-plan-misc" maxlength="5000</span>" name="business_plan_misc" placeholder="@lang('fields.project.business_plan.misc_data')">{{ old('business_plan_misc', $project->getField('business_plan_misc')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('business_plan_misc') )
                     <p class="form-error">{{ $errors->first('business_plan_misc') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="col-12">
            <div class="form-group{{ $errors->has('business_plan_misc_documents') ? ' has-error' : '' }}">
               <label for="business-plan-misc-documents">@lang('fields.attach_document')</label>
               <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

               <div class="files-group row" data-max="5">
                  @php $miscDocuments = $project->getDocuments('business_plan_misc_documents'); @endphp
                  @foreach( $miscDocuments as $document )
                     <div class="file-input">
                        <input type="file" id="business-plan-misc-documents-{{ $loop->index }}" class="uploaded" name="business_plan_misc_documents[]" data-id="{{ $document->id }}" disabled />
                        <label for="business-plan-misc-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                        <div class="delete-file icon-delete"></div>
                     </div>
                  @endforeach

                  @if( $miscDocuments->count() < 5 )
                     <div class="file-input">
                        <input type="file" id="business-plan-misc-documents-{{ $miscDocuments->count() }}" name="business_plan_misc_documents[]" />
                        <label for="business-plan-misc-documents-{{ $miscDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                        <div class="delete-file icon-delete"></div>
                     </div>
                  @endif
               </div>

               @if( $errors->has('business_plan_misc_documents') )
                  <p class="form-error">{{ $errors->first('business_plan_misc_documents') }}</p>
               @endif
            </div>
         </div>
      </section>


      <section>
         <div class="row">
            <div class="col-12 align-center">
               <input type="hidden" id="files-to-remove" name="files_to_remove" value="" />

               <input type="submit" class="blue button-save" value="@lang('buttons.save')" />
            </div>

            <div class="col-12 align-center">
               <a class="link" href="{{ route('project_preview', ['id' => $project->id, 'step' => 'business_plan']) }}" target="_blank">@lang('buttons.preview')</a>
            </div>
         </div>
      </section>
   </div>
</form>
