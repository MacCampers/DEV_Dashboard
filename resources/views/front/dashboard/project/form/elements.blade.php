{{-- <div class="summary">
   <div id="summary-project">
      <ol>
         <li><a href="#C1">@lang('fields.project.elements.overview')</a></li>
         <li><a href="#C2">@lang('fields.project.elements.turnover')</a></li>
         <li><a href="#C3">@lang('fields.project.elements.gross_margin')</a></li>
         <li><a href="#C4">@lang('fields.project.list.ebitda')</a></li>
         <li><a href="#C5">@lang('fields.project.list.ebit')</a></li>
         <li><a href="#C6">@lang('fields.project.elements.net_profit')</a></li>
         <li><a href="#C7">@lang('fields.project.list.elements')</a></li>
         <li><a href="#C8">@lang('fields.project.elements.review')</a></li>
         <li><a href="#C9">@lang('fields.project.synthesis.various')</a></li>
      </ol>
   </div>
</div> --}}
<form id="project-form" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'elements']) }}" data-section="elements" autocomplete="off" enctype="multipart/form-data" />
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
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.overview')</h2>
            </div>
            <div class="col-6 lg-12 align-right">
               @include('front.dashboard.partials.switch')
            </div>
         </div>

         <?php /*<div class="row optional">
         <div class="col-12">
         <div class="form-group{{ $errors->has('company_involved_in_transaction') ? ' has-error' : '' }}">
         <label for="company-involved-in-transaction">@lang('fields.project.elements.company_involved_in_transaction')</label>
         <textarea id="company-involved-in-transaction" name="company_involved_in_transaction" placeholder="@lang('fields.project.elements.company_involved_in_transaction_placeholder')">{{ old('company_involved_in_transaction', $project->getField('company_involved_in_transaction')) }}</textarea>

         @if( $errors->has('company_involved_in_transaction') )
         <p class="form-error">{{ $errors->first('company_involved_in_transaction') }}</p>
         @endif
         </div>
         </div>
         </div> */ ?>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('accounts_explanation') ? ' has-error' : '' }}">
                  <label for="accounts-explanation">@lang('fields.project.elements.accounts_explanation')</label>
                  <div class="hint">@lang('fields.project.elements.accounts_explanation_hint')</div>
                  <textarea id="accounts-explanation" maxlength="5000" name="accounts_explanation" placeholder="@lang('fields.project.elements.accounts_explanation_placeholder')">{{ old('accounts_explanation', $project->getField('accounts_explanation')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('accounts_explanation') )
                     <p class="form-error">{{ $errors->first('accounts_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="account">
               <div class="col-12">
                  <div class="form-group">
                     <div class="checkbox with-input">
                        <input type="radio" id="has-account" name="has_account" value="1" {{ old('has_account', $project->has_account) == 1 ? ' checked' : '' }}{{ $project->locked ? ' disabled' : '' }}/>
                        <label for="has-account">@lang('fields.account')</label>
                        <span class="checkmark"></span>

                        <div class="related-inputs"{!! old('has_account', $project->has_account) == 1 ? ' style="display: block;"' : '' !!}>
                           @for( $i=1; $i<=3; $i++ )
                              <div class="col-12">
                                 <div class="form-group{{ $i === 1 ? ' required' : ' optional' }}{{ $errors->has('account_m_'. $i .'_documents') ? ' has-error' : '' }}">
                                    <label>@lang('fields.project.elements.account_year', ['year' => $project->creation_year-$i])</label>
                                    <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                                    <div class="files-group row" data-max="5">
                                       @php $accountDocuments = $project->getDocuments('account_m_' . $i . '_documents'); @endphp
                                       @foreach( $accountDocuments as $document )
                                          <div class="file-input">
                                             <input type="file" id="account-m{{ $i }}-document-{{ $loop->index }}" class="uploaded" name="account_m_{{ $i }}_documents[]" data-id="{{ $document->id }}" disabled />
                                             <label for="account-m{{ $i }}-document-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                                             <div class="delete-file icon-delete"></div>
                                          </div>
                                       @endforeach

                                       @if( $accountDocuments->count() < 5 )
                                          <div class="file-input">
                                             <input type="file" id="account-m{{ $i }}-document-{{ $accountDocuments->count() }}" name="account_m_{{ $i }}_documents[]" />
                                             <label for="account-m{{ $i }}-document-{{ $accountDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                                             <div class="delete-file icon-delete"></div>
                                          </div>
                                       @endif
                                    </div>

                                    @if( $errors->has('account_m_'. $i .'_documents') )
                                       <p class="form-error">{{ $errors->first('account_m_'. $i .'_documents') }}</p>
                                    @endif
                                 </div>
                              </div>
                           @endfor
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="account">
               <div class="col-12">
                  <div class="form-group">
                     <div class="checkbox with-input">
                        <input type="radio" id="no-account" name="has_account" value="0"{{ old('has_account', $project->has_account) == 0 ? ' checked' : '' }}{{ $project->locked ? ' disabled' : '' }} />
                        <label for="no-account">@lang('fields.no_account')</label>
                        <span class="checkmark"></span>

                        <div class="related-inputs"{!! old('has_account', $project->has_account) == 0 ? ' style="display: block;"' : '' !!}>
                           <div class="col-12">
                              <div class="form-group required{{ $errors->has('last_report_documents') ? ' has-error' : '' }}">
                                 <label>@lang('fields.last_reporting')</label>
                                 <div class="hint">@lang('fields.last_reporting_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                                 <div class="files-group row" data-max="5">
                                    @php $miscDocuments = $project->getDocuments('last_report_documents'); @endphp
                                    @foreach( $miscDocuments as $document )
                                       <div class="file-input">
                                          <input type="file" id="last-report-documents-{{ $loop->index }}" class="uploaded" name="last_report_documents[]" data-id="{{ $document->id }}" disabled />
                                          <label for="last-report-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                                          <div class="delete-file icon-delete"></div>
                                       </div>
                                    @endforeach

                                    @if( $miscDocuments->count() < 5 )
                                       <div class="file-input">
                                          <input type="file" id="last-report-documents-{{ $miscDocuments->count() }}" name="last_report_documents[]" />
                                          <label for="last-report-documents-{{ $miscDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                                          <div class="delete-file icon-delete"></div>
                                       </div>
                                    @endif
                                 </div>

                                 @if( $errors->has('last_report_documents') )
                                    <p class="form-error">{{ $errors->first('last_report_documents') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('financial_organization') ? ' has-error' : '' }}">
                  <label for="financial-organization">@lang('fields.project.elements.financial_organization')</label>
                  <div class="hint">@lang('fields.project.elements.financial_organization_hint')</div>
                  <textarea id="financial-organization" maxlength="5000" name="financial_organization" placeholder="@lang('fields.project.elements.financial_organization')">{{ old('financial_organization', $project->getField('financial_organization')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('financial_organization') )
                     <p class="form-error">{{ $errors->first('financial_organization') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Turnover
      |--------------------------------------------------------------------------
      --}}
      <section id="C2">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.turnover')</h2>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('turnover_description') ? ' has-error' : '' }}">
                  <label for="turnover-description">@lang('fields.project.elements.turnover_description')</label>
                  <textarea id="turnover-description" maxlength="5000" name="turnover_description" placeholder="@lang('fields.project.elements.turnover_description_hint')">{{ old('turnover_description', $project->getField('turnover_description'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('turnover_description') )
                     <p class="form-error">{{ $errors->first('turnover_description') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            @for( $i=1; $i<=3; $i++ )
               @php $attr = 'turnover_m_'.$i; @endphp

               <div class="col-4 lg-12">
                  <div class="form-group{{ $errors->has('turnover_m_'.$i) ? ' has-error' : '' }}{{ $i === 1 ? ' required' : ' optional' }}">
                     <label for="turnover-m-{{ $i }}">@lang('fields.project.elements.turnover_year', ['year' => $project->creation_year-$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="turnover-m-{{ $i }}" class="autonumeric" name="turnover_m_{{ $i }}" value="{{ old('turnover_m_'.$i, $project->$attr) }}" {{ ($project->locked && $i === 1) ? ' disabled' : '' }} />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>
                     @if( $errors->has('turnover_m_'.$i) )
                        <p class="form-error">{{ $errors->first('turnover_m_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('turnover_explanation') ? ' has-error' : '' }}">
                  <label for="turnover-explanation">@lang('fields.project.elements.turnover_explanation')</label>
                  <textarea id="turnover-explanation" maxlength="5000" name="turnover_explanation" placeholder="@lang('fields.project.elements.turnover_explanation')">{{ old('turnover_explanation', $project->getField('turnover_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('turnover_explanation') )
                     <p class="form-error">{{ $errors->first('turnover_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{$errors->has('elements_turnover_documents') ? ' has-error' : '' }}">
                  <label for="elements-turnover-documents">@lang('fields.project.elements.upload_turnover')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>
                  <div class="files-group row" data-max="5">
                     @php $turnoverDocuments = $project->getDocuments('elements_turnover_documents'); @endphp
                     @foreach( $turnoverDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-turnover-documents-{{ $loop->index }}" class="uploaded" name="elements_turnover_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-turnover-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $turnoverDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-turnover-documents-{{ $turnoverDocuments->count() }}" name="elements_turnover_documents[]" />
                           <label for="elements-turnover-documents-{{ $turnoverDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_turnover_documents') )
                     <p class="form-error">{{ $errors->first('elements_turnover_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Gross margin
      |--------------------------------------------------------------------------
      --}}
      <section id="C3" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.gross_margin')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('gross_margin_description') ? ' has-error' : '' }}">
                  <label for="gross-margin-description">@lang('fields.project.elements.gross_margin_description')</label>
                  <textarea id="gross-margin-description" maxlength="5000" name="gross_margin_description" placeholder="@lang('fields.project.elements.gross_margin_description_hint')">{{ old('gross_margin_description', $project->getField('gross_margin_description'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('gross_margin_description') )
                     <p class="form-error">{{ $errors->first('gross_margin_description') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            @for( $i=1; $i<=3; $i++ )
               @php $attr = 'gross_margin_m_'.$i; @endphp

               <div class="col-4 lg-12">
                  <div class="form-group{{ $errors->has('gross_margin_m_'.$i) ? ' has-error' : '' }}">
                     <label for="gross-margin-{{ $i }}">@lang('fields.project.elements.gross_margin_year', ['year' => $project->creation_year-$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="gross-margin-{{ $i }}" class="autonumeric" name="gross_margin_m_{{ $i }}" value="{{ old('gross_margin_m_'.$i, $project->$attr) }}" />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>
                     @if( $errors->has('gross_margin_m_'.$i) )
                        <p class="form-error">{{ $errors->first('gross_margin_m_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('gross_margin_explanation') ? ' has-error' : '' }}">
                  <label for="gross-margin-explanation">@lang('fields.project.elements.gross_margin_explanation')</label>
                  <textarea id="gross-margin-explanation" maxlength="5000" name="gross_margin_explanation" placeholder="@lang('fields.project.elements.gross_margin_explanation')">{{ old('gross_margin_explanation', $project->getField('gross_margin_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('gross_margin_explanation') )
                     <p class="form-error">{{ $errors->first('gross_margin_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('elements_margin_documents') ? ' has-error' : '' }}">
                  <label for="elements-margin-documents">@lang('fields.project.elements.upload_margin')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $marginDocuments = $project->getDocuments('elements_margin_documents'); @endphp
                     @foreach( $marginDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-margin-documents-{{ $loop->index }}" class="uploaded" name="elements_margin_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-margin-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $marginDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-margin-documents-{{ $marginDocuments->count() }}" name="elements_margin_documents[]" />
                           <label for="elements-margin-documents-{{ $marginDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_margin_documents') )
                     <p class="form-error">{{ $errors->first('elements_margin_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | EBITDA
      |--------------------------------------------------------------------------
      --}}
      <section id="C4">
         <div class="row" optional>
            <div class="col-6 lg-12">
                  <h2>@lang('fields.project.elements.ebitda')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=1; $i<=3; $i++ )
               @php $attr = 'ebitda_m_'.$i; @endphp

               <div class="col-4 lg-12">
                  <div class="form-group{{ $errors->has('ebitda_m_'.$i) ? ' has-error' : '' }}{{ $i === 1 ? ' required': ' optional' }}">
                     <label for="ebitda-{{ $i }}">@lang('fields.project.elements.ebitda_year', ['year' => $project->creation_year-$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="ebitda-{{ $i }}" class="autonumeric" name="ebitda_m_{{ $i }}" value="{{ old('ebitda_m_'.$i, $project->$attr) }}"{{ ($project->locked && $i === 1) ? ' disabled' : '' }} />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>

                     @if( $errors->has('ebitda_m_'.$i) )
                        <p class="form-error">{{ $errors->first('ebitda_m_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('ebitda_explanation') ? ' has-error' : '' }}">
                  <label for="ebitda-explanation">@lang('fields.project.elements.ebitda_explanation')</label>
                  <textarea id="ebitda-explanation" maxlength="5000" name="ebitda_explanation" placeholder="@lang('fields.project.elements.ebitda_explanation_hint')">{{ old('ebitda_explanation', $project->getField('ebitda_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('ebitda_explanation') )
                     <p class="form-error">{{ $errors->first('ebitda_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('elements_ebitda_documents') ? ' has-error' : '' }}">
                  <label for="elements-ebitda-documents">@lang('fields.project.elements.upload_ebitda')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $ebitdaDocuments = $project->getDocuments('elements_ebitda_documents'); @endphp
                     @foreach( $ebitdaDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-ebitda-documents-{{ $loop->index }}" class="uploaded" name="elements_ebitda_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-ebitda-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $ebitdaDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-ebitda-documents-{{ $ebitdaDocuments->count() }}" name="elements_ebitda_documents[]" />
                           <label for="elements-ebitda-documents-{{ $ebitdaDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_ebitda_documents') )
                     <p class="form-error">{{ $errors->first('elements_ebitda_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | EBIT
      |--------------------------------------------------------------------------
      --}}
      <section id="C5" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.ebit')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=1; $i<=3; $i++ )
               @php $attr = 'ebit_m_'.$i; @endphp

               <div class="col-4 lg-12">
                  <div class="form-group{{ $errors->has('ebit_m_'.$i) ? ' has-error' : '' }}">
                     <label for="ebit-{{ $i }}">@lang('fields.project.elements.ebit_year', ['year' => $project->creation_year-$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="ebit-{{ $i }}" class="autonumeric" name="ebit_m_{{ $i }}" value="{{ old('ebit_m_'.$i, $project->$attr) }}"/>
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>
                     @if( $errors->has('ebit_m_'.$i) )
                        <p class="form-error">{{ $errors->first('ebit_m_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('ebit_explanation') ? ' has-error' : '' }}">
                  <label for="ebit-explanation">@lang('fields.project.elements.ebit_explanation')</label>
                  <textarea id="ebit-explanation" maxlength="5000" name="ebit_explanation" placeholder="@lang('fields.project.elements.ebit_explanation_hint')">{{ old('ebit_explanation', $project->getField('ebit_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('ebit_explanation') )
                     <p class="form-error">{{ $errors->first('ebit_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{$errors->has('elements_ebit_documents') ? ' has-error' : '' }}">
                  <label for="elements-ebit-documents">@lang('fields.project.elements.upload_ebit')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $ebitDocuments = $project->getDocuments('elements_ebit_documents'); @endphp
                     @foreach( $ebitDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-ebit-documents-{{ $loop->index }}" class="uploaded" name="elements_ebit_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-ebit-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $ebitDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-ebit-documents-{{ $ebitDocuments->count() }}" name="elements_ebit_documents[]" />
                           <label for="elements-ebit-documents-{{ $ebitDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_ebit_documents') )
                     <p class="form-error">{{ $errors->first('elements_ebit_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Net profit
      |--------------------------------------------------------------------------
      --}}
      <section id="C6" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.net_profit')</h2>
            </div>
         </div>

         <div class="row">
            @for( $i=1; $i<=3; $i++ )
               @php $attr = 'net_profit_m_'.$i; @endphp

               <div class="col-4 lg-12">
                  <div class="form-group{{ $errors->has('net_profit_m_'.$i) ? ' has-error' : '' }}">
                     <label for="net_profit-{{ $i }}">@lang('fields.project.elements.net_profit_year', ['year' => $project->creation_year-$i])</label>
                     <div class="unit-input">
                        <input autocomplete="off" type="text" id="net_profit-{{ $i }}" class="autonumeric" name="net_profit_m_{{ $i }}" value="{{ old('net_profit_m_'.$i, $project->$attr) }}" />
                        <span class="unit">{{ $project->currency_symbol }}</span>
                     </div>
                     @if( $errors->has('net_profit_m_'.$i) )
                        <p class="form-error">{{ $errors->first('net_profit_m_'.$i) }}</p>
                     @endif
                  </div>
               </div>
            @endfor
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('net_profit_explanation') ? ' has-error' : '' }}">
                  <label for="net-profit-fluctuation">@lang('fields.project.elements.net_profit_explanation')</label>
                  <textarea id="net-profit-explanation" maxlength="5000" name="net_profit_explanation" placeholder="@lang('fields.project.elements.net_profit_explanation_hint')">{{ old('net_profit_explanation', $project->getField('net_profit_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('net_profit_explanation') )
                     <p class="form-error">{{ $errors->first('net_profit_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('elements_net_profit_documents') ? ' has-error' : '' }}">
                  <label for="elements-net-profit-documents">@lang('fields.project.elements.upload_net_profit')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $netProfitDocuments = $project->getDocuments('elements_net_profit_documents'); @endphp
                     @foreach( $netProfitDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-net-profit-documents-{{ $loop->index }}" class="uploaded" name="elements_net_profit_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-net-profit-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $netProfitDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-net-profit-documents-{{ $netProfitDocuments->count() }}" name="elements_net_profit_documents[]" />
                           <label for="elements-net-profit-documents-{{ $netProfitDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_net_profit_documents') )
                     <p class="form-error">{{ $errors->first('elements_net_profit_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Current trading
      |--------------------------------------------------------------------------
      --}}
      <section id="C7" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.current_trading')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('last_reporting_elements') ? ' has-error' : '' }}">
                  <label for="last-reports">@lang('fields.project.elements.last_reporting_elements')</label>
                  <div class="hint">@lang('fields.project.elements.last_reporting_elements_hint')</div>
                  <textarea id="last-report" maxlength="5000" name="last_reporting_elements" placeholder="@lang('fields.project.elements.last_reporting_elements_placeholder')">{{ old('last_reporting_elements', $project->getField('last_reporting_elements'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('last_reporting_elements') )
                     <p class="form-error">{{ $errors->first('last_reporting_elements') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('current_budget_confidence') ? ' has-error' : '' }}">
                  <label for="current-budget-confidence">@lang('fields.project.elements.current_budget_confidence')</label>
                  <div class="hint">@lang('fields.project.elements.current_budget_confidence_hint')</div>
                  <textarea id="current-budget-confidence" maxlength="5000" name="current_budget_confidence" placeholder="@lang('fields.project.elements.current_budget_confidence')">{{ old('current_budget_confidence', $project->getField('current_budget_confidence'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('current_budget_confidence') )
                     <p class="form-error">{{ $errors->first('current_budget_confidence') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('short_term_perspectives') ? ' has-error' : '' }}">
                  <label for="short-term-perspectives">@lang('fields.project.elements.short_term_perspectives')</label>
                  <div class="hint">@lang('fields.project.elements.short_term_perspectives_hint')</div>
                  <textarea id="short-term-perspectives" maxlength="5000" name="short_term_perspectives" placeholder="@lang('fields.project.elements.short_term_perspectives_placeholder')">{{ old('short_term_perspectives', $project->getField('short_term_perspectives'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('short_term_perspectives') )
                     <p class="form-error">{{ $errors->first('short_term_perspectives') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('other_elements') ? ' has-error' : '' }}">
                  <label for="other-elements">@lang('fields.project.elements.other_elements')</label>
                  <textarea id="other-elements" maxlength="5000" name="other_elements" placeholder="@lang('fields.project.elements.other_elements')">{{ old('other_elements', $project->getField('other_elements'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('other_elements') )
                     <p class="form-error">{{ $errors->first('other_elements') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Balance sheet
      |--------------------------------------------------------------------------
      --}}
      <section id="C8" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.elements.review')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('wcr_description') ? ' has-error' : '' }}">
                  <label for="wcr-description">@lang('fields.project.elements.wcr_description')</label>
                  <div class="hint">@lang('fields.project.elements.wcr_description_hint')</div>
                  <textarea id="wcr-description" maxlength="5000" name="wcr_description" placeholder="@lang('fields.project.elements.wcr_description_placeholder')">{{ old('wcr_description', $project->getField('wcr_description'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('wcr_description') )
                     <p class="form-error">{{ $errors->first('wcr_description') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('off_balance_sheet_items') ? ' has-error' : '' }}">
                  <label for="off-balance-sheet-items">@lang('fields.project.elements.off_balance_sheet_items')</label>
                  <div class="hint">@lang('fields.project.elements.off_balance_sheet_items_hint')</div>
                  <textarea id="off-balance-sheet-items" maxlength="5000" name="off_balance_sheet_items" placeholder="@lang('fields.project.elements.off_balance_sheet_items')">{{ old('off_balance_sheet_items', $project->getField('off_balance_sheet_items'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('off_balance_sheet_items') )
                     <p class="form-error">{{ $errors->first('off_balance_sheet_items') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('cash_and_debts') ? ' has-error' : '' }}">
                  <label for="cash-and-debts">@lang('fields.project.elements.cash_and_debts')</label>
                  <textarea id="cash-and-debts" maxlength="5000" name="cash_and_debts" placeholder="@lang('fields.project.elements.cash_and_debts_hint')">{{ old('cash_and_debts', $project->getField('cash_and_debts'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('cash_and_debts') )
                     <p class="form-error">{{ $errors->first('cash_and_debts') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('balance_sheet_explanation') ? ' has-error' : '' }}">
                  <label for="balance-sheet-explanation">@lang('fields.project.elements.political_investment')</label>
                  <textarea id="balance-sheet-explanation" maxlength="5000" name="balance_sheet_explanation" placeholder="@lang('fields.project.elements.political_investment_hint')">{{ old('balance_sheet_explanation', $project->getField('balance_sheet_explanation'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('balance_sheet_explanation') )
                     <p class="form-error">{{ $errors->first('balance_sheet_explanation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{$errors->has('elements_review_documents') ? ' has-error' : '' }}">
                  <label for="elements-review-documents">@lang('fields.project.elements.upload_review')</label>
                  <div class="hint">@lang('fields.upload_misc_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $reviewDocuments = $project->getDocuments('elements_review_documents'); @endphp
                     @foreach( $reviewDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-review-documents-{{ $loop->index }}" class="uploaded" name="elements_review_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-review-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $reviewDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-review-documents-{{ $reviewDocuments->count() }}" name="elements_review_documents[]" />
                           <label for="elements-review-documents-{{ $reviewDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_review_documents') )
                     <p class="form-error">{{ $errors->first('elements_review_documents') }}</p>
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
      <section id="C9" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.synthesis.various')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('elements_misc') ? ' has-error' : '' }}">
                  <label for="elements-misc">@lang('fields.project.elements.various_info')</label>
                  <textarea id="elements-misc" maxlength="5000" name="elements_misc" placeholder="@lang('fields.project.elements.elements_misc')">{{ old('elements_misc', $project->getField('elements_misc'))}}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

                  @if( $errors->has('elements_misc') )
                     <p class="form-error">{{ $errors->first('elements_misc') }}</p>
                  @endif
               </div>

               <div class="form-group{{$errors->has('elements_misc_documents') ? ' has-error' : '' }}">
                  <label for="elements-misc-documents">@lang('fields.attach_document')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>
                  <div class="files-group row" data-max="5">
                     @php $miscDocuments = $project->getDocuments('elements_misc_documents'); @endphp
                     @foreach( $miscDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="elements-misc-documents-{{ $loop->index }}" class="uploaded" name="elements_misc_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="elements-misc-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>

                        @php $i++; @endphp
                     @endforeach

                     @if( $miscDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="elements-misc-documents-{{ $miscDocuments->count() }}" name="elements_misc_documents[]" />
                           <label for="elements-misc-documents-{{ $miscDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('elements_misc_documents') )
                     <p class="form-error">
                        {{ $errors->first('elements_misc_documents') }}
                     </p>
                  @endif
               </div>
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
               <a class="link" href="{{ route('project_preview', ['id' => $project->id, 'step' => 'elements']) }}" target="_blank">@lang('buttons.preview')</a>
            </div>
         </div>
      </section>
   </div>
</form>
