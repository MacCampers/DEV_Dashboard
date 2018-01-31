@php $count = 0; @endphp
<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Activity description
   |--------------------------------------------------------------------------
   --}}

   @if( $project->getField('activity_description'))
      <section>
         <h2>@lang('fields.project.activities.activity_description')</h2>

         <div class="group">
            <p>{!! nl2br($project->getField('activity_description')) !!}</p>
         </div>

         @php $descriptionDocuments = $project->getDocuments('activities_description'); @endphp
         @if( $descriptionDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $descriptionDocuments->count())</label>
               @foreach( $descriptionDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Business model
   |--------------------------------------------------------------------------
   --}}
   @php $businessModelDocuments = $project->getDocuments('business_model'); @endphp
   @if( $project->getField('sales_channels') || $project->getField('client_types') || $project->getField('items_sold') || $project->getField('pricing_info') || $project->getField('particular_items') || $project->average_basket || $project->acquisition_cost || $businessModelDocuments->count() > 0 )
      <section>
         <h2>@lang('fields.project.activities.business_model')</h2>

         @if( $project->getField('sales_channels') )
            <div class="group">
               <label>@lang('project.activities.sales_channels')</label>
               <p>{!! nl2br($project->getField('sales_channels')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('client_types') )
            <div class="group">
               <label>@lang('project.activities.client_types')</label>
               <p>{!! nl2br($project->getField('client_types')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('items_sold') )
            <div class="group">
               <label>@lang('project.activities.items_sold')</label>
               <p>{!! nl2br($project->getField('items_sold')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('pricing_info') )
            <div class="group">
               <label>@lang('project.activities.pricing_info')</label>
               <p>{!! nl2br($project->getField('pricing_info')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('particular_items') )
            <div class="group">
               <label>@lang('project.activities.particular_items')</label>
               <p>{!! nl2br($project->getField('particular_items')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->average_basket )
            <div class="group">
               <p>@lang('project.activities.average_basket', ['amount' => number_format($project->average_basket, 0, ',', ' ') . ' ' . $project->currency_symbol])</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->acquisition_cost )
            <div class="group">
               <p>@lang('project.activities.acquisition_cost', ['amount' => number_format($project->acquisition_cost, 0, ',', ' ') . ' ' . $project->currency_symbol])</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $businessModelDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $businessModelDocuments->count())</label>
               @foreach( $businessModelDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Suppliers
   |--------------------------------------------------------------------------
   --}}
   @php $suppliersDocuments = $project->getDocuments('suppliers'); @endphp
   @if( $project->getField('suppliers_type') || $project->getField('suppliers_name') || $project->getField('suppliers_evolution_analysis') || $project->getField('suppliers_relationship') || $project->getField('suppliers_certification') || $suppliersDocuments->count() > 0 )
      <section>
         <h2>@lang('fields.project.activities.suppliers')</h2>

         @if( $project->getField('suppliers_type') )
            <div class="group">
               <label>@lang('project.activities.suppliers_type')</label>
               <p>{!! nl2br($project->getField('suppliers_type')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('suppliers_name') )
            <div class="group">
               <label>@lang('project.activities.suppliers_name')</label>
               <p>{!! nl2br($project->getField('suppliers_name')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('suppliers_evolution_analysis') )
            <div class="group">
               <label>@lang('project.activities.suppliers_evolution_analysis')</label>
               <p>{!! nl2br($project->getField('suppliers_evolution_analysis')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('suppliers_relationship') )
            <div class="group">
               <label>@lang('project.activities.suppliers_relationship')</label>
               <p>{!! nl2br($project->getField('suppliers_relationship')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('suppliers_certification') )
            <div class="group">
               <label>@lang('project.activities.suppliers_certification')</label>
               <p>{!! nl2br($project->getField('suppliers_certification')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $suppliersDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $suppliersDocuments->count())</label>

               @foreach( $suppliersDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Customers
   |--------------------------------------------------------------------------
   --}}
   @php $customersDocuments = $project->getDocuments('customers'); @endphp
   @if( $project->getField('customers_segmentation') || $project->getField('customers_names') || $project->getField('customers_analysis') || $project->getField('customers_relationship') || $project->getField('customers_recurrence') || $customersDocuments->count() > 0 )
      <section>
         <h2>@lang('fields.project.activities.customers')</h2>

         @if( $project->getField('customers_segmentation') )
            <div class="group">
               <label>@lang('project.activities.customers_segmentation')</label>
               <p>{!! nl2br($project->getField('customers_segmentation')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('customers_names') )
            <div class="group">
               <label>@lang('project.activities.customers_names')</label>
               <p>{!! nl2br($project->getField('customers_names')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('customers_analysis') )
            <div class="group">
               <label>@lang('project.activities.customers_analysis')</label>
               <p>{!! nl2br($project->getField('customers_analysis')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('customers_relationship') )
            <div class="group">
               <label>@lang('project.activities.customers_relationship')</label>
               <p>{!! nl2br($project->getField('customers_relationship')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('customers_recurrence') )
            <div class="group">
               <label>@lang('project.activities.customers_recurrence')</label>
               <p>{!! nl2br($project->getField('customers_recurrence')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $customersDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $customersDocuments->count())</label>

               @foreach( $customersDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Market
   |--------------------------------------------------------------------------
   --}}
   @php $marketDocuments = $project->getDocuments('market'); @endphp
   @if( $project->getField('target_market_presentation') || $project->getField('barriers_to_entry') || $project->competitors->count() > 0 || $marketDocuments->count() > 0 )
      <section>
         <h2>@lang('fields.project.activities.market')</h2>

         @if( $project->getField('target_market_presentation') )
            <div class="group">
               <label>@lang('project.activities.target_market_presentation')</label>
               <p>{!! nl2br($project->getField('target_market_presentation')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->competitors->count() > 0 )
            <div class="group">
               <label>@lang('project.activities.competitors')</label>

               <div class="multiple-items">
                  @foreach( $project->competitors as $competitor )
                     <div class="item">
                        <div class="title">{{ $competitor->name }}</div>
                        <p class="field">@lang('project.activities.competitor_turnover', ['amount' => number_format($competitor->turnover, 0, ',', ' ') .' '. $project->currency_symbol])</p>
                        <p>{!! nl2br($competitor->description) !!}</p>
                     </div>
                  @endforeach
               </div>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('barriers_to_entry') )
            <div class="group">
               <label>@lang('project.activities.barriers_to_entry')</label>
               <p>{!! nl2br($project->getField('barriers_to_entry')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $marketDocuments->count() > 0 )
            <div class="group">
               <label>@choice('fields.attached_documents', $marketDocuments->count())</label>

               @foreach( $marketDocuments as $document )
                  <div class="document">{{ $document->name }}</div>
               @endforeach
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
   @php $miscDocuments = $project->getDocuments('activities_misc'); @endphp
   @if( $project->getField('activities_misc') || $miscDocuments->count() > 0 )
      <section>
         <h2>@lang('project.various_info')</h2>

         @if( $project->getField('activities_misc') )
            <div class="group">
               <p>{!! nl2br($project->getField('activities_misc')) !!}</p>
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
