<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Activity description
   |--------------------------------------------------------------------------
   --}}

   @if( $project->getField('activity_description'))
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.activity_description')</h2>

               <div class="form-group">
                  {!! nl2br($project->getField('activity_description')) !!}
               </div>

               @php $descriptionDocuments = $project->getDocuments('activities_description_documents'); @endphp
               @if( $descriptionDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $descriptionDocuments->count())</label>

                     @foreach( $descriptionDocuments as $document )
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
   | Business model
   |--------------------------------------------------------------------------
   --}}
   @php $businessModelDocuments = $project->getDocuments('business_model_documents'); @endphp
   @if( $project->getField('sales_channels') || $project->getField('client_types') || $project->getField('items_sold') || $project->getField('pricing_info') || $project->getField('particular_items') || $project->average_basket || $project->acquisition_cost || $businessModelDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.business_model')</h2>

               @if( $project->getField('sales_channels') )
                  <div class="form-group">
                     <label>@lang('project.activities.sales_channels')</label>
                     {!! nl2br($project->getField('sales_channels')) !!}
                  </div>
               @endif

               @if( $project->getField('client_types') )
                  <div class="form-group">
                     <label>@lang('project.activities.client_types')</label>
                     {!! nl2br($project->getField('client_types')) !!}
                  </div>
               @endif

               @if( $project->getField('items_sold') )
                  <div class="form-group">
                     <label>@lang('project.activities.items_sold')</label>
                     {!! nl2br($project->getField('items_sold')) !!}
                  </div>
               @endif

               @if( $project->getField('pricing_info') )
                  <div class="form-group">
                     <label>@lang('project.activities.pricing_info')</label>
                     {!! nl2br($project->getField('pricing_info')) !!}
                  </div>
               @endif

               @if( $project->getField('particular_items') )
                  <div class="form-group">
                     <label>@lang('project.activities.particular_items')</label>
                     {!! nl2br($project->getField('particular_items')) !!}
                  </div>
               @endif

               @if( $project->average_basket )
                  <div class="form-group">
                     @lang('project.activities.average_basket', ['amount' => number_format($project->average_basket, 0, ',', ' ') . ' ' . $project->currency_symbol])
                  </div>
               @endif

               @if( $project->acquisition_cost )
                  <div class="form-group">
                     @lang('project.activities.acquisition_cost', ['amount' => number_format($project->acquisition_cost, 0, ',', ' ') . ' ' . $project->currency_symbol])
                  </div>
               @endif

               @if( $businessModelDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $businessModelDocuments->count())</label>

                     @foreach( $businessModelDocuments as $document )
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
   | Suppliers
   |--------------------------------------------------------------------------
   --}}
   @php $suppliersDocuments = $project->getDocuments('suppliers_documents'); @endphp
   @if( $project->getField('suppliers_type') || $project->getField('suppliers_name') || $project->getField('suppliers_evolution_analysis') || $project->getField('suppliers_relationship') || $project->getField('suppliers_certification') || $suppliersDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.suppliers')</h2>

               @if( $project->getField('suppliers_type') )
                  <div class="form-group">
                     <label>@lang('project.activities.suppliers_type')</label>
                     {!! nl2br($project->getField('suppliers_type')) !!}
                  </div>
               @endif

               @if( $project->getField('suppliers_name') )
                  <div class="form-group">
                     <label>@lang('project.activities.suppliers_name')</label>
                     {!! nl2br($project->getField('suppliers_name')) !!}
                  </div>
               @endif

               @if( $project->getField('suppliers_evolution_analysis') )
                  <div class="form-group">
                     <label>@lang('project.activities.suppliers_evolution_analysis')</label>
                     {!! nl2br($project->getField('suppliers_evolution_analysis')) !!}
                  </div>
               @endif

               @if( $project->getField('suppliers_relationship') )
                  <div class="form-group">
                     <label>@lang('project.activities.suppliers_relationship')</label>
                     {!! nl2br($project->getField('suppliers_relationship')) !!}
                  </div>
               @endif

               @if( $project->getField('suppliers_certification') )
                  <div class="form-group">
                     <label>@lang('project.activities.suppliers_certification')</label>
                     {!! nl2br($project->getField('suppliers_certification')) !!}
                  </div>
               @endif

               @if( $suppliersDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $suppliersDocuments->count())</label>

                     @foreach( $suppliersDocuments as $document )
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
   | Customers
   |--------------------------------------------------------------------------
   --}}
   @php $customersDocuments = $project->getDocuments('customers_documents'); @endphp
   @if( $project->getField('customers_segmentation') || $project->getField('customers_names') || $project->getField('customers_analysis') || $project->getField('customers_relationship') || $project->getField('customers_recurrence') || $customersDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.customers')</h2>

               @if( $project->getField('customers_segmentation') )
                  <div class="form-group">
                     <label>@lang('project.activities.customers_segmentation')</label>
                     {!! nl2br($project->getField('customers_segmentation')) !!}
                  </div>
               @endif

               @if( $project->getField('customers_names') )
                  <div class="form-group">
                     <label>@lang('project.activities.customers_names')</label>
                     {!! nl2br($project->getField('customers_names')) !!}
                  </div>
               @endif

               @if( $project->getField('customers_analysis') )
                  <div class="form-group">
                     <label>@lang('project.activities.customers_analysis')</label>
                     {!! nl2br($project->getField('customers_analysis')) !!}
                  </div>
               @endif

               @if( $project->getField('customers_relationship') )
                  <div class="form-group">
                     <label>@lang('project.activities.customers_relationship')</label>
                     {!! nl2br($project->getField('customers_relationship')) !!}
                  </div>
               @endif

               @if( $project->getField('customers_recurrence') )
                  <div class="form-group">
                     <label>@lang('project.activities.customers_recurrence')</label>
                     {!! nl2br($project->getField('customers_recurrence')) !!}
                  </div>
               @endif

               @if( $customersDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $customersDocuments->count())</label>

                     @foreach( $customersDocuments as $document )
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
   | Market
   |--------------------------------------------------------------------------
   --}}
   @php $marketDocuments = $project->getDocuments('market_documents'); @endphp
   @if( $project->getField('target_market_presentation') || $project->getField('barriers_to_entry') || $project->competitors->count() > 0 || $marketDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.activities.market')</h2>

               @if( $project->getField('target_market_presentation') )
                  <div class="form-group">
                     <label>@lang('project.activities.target_market_presentation')</label>
                     {!! nl2br($project->getField('target_market_presentation')) !!}
                  </div>
               @endif

               @if( $project->competitors->count() > 0 )
                  <div class="form-group">
                     <label>@lang('project.activities.competitors')</label>

                     <div class="competitors">
                        @foreach( $project->competitors as $competitor )
                           <div class="competitor relationship">
                              <div class="title">{{ $competitor->name }}</div>
                              <p class="field">@lang('project.activities.competitor_turnover', ['amount' => number_format($competitor->turnover, 0, ',', ' ') .' '. $project->currency_symbol])</p>

                              {!! nl2br($competitor->description) !!}
                           </div>
                        @endforeach
                     </ol>
                  </div>
               @endif

               @if( $project->getField('barriers_to_entry') )
                  <div class="form-group">
                     <label>@lang('project.activities.barriers_to_entry')</label>
                     {!! nl2br($project->getField('barriers_to_entry')) !!}
                  </div>
               @endif

               @if( $marketDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $marketDocuments->count())</label>

                     @foreach( $marketDocuments as $document )
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
   @php $miscDocuments = $project->getDocuments('activities_misc_documents'); @endphp
   @if( $project->getField('activities_misc') || $miscDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('project.various_info')</h2>

               @if( $project->getField('activities_misc') )
                  <div class="form-group">
                     {!! nl2br($project->getField('activities_misc')) !!}
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
