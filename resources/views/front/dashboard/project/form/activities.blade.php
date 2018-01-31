{{-- <div class="summary">
   <div id="summary-project">
      <ol>
         <li><a href="#C1">@lang('fields.project.list.activity_description')</a></li>
         <li><a href="#C2">@lang('fields.project.activities.business_model')</a></li>
         <li><a href="#C3">@lang('fields.project.activities.suppliers')</a></li>
         <li><a href="#C4">@lang('fields.project.activities.customers')</a></li>
         <li><a href="#C5">@lang('fields.project.activities.market')</a></li>
         <li><a href="#C6">@lang('fields.project.synthesis.various')</a></li>
      </ol>
   </div>
</div> --}}
<form id="project-form" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'activities']) }}" data-section="activities" autocomplete="off" enctype="multipart/form-data" />
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
      | Activity
      |--------------------------------------------------------------------------
      --}}

      <section id="C1">
         <div class="row">
            <div class="col-6 lg-12 align-right float-right">
               @include('front.dashboard.partials.switch')
            </div>

            <div class="col-6 lg-12">
               <h2>@lang('fields.project.activities.activity_description')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('activity_description') ? ' has-error' : '' }}">
                  <label for="activity-description">@lang('fields.project.activities.activity_description')</label>
                  <textarea id="activity-description" name="activity_description" maxlength="5000" placeholder="@lang('fields.project.activities.activity_description_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('activity_description', $project->getField('activity_description')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('activity_description') )
                     <p class="form-error">{{ $errors->first('activity_description') }}</p>
                  @endif
               </div>
            </div>
         </div>


         <div class="optional">
            <div class="col-12">
               <div class="form-group {{ $errors->has('activities_description_documents') ? ' has-error' : '' }}">
                  <label for="activities-description-documents">@lang('fields.project.activities.upload_activity_description')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $descriptionDocuments = $project->getDocuments('activities_description_documents'); @endphp
                     @foreach( $descriptionDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="activities-description-documents-{{ $loop->index }}" class="uploaded" name="activities_description_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="activities-description-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $descriptionDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="activities-description-documents-{{ $descriptionDocuments->count() }}" name="activities_description_documents[]" {{ $project->locked ? ' disabled' : '' }}/>
                           <label for="activities-description-documents-{{ $descriptionDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('activities_description_documents') )
                     <p class="form-error">{{ $errors->first('activities_description_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Business model
      |--------------------------------------------------------------------------
      --}}
      <section id="C2" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.business_model')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group {{ $errors->has('sales_channels') ? ' has-error' : '' }}">
                  <label for="sales-channels">@lang('fields.project.activities.sales_channels')</label>
                  <div class="hint">@lang('fields.project.activities.sales_channels_hint')</div>
                  <textarea id="sales-channels" name="sales_channels" maxlength="5000" placeholder="@lang('fields.project.activities.sales_channels')" {{ $project->locked ? ' disabled' : '' }}>{{ old('sales_channels', $project->getField('sales_channels')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('sales_channels') )
                     <p class="form-error">{{ $errors->first('sales_channels') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('client_types') ? ' has-error' : '' }}">
                  <label for="client-types">@lang('fields.project.activities.client_types')</label>
                  <div class="hint">@lang('fields.project.activities.client_types_hint')</div>
                  <textarea id="client-types" name="client_types" maxlength="5000" placeholder="@lang('fields.project.activities.client_types')" {{ $project->locked ? ' disabled' : '' }}>{{ old('client_types', $project->getField('client_types')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('client_types') )
                     <p class="form-error">{{ $errors->first('client_types') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('items_sold') ? ' has-error' : '' }}">
                  <label for="items-sold">@lang('fields.project.activities.items_sold')</label>
                  <textarea id="items-sold" name="items_sold" maxlength="5000" placeholder="@lang('fields.project.activities.items_sold_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('client_types', $project->getField('items_sold')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('items_sold') )
                     <p class="form-error">{{ $errors->first('items_sold') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <?php /*
         <div class="row">
         <div class="col-12">
         <div class="form-group{{ $errors->has('pricing_info') ? ' has-error' : '' }}">
         <label for="pricing-info">@lang('fields.project.activities.pricing_info')
         </label>
         <textarea id="pricing-info" name="pricing_info" placeholder="@lang('fields.project.activities.pricing_info_placeholder')">{{ old('pricing_info', $project->getField('pricing_info')) }}</textarea>

         @if( $errors->has('pricing_info') )
         <p class="form-error">{{ $errors->first('pricing_info') }}</p>
         @endif
         </div>
         </div>
         </div> */?>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('particular_items') ? ' has-error' : '' }}">
                  <label for="particular-items">@lang('fields.project.activities.particular_items')</label>
                  <textarea id="particular-items" name="particular_items" maxlength="5000"  placeholder="@lang('fields.project.activities.particular_items_placeholder')" {{ $project->locked ? ' disabled' : '' }}>{{ old('particular_items', $project->getField('particular_items')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('particular_items') )
                     <p class="form-error">{{ $errors->first('particular_items') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <?php /*
         <div class="row">
         <div class="col-6 lg-12">
         <div class="form-group{{ $errors->has('average_basket') ? ' has-error' : '' }}">
         <label for="average-basket">@lang('fields.project.activities.average_basket')</label>
         <div class="hint">@lang('fields.project.activities.average_basket_hint')</div>
         <div class="unit-input">
         <input type="text" id="average-basket" class="autonumeric" name="average_basket" value="{{ old('average_basket', $project->average_basket) }}" />
         <span class="unit">{{ $project->currency_symbol }}</span>
         </div>
         @if( $errors->has('average_basket') )
         <p class="form-error">{{ $errors->first('average_basket') }}</p>
         @endif
         </div>
         </div>
         </div>

         <div class="row">
         <div class="col-6 lg-12">
         <div class="form-group{{ $errors->has('acquisition_cost') ? ' has-error' : '' }}">
         <label for="acquisition-cost">@lang('fields.project.activities.acquisition_cost')</label>
         <div class="unit-input">
         <input type="text" id="acquisition-cost" class="autonumeric" name="acquisition_cost" value="{{ old('acquisition_cost', $project->acquisition_cost) }}" />
         <span class="unit">{{ $project->currency_symbol }}</span>
         </div>
         @if( $errors->has('acquisition_cost') )
         <p class="form-error">{{ $errors->first('acquisition_cost') }}</p>
         @endif
         </div>
         </div>
         </div>  */ ?>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('business_model_documents') ? ' has-error' : '' }}">
                  <label for="business-model-documents">@lang('fields.project.activities.upload_business_model')</label>
                  <div class="hint">@lang('fields.project.activities.upload_business_model_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $businessModelDocuments = $project->getDocuments('business_model_documents'); @endphp
                     @foreach( $businessModelDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="business-model-documents-{{ $loop->index }}" class="uploaded" name="business_model_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="business-model-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $businessModelDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="business-model-documents-{{ $businessModelDocuments->count() }}" name="business_model_documents[]" {{ $project->locked ? ' disabled' : '' }} />
                           <label for="business-model-documents-{{ $businessModelDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('business_model_documents') )
                     <p class="form-error">{{ $errors->first('business_model_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Suppliers
      |--------------------------------------------------------------------------
      --}}
      <section id="C3" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.suppliers')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_type') ? ' has-error' : '' }}">
                  <label for="suppliers_type">@lang('fields.project.activities.suppliers_type')</label>
                  <div class="hint">@lang('fields.project.activities.suppliers_type_hint')</div>
                  <textarea id="suppliers_type" name="suppliers_type" maxlength="5000" placeholder="@lang('fields.project.activities.suppliers_type')" {{ $project->locked ? ' disabled' : '' }}>{{ old('suppliers_type', $project->getField('suppliers_type')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('suppliers_type') )
                     <p class="form-error">{{ $errors->first('suppliers_type') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_name') ? ' has-error' : '' }}">
                  <label for="suppliers-name">@lang('fields.project.activities.suppliers_name')</label>
                  <div class="hint">@lang('fields.project.activities.suppliers_name_hint')</div>
                  <textarea id="suppliers-name" name="suppliers_name" maxlength="5000" placeholder="@lang('fields.project.activities.suppliers_name')" {{ $project->locked ? ' disabled' : '' }}>{{ old('suppliers_name', $project->getField('suppliers_name')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('suppliers_name') )
                     <p class="form-error">{{ $errors->first('suppliers_name') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_evolution_analysis') ? ' has-error' : '' }}">
                  <label for="suppliers-evolution-analysis">@lang('fields.project.activities.suppliers_evolution_analysis')</label>
                  <div class="hint">@lang('fields.project.activities.suppliers_evolution_analysis_hint')</div>
                  <textarea id="suppliers-evolution-analysis" maxlength="5000" name="suppliers_evolution_analysis" placeholder="@lang('fields.project.activities.suppliers_evolution_analysis')" {{ $project->locked ? ' disabled' : '' }}>{{ old('suppliers_evolution_analysis', $project->getField('suppliers_evolution_analysis')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('suppliers_evolution_analysis') )
                     <p class="form-error">{{ $errors->first('suppliers_evolution_analysis') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_relationship') ? ' has-error' : '' }}">
                  <label for="suppliers-relationship">@lang('fields.project.activities.suppliers_relationship')</label>
                  <div class="hint">@lang('fields.project.activities.suppliers_relationship_hint')</div>
                  <textarea id="suppliers-relationship" maxlength="5000" name="suppliers_relationship" placeholder="@lang('fields.project.activities.suppliers_relationship')" {{ $project->locked ? ' disabled' : '' }}>{{ old('suppliers_relationship', $project->getField('suppliers_relationship')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('suppliers_relationship') )
                     <p class="form-error">{{ $errors->first('suppliers_relationship') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_certification') ? ' has-error' : '' }}">
                  <label for="suppliers-certification">@lang('fields.project.activities.suppliers_certification')</label>
                  <div class="hint">@lang('fields.project.activities.suppliers_certification_hint')</div>
                  <textarea id="suppliers-certification" maxlength="5000" name="suppliers_certification" placeholder="@lang('fields.project.activities.suppliers_certification')"{{ $project->locked ? ' disabled' : '' }}>{{ old('suppliers_certification', $project->getField('suppliers_certification')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('suppliers_certification') )
                     <p class="form-error">{{ $errors->first('suppliers_certification') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('suppliers_documents') ? ' has-error' : '' }}">
                  <label for="suppliers-documents">@lang('fields.project.activities.upload_suppliers')</label>
                  <div class="hint">@lang('fields.project.activities.upload_suppliers_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $suppliersDocuments = $project->getDocuments('suppliers_documents'); @endphp
                     @foreach( $suppliersDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="suppliers-documents-{{ $loop->index }}" class="uploaded" name="suppliers_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="suppliers-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $suppliersDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="suppliers-documents-{{ $suppliersDocuments->count() }}" name="suppliers_documents[]" {{ $project->locked ? ' disabled' : '' }} />
                           <label for="suppliers-documents-{{ $suppliersDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('suppliers_documents') )
                     <p class="form-error">{{ $errors->first('suppliers_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Customers
      |--------------------------------------------------------------------------
      --}}
      <section id="C4" class="optional">
         <div class="row">
            <div class="col-6 lg-12 xs-4">
               <h2>@lang('fields.project.activities.customers')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_segmentation') ? ' has-error' : '' }}">
                  <label for="customers-segmentation">@lang('fields.project.activities.customers_segmentation')</label>
                  <textarea id="customers-segmentation" maxlength="5000" name="customers_segmentation" placeholder="@lang('fields.project.activities.customers_segmentation')"{{ $project->locked ? ' disabled' : '' }}>{{ old('customers_segmentation', $project->getField('customers_segmentation')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('customers_segmentation') )
                     <p class="form-error">{{ $errors->first('customers_segmentation') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_names') ? ' has-error' : '' }}">
                  <label for="customers-names">@lang('fields.project.activities.customers_names')</label>
                  <div class="hint">@lang('fields.project.activities.customers_names_hint')</div>
                  <textarea id="customers-names" maxlength="5000" name="customers_names" placeholder="@lang('fields.project.activities.customers_names')"{{ $project->locked ? ' disabled' : '' }}>{{ old('customers_names', $project->getField('customers_names')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('customers_names') )
                     <p class="form-error">{{ $errors->first('customers_names') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_analysis') ? ' has-error' : '' }}">
                  <label for="customers-analysis">@lang('fields.project.activities.customers_analysis')</label>
                  <div class="hint">@lang('fields.project.activities.customers_analysis_hint')</div>
                  <textarea id="customers-analysis" maxlength="5000" name="customers_analysis" placeholder="@lang('fields.project.activities.customers_analysis')"{{ $project->locked ? ' disabled' : '' }}>{{ old('customers_analysis', $project->getField('customers_analysis')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('customers_analysis') )
                     <p class="form-error">{{ $errors->first('customers_analysis') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_relationship') ? ' has-error' : '' }}">
                  <label for="customers-relationship">@lang('fields.project.activities.customers_relationship')</label>
                  <div class="hint">@lang('fields.project.activities.customers_relationship_hint')</div>
                  <textarea id="customers-relationship" maxlength="5000" name="customers_relationship" placeholder="@lang('fields.project.activities.customers_relationship')"{{ $project->locked ? ' disabled' : '' }}>{{ old('customers_relationship', $project->getField('customers_relationship')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('customers_relationship') )
                     <p class="form-error">{{ $errors->first('customers_relationship') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_recurrence') ? ' has-error' : '' }}">
                  <label for="customers-recurrence">@lang('fields.project.activities.customers_recurrence')</label>
                  <div class="hint">@lang('fields.project.activities.customers_recurrence_hint')</div>
                  <textarea id="customers-recurrence" maxlength="5000" name="customers_recurrence" placeholder="@lang('fields.project.activities.customers_recurrence')"{{ $project->locked ? ' disabled' : '' }}>{{ old('customers_recurrence', $project->getField('customers_recurrence')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('customers_recurrence') )
                     <p class="form-error">{{ $errors->first('customers_recurrence') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('customers_documents') ? ' has-error' : '' }}">
                  <label for="customers-documents">@lang('fields.project.activities.upload_customers')</label>
                  <div class="hint">@lang('fields.project.activities.upload_customers_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $customersDocuments = $project->getDocuments('customers_documents'); @endphp
                     @foreach( $customersDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="customers-documents-{{ $loop->index }}" class="uploaded" name="customers_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="customers-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $customersDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="customers-documents-{{ $customersDocuments->count() }}" name="customers_documents[]" {{ $project->locked ? ' disabled' : '' }}/>
                           <label for="customers-documents-{{ $customersDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('customers_documents') )
                     <p class="form-error">{{ $errors->first('customers_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Market
      |--------------------------------------------------------------------------
      --}}
      <section id="C5" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.market')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('target_market_presentation') ? ' has-error' : '' }}">
                  <label for="target-market-presentation">@lang('fields.project.activities.target_market_presentation')</label>
                  <div class="hint">@lang('fields.project.activities.target_market_presentation_hint')</div>
                  <textarea id="target-market-presentation" maxlength="5000" name="target_market_presentation" placeholder="@lang('fields.project.activities.target_market_presentation_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('target_market_presentation', $project->getField('target_market_presentation')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('target_market_presentation') )
                     <p class="form-error">{{ $errors->first('target_market_presentation') }}</p>
                  @endif
               </div>
            </div>
         </div>


         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>@lang('fields.project.activities.competitors')</label>
                  <div class="hint">@lang('fields.project.activities.competitors_hint')</div>
               </div>
            </div>
         </div>

         <ol id="competitors" class="multiple-items">
            @php $i = 0; @endphp

            @if( sizeof(old('competitors')) > 0 )
               @foreach( old('competitors') as $competitor )
                  @php $competitor = (object) $competitor; @endphp
                  @include('front.dashboard.project.form.relationships.competitor')
                  @php $i++; @endphp
               @endforeach
            @elseif( sizeof($project->competitors) > 0 )
               @foreach( $project->competitors as $competitor )
                  @include('front.dashboard.project.form.relationships.competitor')
                  @php $i++; @endphp
               @endforeach
            @else
               @include('front.dashboard.project.form.relationships.competitor')
            @endif
         </ol>

         <div class="row">
            <div class="col-12">
               <div class="button blue small add-item" id="add-competitor" data-items="competitors">@lang('fields.project.activities.add_competitor')</div>
            </div>
         </div>

         <div class="row">
            <div class="col-12{{ $errors->has('barriers_to_entry') ? ' has-error' : '' }}">
               <div class="form-group">
                  <label for="barriers-to-entry">@lang('fields.project.activities.barriers_to_entry')</label>
                  <div class="hint">@lang('fields.project.activities.barriers_to_entry_hint')</div>
                  <textarea id="barriers-to-entry" maxlength="5000" name="barriers_to_entry" placeholder="@lang('fields.project.activities.barriers_to_entry')"{{ $project->locked ? ' disabled' : '' }}>{{ old('barriers_to_entry', $project->getField('barriers_to_entry')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('barriers_to_entry') )
                     <p class="form-error">{{ $errors->first('barriers_to_entry') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('market_documents') ? ' has-error' : '' }}">
                  <label for="market-documents">@lang('fields.project.activities.upload_market')</label>
                  <div class="hint">@lang('fields.project.activities.upload_market_hint')<br />@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $marketDocuments = $project->getDocuments('market_documents'); @endphp
                     @foreach( $marketDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="market-documents-{{ $loop->index }}" class="uploaded" name="market_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="market-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $marketDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="market-documents-{{ $marketDocuments->count() }}" name="market_documents[]" {{ $project->locked ? ' disabled' : '' }}/>
                           <label for="market-documents-{{ $marketDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('market_documents') )
                     <p class="form-error">{{ $errors->first('market_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      <section id="C6" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.synthesis.various')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('activities_misc') ? ' has-error' : '' }}">
                  <label for="activities-misc">@lang('fields.project.activities.various_info')</label>
                  <textarea id="activities-misc" maxlength="5000" name="activities_misc" placeholder="@lang('fields.project.activities.various_info_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('activities_misc', $project->getField('activities_misc')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('activities_misc') )
                     <p class="form-error">{{ $errors->first('activities_misc') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('activities_misc_documents') ? ' has-error' : '' }}">
                  <label for="misc-documents">@lang('fields.attach_document')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $miscDocuments = $project->getDocuments('activities_misc_documents'); @endphp
                     @foreach( $miscDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="activities-misc-documents-{{ $loop->index }}" class="uploaded" name="activities_misc_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="activities-misc-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $miscDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="activities-misc-documents-{{ $miscDocuments->count() }}" name="activities_misc_documents[]"{{ $project->locked ? ' disabled' : '' }} />
                           <label for="activities-misc-documents-{{ $miscDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('activities_misc_documents') )
                     <p class="form-error">{{ $errors->first('activities_misc_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      <section>
         <div class="row">
            <div class="col-12 align-center">
               <input type="hidden" id="files-to-remove" name="files_to_remove" value="" />

               <input type="submit" class="blue button-save" value="@lang('buttons.save')" {{ $project->locked ? ' disabled' : '' }}/>
            </div>

            <div class="col-12 align-center">
               <a class="link" href="{{ route('project_preview', ['id' => $project->id, 'step' => 'activities']) }}" target="_blank">@lang('buttons.preview')</a>
            </div>
         </div>
      </section>
   </div>
</form>
