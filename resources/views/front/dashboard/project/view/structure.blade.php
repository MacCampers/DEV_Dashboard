<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | Shareholding details
   |--------------------------------------------------------------------------
   --}}
   @php $shareholdingDetails = $project->getDocument('shareholding_details'); @endphp
   @if( $project->shareholders->count() > 0 || $shareholdingDetails )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.shareholding_details')</h2>
            </div>
         </div>

         @if( $project->shareholders->count() > 0 )
            <div class="form-group">
               <div class="row">
                  <div class="col-12">
                     <label>@lang('project.structure.shareholders')</label>
                  </div>

                  <div class="shareholders">
                     @foreach( $project->shareholders as $shareholder )
                        <div class="col-4">
                           <div class="shareholder relationship">
                              <div class="title">{{ $shareholder->name }}</div>

                              <ul>
                                 @if( $shareholder->security_type_1 )
                                    <li><strong>{{ $shareholder->security_type_1 }}</strong> : {{ $shareholder->security_number_1 }}</li>
                                 @endif
                                 @if( $shareholder->security_type_2 )
                                    <li><strong>{{ $shareholder->security_type_2 }}</strong> : {{ $shareholder->security_number_2 }}</li>
                                 @endif
                                 @if( $shareholder->security_type_3 )
                                    <li><strong>{{ $shareholder->security_type_3 }}</strong> : {{ $shareholder->security_number_3 }}</li>
                                 @endif
                              </ul>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>
            </div>
         @endif

         @if( $shareholdingDetails )
            <div class="row">
               <div class="col-12">
                  <div class="form-group files">
                     <label>@lang('fields.project.structure.shareholding_details')</label>
                     <a class="button small red" href="{{ route('serve_document', ['id' => $shareholdingDetails->id]) }}" target="_blank">{{ $shareholdingDetails->name }}</a>
                  </div>
               </div>
            </div>
         @endif
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Corporate structure
   |--------------------------------------------------------------------------
   --}}
   @php $organizationStructureDocuments = $project->getDocuments('organization_structure_documents'); @endphp
   @if( $project->branches->count() > 0 || $project->getField('corporate_structure_description') || $organizationStructureDocuments )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.organization')</h2>

               @if( $project->branches->count() > 0 )
                  <div class="form-group">
                     <label>@lang('project.structure.branches')</label>

                     <div class="branches">
                        @foreach( $project->branches as $branch )
                           <div class="branch relationship">
                              <div class="title">{{ $branch->name }}</div>
                              <div class="field">
                                 {{ $branch->address_1 }}<br />
                                 @if( $branch->address_2 )
                                    {{ $branch->address_2 }}<br />
                                 @endif
                                 {{ $branch->zipcode }} {{ $branch->city }}<br />
                                 {{ $branch->country->name }}
                              </div>

                              <div class="field">@lang('project.structure.branch_registration_number', ['number' => $branch->registration_number])</label></div>
                              <div class="field">@lang('project.structure.branch_representative', ['name' => $branch->corporate_representative])</label></div>

                              @if( $branch->shareholding )
                                 <div class="field">
                                    <label>@lang('fields.project.structure.shareholding')</label>
                                    {!! nl2br($branch->shareholding) !!}
                                 </div>
                              @endif
                           </div>
                        @endforeach
                     </ol>
                  </div>
               @endif

               @if( $project->getField('corporate_structure_description') )
                  <div class="form-group">
                     <label>@lang('fields.project.structure.corporate_structure_description')</label>
                     {!! nl2br($project->getField('corporate_structure_description')) !!}
                  </div>
               @endif

               @if( $organizationStructureDocuments->count() > 0 )
                  <div class="form-group files">
                     <label>@choice('fields.attached_documents', $organizationStructureDocuments->count())</label>

                     @foreach( $organizationStructureDocuments as $document )
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
   | Last transactions
   |--------------------------------------------------------------------------
   --}}
   @if( $project->transactions->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.last_transactions')</h2>

               <div class="form-group">
                  <ol class="timeline">
                     @foreach( $project->transactions as $transaction )
                        <li class="event">
                           <div class="event-title">{{ $transaction->date }}</div>
                           <div class="field">{!! nl2br($transaction->context) !!}</div>
                        </li>
                     @endforeach
                  </ol>
               </div>
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Organization functioning
   |--------------------------------------------------------------------------
   --}}
   @php $functionalOrganization = $project->getDocument('functional_organization'); @endphp
   @if( $project->getField('organization_functioning') || $functionalOrganization )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.team_presentation')</h2>

               @if( $project->getField('organization_functioning') )
                  <div class="form-group">
                     <label>@lang('project.structure.organization_functioning')</label>
                     {!! nl2br($project->getField('organization_functioning')) !!}
                  </div>
               @endif

               @if( $functionalOrganization )
                  <div class="form-group files">
                     <label>@lang('fields.project.structure.functional_organization')</label>
                     <a class="button small red" href="{{ route('serve_document', ['id' => $functionalOrganization->id]) }}" target="_blank">{{ $functionalOrganization->name }}</a>
                  </div>
               @endif
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Managers
   |--------------------------------------------------------------------------
   --}}
   @if( $project->managers->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.managers_resume')</h2>

               <div class="managers">
                  @foreach( $project->managers as $manager )
                     <div class="manager relationship">
                        <div class="title">{{ $manager->name }}</div>
                        <div class="subtitle">{{ $manager->position }}</div>

                        <div class="field">{!! nl2br($manager->description) !!}</div>

                        @if( $manager->url )
                           <a class="button small blue" href="{{ $manager->url }}" target="_blank">@lang('project.structure.manager_profile')</a>
                        @endif

                        @if( $manager->resume )
                           <a class="button small red" href="{{ route('serve_document', ['id' => $manager->resume->id]) }}" target="_blank">@lang('project.structure.download_resume')</a>
                        @endif
                     </div>
                  @endforeach
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
   @php $miscDocuments = $project->getDocuments('structure_misc_documents'); @endphp
   @if( $project->getField('organization_misc') || $miscDocuments->count() > 0 )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('project.various_info')</h2>

               @if( $project->getField('organization_misc') )
                  <div class="form-group">
                     {!! nl2br($project->getField('organization_misc')) !!}
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
