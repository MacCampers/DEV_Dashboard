{{-- <div class="summary">
   <div id="summary-project">
      <ol>
         <li><a href="#C1">@lang('fields.project.list.company')</a></li>
         <li><a href="#C2">@lang('fields.project.list.representative')</a></li>
         <li><a href="#C3">@lang('fields.project.synthesis.type')</a></li>
         <li><a href="#C4">@lang('fields.project.synthesis.history')</a></li>
         <li><a href="#C5">@lang('fields.project.synthesis.activity_areas')</a></li>
         <li><a href="#C6">@lang('fields.project.synthesis.swot')</a></li>
         <li><a href="#C7">@lang('fields.project.list.teaser')</a></li>
         <li><a href="#C8">@lang('fields.project.synthesis.various')</a></li>
      </ol>
   </div>
</div> --}}
<form id="project-form" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'synthesis']) }}" data-section="synthesis" autocomplete="off" enctype="multipart/form-data" />
   {{ csrf_field() }}

   <div class="container">
      @if( session('success_message') )
         @include('front.dashboard.project.form.partials.success_message')
      @endif

      @if( count($errors) > 0 )
         @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
      @endif

      <section>
         <div class="row">
            <div class="col-6 lg-12 align-right float-right">
               @include('front.dashboard.partials.switch')
            </div>

            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('code_name') ? ' has-error' : '' }}">
                  <label for="code-name">@lang('fields.project.synthesis.code_name')</label>
                  <div class="hint">@lang('fields.project.synthesis.code_name_hint')</div>

                  <input type="text" id="code-name" name="code_name" placeholder="@lang('fields.project.synthesis.code_name')" value="{{ old('code_name', $project->code_name) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('code_name') )
                     <p class="form-error">{{ $errors->first('code_name') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Company
      |--------------------------------------------------------------------------
      --}}
      <section id="C1">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.identification')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('company_name') ? ' has-error' : '' }}">
                  <label for="company-name">@lang('fields.project.synthesis.company_name')</label>
                  <input type="text" id="company-name" name="company_name" placeholder="@lang('fields.project.synthesis.company_name')" value="{{ old('company_name', $project->company_name) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_name') )
                     <p class="form-error">{{ $errors->first('company_name') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('company_registration_number') ? ' has-error' : '' }}">
                  <label for="company-registration-number">@lang('fields.project.synthesis.company_registration_number')</label>
                  <input type="text" id="company-registration-number" name="company_registration_number" placeholder="@lang('fields.project.synthesis.company_registration_number_hint')" value="{{ old('company_registration_number', $project->company_registration_number) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_registration_number') )
                     <p class="form-error">{{ $errors->first('company_registration_number') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('company_address_1') ? ' has-error' : '' }}">
                  <label for="company-address-1">@lang('fields.project.synthesis.company_address')</label>
                  <input type="text" id="company-address-1" name="company_address_1" placeholder="@lang('fields.project.synthesis.company_address_placeholder')" value="{{ old('company_address_1', $project->company_address_1) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_address_1') )
                     <p class="form-error">{{ $errors->first('company_address_1') }}</p>
                  @endif
               </div>
            </div>
            <div class="col-6 lg-12">
               <div class="form-group{{ $errors->has('company_address_2') ? ' has-error' : '' }}">
                  <label for="company-address-2">&nbsp;</label>
                  <input type="text" id="company-address-2" name="company_address_2" placeholder="@lang('fields.address_2')" value="{{ old('company_address_2', $project->company_address_2) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_address_2') )
                     <p class="form-error">{{ $errors->first('company_address_2') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-2 lg-4 xs-4">
               <div class="form-group required{{ $errors->has('company_zipcode') ? ' has-error' : '' }}">
                  <label for="company-zipcode">@lang('fields.zipcode')</label>
                  <input type="text" id="company-zipcode" name="company_zipcode" placeholder="@lang('fields.zipcode')" value="{{ old('company_zipcode', $project->company_zipcode) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_zipcode') )
                     <p class="form-error">{{ $errors->first('company_zipcode') }}</p>
                  @endif
               </div>
            </div>

            <div class="col-4 lg-8 xs-4">
               <div class="form-group required{{ $errors->has('company_city') ? ' has-error' : '' }}">
                  <label for="company-city">@lang('fields.city')</label>
                  <input type="text" id="company-city" name="company_city" placeholder="@lang('fields.project.synthesis.company_city')" value="{{ old('company_city', $project->company_city) }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_city') )
                     <p class="form-error">{{ $errors->first('company_city') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 m-12">
               <div class="form-group required{{ $errors->has('company_country_id') ? ' has-error' : '' }}" data-name="company_country_id">
                  <label for="company-country-id">@lang('fields.country')</label>
                  <select id="company-country-id" class="country-selector" name="company_country_id" data-regions="company-region-id" {{ $project->locked ? ' disabled' : '' }}>
                     @foreach( $countries as $country )
                        <option value="{{ $country->id }}"{{ $country->id == old('company_country_id', $project->company_country_id ? $project->company_country_id : 69) ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
                     @endforeach
                  </select>

                  @if( $errors->has('company_country_id') )
                     <p class="form-error">{{ $errors->first('company_country_id') }}</p>
                  @endif
               </div>
            </div>

            <div class="col-6 m-12">
               <div class="form-group required{{ $errors->has('company_region_id') ? ' has-error' : '' }}" data-name="company_region_id">
                  <label for="company-region-id">@lang('fields.region')</label>
                  <select id="company-region-id" class="region-selector" name="company_region_id" >
                     <option value="">@lang('fields.region_placeholder')</option>
                     @foreach( $regions as $region )
                        <option value="{{ $region->id }}"{{ $region->id == old('company_region_id', $project->company_region_id ? $project->company_region_id : null) ? ' selected' : '' }} data-country="{{ $region->parent }}" {{ $project->locked ? ' disabled' : '' }}>@lang('zones.region.'.$region->code)</option>
                     @endforeach
                  </select>

                  @if( $errors->has('company_region_id') )
                     <p class="form-error">{{ $errors->first('company_region_id') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Representative
      |--------------------------------------------------------------------------
      --}}
      <section id="C2">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.representative')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('representative_status') ? ' has-error' : '' }}">
                  <label for="user-status">@lang('fields.project.synthesis.representative_status')</label>
                  @if( $project->representative_status )
                     <input type="text" id="representative-status" name="representative_status" value="{{ $project->representative_status }}" />
                  @else
                     <input type="text" id="representative-status" name="representative_status" placeholder="@lang('fields.project.synthesis.representative_status')" value="{{ old('representative_status', $project->representative_status) }}"{{ $project->locked ? ' disabled' : '' }} />
                  @endif

                  @if( $errors->has('representative_status') )
                     <p class="form-error">{{ $errors->first('representative_status') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('representative_first_name') ? ' has-error' : '' }}">
                  <label for="user-first-name">@lang('fields.first_name')</label>
                  @if( $project->representative_id )
                     <input type="text" id="user-first-name" name="representative_first_name" value="{{ $project->representative->first_name }}" readonly />
                  @else
                     <input type="text" id="user-first-name" name="representative_first_name" placeholder="@lang('fields.first_name')" value="{{ old('representative_first_name', $project->representative_first_name) }}"{{ $project->locked ? ' disabled' : '' }}/>
                  @endif

                  @if( $errors->has('representative_first_name') )
                     <p class="form-error">{{ $errors->first('representative_first_name') }}</p>
                  @endif
               </div>
            </div>

            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('representative_last_name') ? ' has-error' : '' }}">
                  <label for="user-last-name">@lang('fields.last_name')</label>
                  @if( $project->representative_id )
                     <input type="text" id="user-last-name" name="representative_last_name" value="{{ $project->representative->last_name }}" readonly />
                  @else
                     <input type="text" id="user-last-name" name="representative_last_name" placeholder="@lang('fields.last_name')" value="{{ old('representative_last_name', $project->representative_last_name) }}"{{ $project->locked ? ' disabled' : '' }}/>
                  @endif

                  @if( $errors->has('representative_last_name') )
                     <p class="form-error">{{ $errors->first('representative_last_name') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('representative_email') ? ' has-error' : '' }}">
                  <label for="user-email">@lang('fields.email')</label>
                  @if( $project->representative_id )
                     <input type="email" id="user-email" name="representative_email" value="{{ $project->representative->email }}" readonly />
                  @else
                     <input type="email" id="user-email" name="representative_email" placeholder="@lang('fields.email')" value="{{ old('representative_email', $project->representative_email) }}"{{ $project->locked ? ' disabled' : '' }}/>
                  @endif

                  @if( $errors->has('representative_email') )
                     <p class="form-error">{{ $errors->first('representative_email') }}</p>
                  @endif
               </div>
            </div>

            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('representative_phone') ? ' has-error' : '' }}">
                  <label for="user-phone">@lang('fields.phone')</label>
                  @if( $project->representative_id )
                     <input type="text" id="user-phone" name="representative_phone" class="phone-number" value="{{ $project->representative->phone_mobile }}" readonly />
                  @else
                     <input type="text" id="user-phone" name="representative_phone" class="phone-number" value="{{ old('representative_phone', $project->representative_phone) }}"{{ $project->locked ? ' disabled' : '' }}/>
                  @endif

                  @if( $errors->has('representative_phone') )
                     <p class="form-error">{{ $errors->first('representative_phone') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Project type
      |--------------------------------------------------------------------------
      --}}
      <section id="C3">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.type')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="account">
                  <div class="form-group{{ $errors->has('amount_searched') ? ' has-error' : '' }}">
                     <div class="checkbox with-input">
                        <input type="radio" id="type-fundraising" name="project_type" value="fundraising"{{ old('project_type', $project->type) === 'fundraising' ? ' checked' : '' }} {{ $project->locked ? ' disabled' : '' }}/>
                        <label for="type-fundraising">@lang('fields.project.synthesis.fundraising')</label>
                        <span class="checkmark"></span>

                        <div class="related-inputs"{!! old('project_type', $project->type) === 'fundraising' ? ' style="display: block;"' : '' !!}>
                           <div class="col-12">
                              <div class="form-group required{{ $errors->has('fundraising_objective') ? ' has-error' : '' }}">
                                 <label for="amount-searched">@lang('fields.project.synthesis.amount_searched')</label>
                                 <div class="unit-input">
                                    <input type="text" id="amount-searched" class="autonumeric" name="amount_searched" value="{{ old('amount_searched', $project->amount_searched) }}" {{ $project->locked ? ' disabled' : '' }}/>
                                    <span class="unit">{{ $project->currency_symbol }}</span>
                                 </div>

                                 @if( $errors->has('amount_searched') )
                                    <p class="form-error">{{ $errors->first('amount_searched') }}</p>
                                 @endif
                              </div>

                              <div class="form-group required{{ $errors->has('fundraising_objective') ? ' has-error' : '' }}">
                                 <label for="fundraising-objective">@lang('fields.project.synthesis.fundraising_objective')</label>
                                 <textarea id="fundraising-objective" maxlength="5000" name="fundraising_objective" placeholder="@lang('fields.project.synthesis.fundraising_objective')"{{ $project->locked ? ' disabled' : '' }}>{{ old('fundraising_objective', $project->getField('fundraising_objective')) }}</textarea>
                                 <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                                 @if( $errors->has('fundraising_objective') )
                                    <p class="form-error">{{ $errors->first('fundraising_objective') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12">
               <div class="account">
                  <div class="form-group{{ $errors->has('dilution') ? ' has-error' : '' }}">
                     <div class="checkbox with-input">
                        <input type="radio" id="type-handover" name="project_type" value="handover"{{ old('project_type', $project->type) === 'handover' ? ' checked' : '' }} {{ $project->locked ? ' disabled' : '' }}/>
                        <label for="type-handover">@lang('fields.project.synthesis.handover')</label>
                        <span class="checkmark"></span>

                        <div class="related-inputs"{!! old('project_type', $project->type) === 'handover' ? ' style="display: block;"' : '' !!}>
                           <div class="col-4">
                              <div class="form-group">
                                 <label for="type-handover-input">@lang('fields.project.synthesis.dilution')</label>
                                 <select id="type-handover-input" name="dilution">
                                    <option value="1"{{ old('dilution', $project->dilution) == 1 ? ' selected' : '' }}>@lang('common.yes')</option>
                                    <option value="0"{{ old('dilution', $project->dilution) == 0 ? ' selected' : '' }}>@lang('common.no')</option>
                                 </select>
                              </div>

                              @if( $errors->has('dilution') )
                                 <p class="form-error">{{ $errors->first('dilution') }}</p>
                              @endif
                           </div>
                           <div class="col-12">
                              <div class="form-group required{{ $errors->has('handover_objective') ? ' has-error' : '' }}">
                                 <label for="handover-objective">@lang('fields.project.synthesis.handover_objective')</label>

                                 <textarea id="handover-objective" name="handover_objective" maxlength="5000" placeholder="@lang('fields.project.synthesis.handover_objective')"{{ $project->locked ? ' disabled' : '' }}>{{ old('handover_objective', $project->getField('handover_objective')) }}</textarea>
                                 <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                                 @if( $errors->has('handover_objective') )
                                    <p class="form-error">{{ $errors->first('handover_objective') }}</p>
                                 @endif
                              </div>

                              <div class="form-group">
                                 <div class="checkbox">
                                    <input type="checkbox" id="project-mbi" name="project_mbi"{{ old('project_mbi', $project->mbi) ? ' checked' : '' }} {{ $project->locked ? ' disabled' : '' }} />
                                    <label for="project-mbi">@lang('fields.project.synthesis.mbi')</label>
                                    <span class="checkmark"></span>
                                 </div>

                                 <div class="checkbox">
                                    <input type="checkbox" id="industrial-merge" name="industrial_merge"{{ old('industrial_merge', $project->industrial_merge) ? ' checked' : '' }} {{ $project->locked ? ' disabled' : '' }} />
                                    <label for="industrial-merge">@lang('fields.project.synthesis.industrial_merge')</label>
                                    <span class="checkmark"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <section>
         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group required{{ $errors->has('development_stage_id') ? ' has-error' : '' }}">
                  <label for="development-stage-id">@lang('fields.project.synthesis.development_stage') <span class="help icon-help"></span></label>
                  <select id="development-stage-id" name="development_stage_id"{{ $project->locked ? ' disabled' : '' }}>
                     @foreach( $developmentStages as $stage )
                        <option value="{{ $stage->id }}"{{ $stage->id == old('development_stage_id', $project->development_stage_id) ? ' selected' : '' }}>@lang('development_stages.'. $stage->code)</option>
                     @endforeach
                  </select>

                  @if( $errors->has('development_stage_id') )
                     <p class="form-error">{{ $errors->first('development_stage_id') }}</p>
                  @endif

                  <div class="help-popin">
                     @lang('fields.project.synthesis.development_stage_help')
                  </div>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-6 lg-12">
               <div class="form-group{{ $errors->has('social_impact') ? ' has-error' : '' }} required">
                  <label for="social-impact">@lang('fields.project.synthesis.social_impact')</label>
                  <select id="social-impact" class="small" name="social_impact"{{ $project->locked ? ' disabled' : '' }}>
                     <option value="1"{{ old('social_impact', $project->social_impact) == 1 ? ' selected' : '' }}>@lang('common.yes')</option>
                     <option value="0"{{ old('social_impact', $project->social_impact) == 0 ? ' selected' : '' }}>@lang('common.no')</option>
                  </select>
               </div>
            </div>
         </div>
      </section>

      <section>
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.structure.legal_documents')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-4">
               <div class="form-group required{{ $errors->has('kbis') ? ' has-error' : '' }}">
                  <label for="kbis">@lang('fields.project.structure.kbis')</label>
                  <div class="hint">@lang('fields.pdf_only')</div>

                  <div class="single-file row">
                     @php $kbis = $project->getDocument('kbis'); @endphp

                     @if( $kbis )
                        <div class="file-input">
                           <input type="file" id="kbis-document" class="uploaded" name="kbis" data-id="{{ $kbis->id }}" disabled />
                           <label for="kbis-document" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $kbis->id]) }}" target="_blank">{{ $kbis->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @else
                        <div class="file-input">
                           <input type="file" id="kbis-document" name="kbis" {{ $project->locked ? ' disabled' : '' }} accept="application/pdf" />
                           <label for="kbis-document" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('kbis') )
                     <p class="form-error">{{ $errors->first('kbis') }}</p>
                  @endif
               </div>
            </div>
            <div class="optional">
               <div class="col-4">
                  <div class="form-group{{ $errors->has('statutes') ? ' has-error' : '' }}">
                     <label for="statutes">@lang('fields.project.structure.statutes')</label>
                     <div class="hint">@lang('fields.pdf_only')</div>

                     <div class="single-file row">
                        @php $statutes = $project->getDocument('statutes'); @endphp

                        @if( $statutes )
                           <div class="file-input">
                              <input type="file" id="statutes-document" class="uploaded" name="statutes" data-id="{{ $statutes->id }}" disabled />
                              <label for="statutes-document" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $statutes->id]) }}" target="_blank">{{ $statutes->name }}</a></label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @else
                           <div class="file-input">
                              <input type="file" id="statutes-document" name="statutes" {{ $project->locked ? ' disabled' : '' }} accept="application/pdf" />
                              <label for="statutes-document" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @endif
                     </div>

                     @if( $errors->has('statutes') )
                        <p class="form-error">{{ $errors->first('statutes') }}</p>
                     @endif
                  </div>
               </div>
               <div class="col-4">
                  <div class="form-group{{ $errors->has('sharehold_agreement') ? ' has-error' : '' }}">
                     <label for="sharehold-agreement">@lang('fields.project.structure.sharehold_agreement')</label>
                     <div class="hint">@lang('fields.pdf_only')</div>

                     <div class="single-file row">
                        @php $shareholdAgreement = $project->getDocument('sharehold_agreement'); @endphp

                        @if( $shareholdAgreement )
                           <div class="file-input">
                              <input type="file" id="sharehold-agreement-document" class="uploaded" name="sharehold_agreement" data-id="{{ $shareholdAgreement->id }}" disabled />
                              <label for="sharehold-agreement-document" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $shareholdAgreement->id]) }}" target="_blank">{{ $shareholdAgreement->name }}</a></label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @else
                           <div class="file-input">
                              <input type="file" id="sharehold-agreement-document" name="sharehold_agreement" {{ $project->locked ? ' disabled' : '' }} accept="application/pdf" />
                              <label for="sharehold-agreement-document" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | History
      |--------------------------------------------------------------------------
      --}}
      <section id="C4">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.history')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-4 lg-6 s-9 xs-4">
               <div class="form-group required{{ $errors->has('company_creation_date') ? ' has-error' : '' }}">
                  <label for="company-creation-date">@lang('fields.project.synthesis.creation_date')</label>
                  <input type="text" id="company-creation-date" name="company_creation_date" class="datepicker" placeholder="@lang('fields.date_placeholder')" autocomplete="off" value="{{ old('company_creation_date', $project->company_creation_date ? date('d/m/Y', strtotime($project->company_creation_date)) : '') }}" {{ $project->locked ? ' disabled' : '' }}/>

                  @if( $errors->has('company_creation_date') )
                     <p class="form-error">{{ $errors->first('company_creation_date') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group advised">
                  <label>@lang('fields.project.synthesis.events')</label>
                  <div class="hint">@lang('fields.project.synthesis.events_hint')</div>
               </div>
            </div>
         </div>
         <div class="optional">
            <ol id="events" class="multiple-items">
               @php $i = 0; @endphp

               @if( sizeof(old('events')) > 0 )

                  @foreach( old('events') as $event )
                     @php $event = (object) $event; @endphp
                     @include('front.dashboard.project.form.relationships.event')
                     @php $i++; @endphp
                  @endforeach

               @elseif( sizeof($project->events) > 0 )

                  @foreach( $project->events as $event )
                     @include('front.dashboard.project.form.relationships.event')
                     @php $i++; @endphp
                  @endforeach

               @else
                  @include('front.dashboard.project.form.relationships.event')
               @endif
            </ol>

            <div class="row">
               <div class="col-12">
                  <div class="button small blue add-item" id="add-event" data-items="events" {{ $project->locked ? ' disabled' : '' }}>@lang('buttons.add_event')</div>
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Activity areas
      |--------------------------------------------------------------------------
      --}}
      <section id="C5">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.activity_areas')</h2>
            </div>
            <div class="col-12">
               <div class="form-group required">
                  <label>@lang('fields.project.synthesis.activity_areas_list')</label>
                  <div class="hint">@lang('fields.project.synthesis.activity_areas_list_hint')</div>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <ul id="activity-areas" class="recursive-list">
                  @php $selectedAreas = $project->activity_areas()->pluck('activity_area_id')->toArray(); @endphp

                  @foreach( $activityAreas as $activityArea )
                     {!! $activityArea->recursiveList('acivity-areas', 'activity_areas[]', old('activity_areas', $selectedAreas)) !!}
                  @endforeach
               </ul>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | SWOT
      |--------------------------------------------------------------------------
      --}}
      <section id="C6" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.swot')</h2>
               <p>@lang('fields.project.synthesis.swot_hint')</p>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('swot_strengths') ? ' has-error' : '' }}">
                  <label for="swot-strengths">@lang('fields.project.synthesis.strengths')</label>
                  <textarea id="swot-strengths" name="swot_strengths" maxlength="5000" placeholder="@lang('fields.project.synthesis.strengths_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('swot_strengths', $project->getField('swot_strengths')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('swot_strengths') )
                     <p class="form-error">{{ $errors->first('swot_strengths') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('swot_weaknesses') ? ' has-error' : '' }}">
                  <label for="swot-weaknesses">@lang('fields.project.synthesis.weaknesses')</label>
                  <textarea id="swot-weaknesses" name="swot_weaknesses" maxlength="5000" placeholder="@lang('fields.project.synthesis.weaknesses_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('swot_weaknesses', $project->getField('swot_weaknesses')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('swot_weaknesses') )
                     <p class="form-error">{{ $errors->first('swot_weaknesses') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('swot_opportunities') ? ' has-error' : '' }}">
                  <label for="swot-opportunities">@lang('fields.project.synthesis.opportunities')</label>
                  <textarea id="swot-opportunities" name="swot_opportunities" maxlength="5000" placeholder="@lang('fields.project.synthesis.opportunities_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('swot_opportunities', $project->getField('swot_opportunities')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('swot_opportunities') )
                     <p class="form-error">{{ $errors->first('swot_opportunities') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('swot_threats') ? ' has-error' : '' }}">
                  <label for="swot-threats">@lang('fields.project.synthesis.threats')</label>
                  <textarea id="swot-threats" name="swot_threats" maxlength="5000" placeholder="@lang('fields.project.synthesis.threats_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('swot_threats', $project->getField('swot_threats')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('swot_threats') )
                     <p class="form-error">{{ $errors->first('swot_threats') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Teasers
      |--------------------------------------------------------------------------
      --}}
      <section id="C7">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.teasers')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('teaser_mail') ? ' has-error' : '' }}">
                  <label for="teaser-mail">@lang('fields.project.synthesis.teaser_mail')</label>
                  <div class="hint">@lang('fields.project.synthesis.teaser_mail_hint')</div>

                  <textarea id="teaser-mail" name="teaser_mail" maxlength="600" placeholder="@lang('fields.project.synthesis.teaser_mail_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('teaser_mail', $project->getField('teaser_mail')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">600</span></div>

                  @if( $errors->has('teaser_mail') )
                     <p class="form-error">{{ $errors->first('teaser_mail') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('teaser_welcome') ? ' has-error' : '' }}">
                  <label for="teaser-welcome">@lang('fields.project.synthesis.teaser_welcome')</label>
                  <div class="hint">@lang('fields.project.synthesis.teaser_welcome_hint')</div>

                  <textarea id="teaser-welcome" name="teaser_welcome" maxlength="1500" placeholder="@lang('fields.project.synthesis.teaser_welcome_placeholder')" style="height: 150px;"{{ $project->locked ? ' disabled' : '' }}>{{ old('teaser_welcome', $project->getField('teaser_welcome')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">1500</span></div>

                  @if( $errors->has('teaser_welcome') )
                     <p class="form-error">{{ $errors->first('teaser_welcome') }}</p>
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
      <section id="C8" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.synthesis.various')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('synthesis_misc') ? ' has-error' : '' }}">
                  <label for="synthesis-various">@lang('fields.project.synthesis.various_info')</label>
                  <textarea id="synthesis-various" name="synthesis_misc" maxlength="5000" placeholder="@lang('fields.project.synthesis.various_info_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('synthesis_misc', $project->getField('synthesis_misc')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('synthesis_misc') )
                     <p class="form-error">{{ $errors->first('synthesis_misc') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('synthesis_misc_documents') ? ' has-error' : '' }}">
                  <label for="misc-documents">@lang('fields.attach_document')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $i = 0; @endphp
                     @foreach( $project->getDocuments('synthesis_misc_documents') as $document )
                        <div class="file-input">
                           <input type="file" id="synthesis-misc-documents-{{ $i }}" class="uploaded" name="synthesis_misc_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="synthesis-misc-documents-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>

                        @php $i++; @endphp
                     @endforeach

                     @if( $i < 5 )
                        <div class="file-input">
                           <input type="file" id="synthesis-misc-documents-{{ $i }}" name="synthesis_misc_documents[]" {{ $project->locked ? ' disabled' : '' }} />
                           <label for="synthesis-misc-documents-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('synthesis_misc_documents') )
                     <p class="form-error">{{ $errors->first('synthesis_misc_documents') }}</p>
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
               <a class="link" href="{{ route('project_preview', ['id' => $project->id, 'step' => 'synthesis']) }}" target="_blank">@lang('buttons.preview')</a>
            </div>
         </div>
      </section>
   </div>
</form>
