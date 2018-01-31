@php $count = 0; @endphp
<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Shareholding details
   |--------------------------------------------------------------------------
   --}}
   @php $shareholdingDetails = $project->getDocument('shareholding_details'); @endphp
   @if( $project->shareholders->count() > 0 || $shareholdingDetails )
      <section>
         <h2>@lang('fields.project.structure.shareholding_details')</h2>

         @if( $project->shareholders->count() > 0 )
            <div class="group">
               <label>@lang('project.structure.shareholders')</label>

               <div class="multiple-items">
                  @foreach( $project->shareholders as $shareholder )
                     <div class="item">
                        <div class="title">{{ $shareholder->name }}</div>
                        @if( $shareholder->security_type_1 )
                           <p><strong>{{ $shareholder->security_type_1 }}</strong> : {{ $shareholder->security_number_1 }}</p>
                        @endif
                        @if( $shareholder->security_type_2 )
                           <p><strong>{{ $shareholder->security_type_2 }}</strong> : {{ $shareholder->security_number_2 }}</p>
                        @endif
                        @if( $shareholder->security_type_3 )
                           <p><strong>{{ $shareholder->security_type_3 }}</strong> : {{ $shareholder->security_number_3 }}</p>
                        @endif
                     </div>
                  @endforeach
               </div>
            </div>

            @php $count++; @endphp
         @endif

         @if( $shareholdingDetails )
            <div class="group">
               <label>@lang('fields.project.structure.shareholding_details')</label>
               <p>{{ $shareholdingDetails->name }}</p>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Corporate structure
   |--------------------------------------------------------------------------
   --}}
   @php $organizationStructure = $project->getDocument('organization_structure'); @endphp
   @if( $project->branches->count() > 0 || $project->getField('corporate_structure_description') || $organizationStructure )
      <section>
         <h2>@lang('fields.project.structure.organization')</h2>

         @if( $project->branches->count() > 0 )
            <div class="group">
               <label>@lang('project.structure.branches')</label>

               <div class="multiple-items">
                  @foreach( $project->branches as $branch )
                     <div class="item">
                        <div class="title">{{ $branch->name }}</div>
                        <p class="field">
                           {{ $branch->address_1 }}<br />
                           {!! $branch->address_2 ? $branch->address_2.'<br />' : '' !!}
                           {{ $branch->zipcode }} {{ $branch->city }}<br />
                           {{ $branch->country->name }}
                        </p>
                        <p class="field">@lang('project.structure.branch_registration_number', ['number' => $branch->registration_number])</p>
                        <p class="field">@lang('project.structure.branch_representative', ['name' => $branch->corporate_representative])</p>
                        @if( $branch->shareholding )
                           <label>@lang('fields.project.structure.shareholding')</label>
                           <p>{!! nl2br($branch->shareholding) !!}</p>
                        @endif
                     </div>
                  @endforeach
               </div>
            </div>

            @php $count++; @endphp
         @endif

         @if( $project->getField('corporate_structure_description') )
            <div class="group">
               <label>@lang('fields.project.structure.corporate_structure_description')</label>
               <p>{!! nl2br($project->getField('corporate_structure_description')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $organizationStructure )
            <div class="group">
               <label>@lang('fields.project.structure.organization')</label>
               <p>{{ $organizationStructure->name }}</p>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Last transactions
   |--------------------------------------------------------------------------
   --}}

   @if( $project->transactions->count() > 0 )
      <section>
         <h2>@lang('fields.project.structure.last_transactions')</h2>

         <div class="group">
            <ol class="timeline">
               @foreach( $project->transactions as $transaction )
                  <li class="event">
                     <div class="event-name">{{ $transaction->date }}</div>
                     <p>{!! nl2br($transaction->context) !!}</p>
                  </li>
               @endforeach
            </ol>
         </div>
      </section>

      @php $count++; @endphp
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Organization functioning
   |--------------------------------------------------------------------------
   --}}
   @php $functionalOrganization = $project->getDocument('functional_organization'); @endphp
   @if( $project->getField('organization_functioning') || $functionalOrganization )
      <section>
         <h2>@lang('fields.project.structure.team_presentation')</h2>

         @if( $project->getField('organization_functioning') )
            <div class="group">
               <label>@lang('project.structure.organization_functioning')</label>
               <p>{!! nl2br($project->getField('organization_functioning')) !!}</p>
            </div>

            @php $count++; @endphp
         @endif

         @if( $functionalOrganization )
            <div class="group">
               <label>@lang('fields.project.structure.functional_organization')</label>
               <p>{{ $functionalOrganization->name }}</p>
            </div>

            @php $count++; @endphp
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Managers
   |--------------------------------------------------------------------------
   --}}
   @if( $project->managers->count() > 0 )
      <section>
         <h2>@lang('fields.project.structure.managers_resume')</h2>

         <div class="group">
            <div class="multiple-items">
               @foreach( $project->managers as $manager )
                  <div class="item">
                     <div class="title">{{ $manager->name }} ({{ $manager->position }})</div>
                     <p class="field">{!! nl2br($manager->description) !!}</p>

                     @if( $manager->resume )
                        <label>@lang('fields.project.structure.managers_resume_hint')</label>
                        <div class="document">{{ $manager->resume->name }}</div>
                     @endif
                  </div>
               @endforeach
            </div>
         </div>
      </section>

      @php $count++; @endphp
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Miscellaneous
   |--------------------------------------------------------------------------
   --}}
   @php $miscDocuments = $project->getDocuments('structure_misc'); @endphp
   @if( $project->getField('organization_misc') || $miscDocuments->count() > 0 )
      <section>
         <h2>@lang('project.various_info')</h2>

         @if( $project->getField('organization_misc') )
            <div class="group">
               <p>{!! nl2br($project->getField('organization_misc')) !!}</p>
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
