{{-- <div class="summary">
   <div id="summary-project">
      <ol>
         <li><a href="#C1">@lang('fields.project.list.shareholder')</a></li>
         <li><a href="#C2">@lang('fields.project.list.organization')</a></li>
         <li><a href="#C3">@lang('fields.project.list.transactions')</a></li>
         <li><a href="#C4">@lang('fields.project.list.team')</a></li>
         <li><a href="#C5">@lang('fields.project.synthesis.various')</a></li>
      </ol>
   </div>
</div> --}}
<form id="project-form" autocomplete="off" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'structure']) }}" enctype="multipart/form-data" />
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
      | Shareholding details
      |--------------------------------------------------------------------------
      --}}
      <section id="C1">
         <div class="row">
            <div class="col-6 lg-12 align-right float-right">
               @include('front.dashboard.partials.switch')
            </div>

            <div class="col-6 lg-12">
               <h2>@lang('fields.project.structure.shareholding_details')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required">
                  <label>@lang('fields.project.structure.shareholders_list')</label>
                  <div class="hint">@lang('fields.project.structure.shareholders_list_hint')</div>
               </div>
            </div>
         </div>

         <ol id="shareholders" class="multiple-items">
            @php $i = 0; @endphp

            @if( sizeof(old('shareholders')) > 1 )
               @foreach( old('shareholders') as $shareholder )
                  @php $shareholder = (object) $shareholder; @endphp
                  @include('front.dashboard.project.form.relationships.shareholder')
                  @php $i++; @endphp
               @endforeach
            @elseif( $project->shareholders->count() > 0 )
               @foreach( $project->shareholders as $shareholder )
                  @include('front.dashboard.project.form.relationships.shareholder')
                  @php $i++; @endphp
               @endforeach
            @else
               @include('front.dashboard.project.form.relationships.shareholder')
            @endif
         </ol>

         <div class="row">
            <div class="col-4 lg-12">
               <div class="button blue add-item small" id="add_shareholder" data-items="shareholders">@lang('buttons.add_shareholder')</div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('shareholding_details_documents') ? ' has-error' : '' }}">
                  <label for="shareholding-details-documents">@lang('fields.project.structure.shareholding_details')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $i = 0; @endphp
                     @foreach( $project->getDocuments('shareholding_details_documents') as $document )
                        <div class="file-input">
                           <input type="file" id="shareholding-details-document-{{ $i }}" class="uploaded" name="shareholding_details_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="shareholding-details-document-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>

                        @php $i++; @endphp
                     @endforeach

                     @if( $i < 5 )
                        <div class="file-input">
                           <input type="file" id="shareholding-details-document-{{ $i }}" name="shareholding_details_documents[]" {{ $project->locked ? ' disabled' : '' }}/>
                           <label for="shareholding-details-document-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('shareholding_details_documents') )
                     <p class="form-error">{{ $errors->first('shareholding_details_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Corporate structure
      |--------------------------------------------------------------------------
      --}}
      <section id="C2">
         <div class="row optional">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.structure.organization')</h2>
            </div>
         </div>

         <div class="optional">
            <div class="row">
               <div class="col-12">
                  <p>@lang('fields.project.structure.organization_hint')</p>
               </div>
            </div>

            <ol id="branches" class="multiple-items">
               @php $i = 0; @endphp

               @if( sizeof(old('branches')) > 0 )
                  @foreach( old('branches') as $branch )
                     @php $branch = (object) $branch; @endphp
                     @include('front.dashboard.project.form.relationships.branch')
                     @php $i++; @endphp
                  @endforeach
               @elseif( $project->branches->count() > 0 )
                  @foreach( $project->branches as $branch )
                     @include('front.dashboard.project.form.relationships.branch')
                     @php $i++; @endphp
                  @endforeach
               @else
                  @include('front.dashboard.project.form.relationships.branch')
               @endif
            </ol>

            <div class="row">
               <div class="col-4 lg-12">
                  <div class="button blue small add-item" id="add-branch" data-items="branches">@lang('buttons.add_branch')</div>
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('corporate_structure_description') ? ' has-error' : '' }}">
                  <label for="corporate-structure-description">@lang('fields.project.structure.corporate_structure_description')</label>
                  <div class="hint">@lang('fields.project.structure.corporate_structure_description_hint')</div>
                  <textarea id="corporate-structure-description" maxlength="5000" name="corporate_structure_description" placeholder="@lang('fields.project.structure.corporate_structure_description')"{{ $project->locked ? ' disabled' : '' }}>{{ old('corporate_structure_description', $project->getField('corporate_structure_description')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('corporate_structure_description') )
                     <p class="form-error">{{ $errors->first('corporate_structure_description') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row optional">
            <div class="col-12">
               <div class="form-group{{ $errors->has('organization_structure_documents') ? ' has-error' : '' }}">
                  <label for="misc-documents">@lang('fields.attach_document')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $i = 0; @endphp
                     @foreach( $project->getDocuments('organization_structure_documents') as $document )
                        <div class="file-input">
                           <input type="file" id="organization-structure-documents-{{ $i }}" class="uploaded" name="organization_structure_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="organization-structure-documents-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>

                        @php $i++; @endphp
                     @endforeach

                     @if( $i < 5 )
                        <div class="file-input">
                           <input type="file" id="organization-structure-documents-{{ $i }}" name="organization_structure_documents[]"{{ $project->locked ? ' disabled' : '' }} />
                           <label for="organization-structure-documents-{{ $i }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('organization_structure_documents') )
                     <p class="form-error">{{ $errors->first('organization_structure_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Last transactions
      |--------------------------------------------------------------------------
      --}}
      <section id="C3" class="optional">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.last_transactions')</h2>
               <p>@lang('fields.project.structure.last_transactions_subtitles')</p>
            </div>
         </div>

         <ol id="transactions" class="multiple-items">
            @php $i = 0; @endphp

            @if( sizeof(old('transactions')) > 0 )
               @foreach( old('transactions') as $transaction )
                  @php $transaction = (object) $transaction; @endphp
                  @include('front.dashboard.project.form.relationships.transaction')
                  @php $i++; @endphp
               @endforeach
            @elseif( $project->transactions->count() > 0 )
               @foreach( $project->transactions as $transaction )
                  @include('front.dashboard.project.form.relationships.transaction')
                  @php $i++; @endphp
               @endforeach
            @else
               @include('front.dashboard.project.form.relationships.transaction')
            @endif
         </ol>

         <div class="row">
            <div class="col-4 lg-12">
               <div class="button blue add-item small" id="add-transaction" data-items="transactions">@lang('buttons.add_transaction')</div>
            </div>
         </div>
      </section>

      {{--
      |--------------------------------------------------------------------------
      | Organization functioning
      |--------------------------------------------------------------------------
      --}}
      <section id="C4">
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.structure.team_presentation')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('organization_functioning') ? ' has-error' : '' }}">
                  <label for="organization-functioning">@lang('fields.project.structure.organization_functioning')</label>
                  <textarea id="organization-functioning" maxlength="5000" name="organization_functioning" placeholder="@lang('fields.project.structure.organization_functioning_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('organization_functioning', $project->getField('organization_functioning')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('organization_functioning') )
                     <p class="form-error">{{ $errors->first('organization_functioning') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="optional">
            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('functional_organization') ? ' has-error' : '' }}">
                     <label for="functional_organization">@lang('fields.project.structure.functional_organization')</label>
                     <div class="hint">@lang('fields.document_mimes')</div>

                     <div class="single-file row">
                        @php $functionalOrganization = $project->getDocument('functional_organization'); @endphp

                        @if( $functionalOrganization )
                           <div class="file-input">
                              <input type="file" id="functional-organization-document" class="uploaded" name="functional_organization" data-id="{{ $functionalOrganization->id }}" disabled />
                              <label for="functional-organization-document" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $functionalOrganization->id]) }}" target="_blank">{{ $functionalOrganization->name }}</a></label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @else
                           <div class="file-input">
                              <input type="file" id="functional-organization-document" name="functional_organization" {{ $project->locked ? ' disabled' : '' }}/>
                              <label for="functional-organization-document" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                              <div class="delete-file icon-delete"></div>
                           </div>
                        @endif
                     </div>

                     @if( $errors->has('functional_organization') )
                        <p class="form-error">{{ $errors->first('functional_organization') }}</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Managers
      |--------------------------------------------------------------------------
      --}}
      <section id="C4" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.structure.managers_resume')</h2>
            </div>
         </div>

         <ol id="managers" class="multiple-items">
            @php $i = 0; @endphp

            @if( sizeof(old('managers')) > 0 )
               @foreach( old('managers') as $manager )
                  @php $manager = (object) $manager; @endphp
                  @include('front.dashboard.project.form.relationships.manager')
                  @php $i++; @endphp
               @endforeach
            @elseif( sizeof($project->managers) > 0 )
               @foreach( $project->managers as $manager )
                  @include('front.dashboard.project.form.relationships.manager')
                  @php $i++; @endphp
               @endforeach
            @else
               @include('front.dashboard.project.form.relationships.manager')
            @endif
         </ol>

         <div class="row">
            <div class="col-4 lg-12">
               <div class="button blue add-item small" id="add-manager" data-items="managers">@lang('buttons.add_manager')</div>
            </div>
         </div>
      </section>


      {{--
      |--------------------------------------------------------------------------
      | Various
      |--------------------------------------------------------------------------
      --}}
      <section id="C5" class="optional">
         <div class="row">
            <div class="col-6 lg-12">
               <h2>@lang('fields.project.synthesis.various')</h2>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group {{ $errors->has('organization_misc') ? ' has-error' : '' }}">
                  <label for="organization-misc">@lang('fields.project.structure.organization_misc')</label>
                  <textarea id="organization-misc" maxlength="5000" name="organization_misc" placeholder="@lang('fields.project.structure.organization_misc_placeholder')"{{ $project->locked ? ' disabled' : '' }}>{{ old('organization_misc', $project->getField('organization_misc')) }}</textarea>
                  <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                  @if( $errors->has('organization_misc') )
                     <p class="form-error">{{ $errors->first('organization_misc') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('structure_misc_documents') ? ' has-error' : '' }}">
                  <label for="strucutre-misc-documents">@lang('fields.attach_document')</label>
                  <div class="hint">@lang('fields.max_documents', ['max' => 5])</div>

                  <div class="files-group row" data-max="5">
                     @php $miscDocuments = $project->getDocuments('structure_misc_documents'); @endphp
                     @foreach( $miscDocuments as $document )
                        <div class="file-input">
                           <input type="file" id="structure-misc-documents-{{ $loop->index }}" class="uploaded" name="structure_misc_documents[]" data-id="{{ $document->id }}" disabled />
                           <label for="structure-misc-documents-{{ $loop->index }}" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a></label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endforeach

                     @if( $miscDocuments->count() < 5 )
                        <div class="file-input">
                           <input type="file" id="structure-misc-documents-{{ $miscDocuments->count() }}" name="structure_misc_documents[]" {{ $project->locked ? ' disabled' : '' }}/>
                           <label for="structure-misc-documents-{{ $miscDocuments->count() }}" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     @endif
                  </div>

                  @if( $errors->has('structure_misc_documents') )
                     <p class="form-error">{{ $errors->first('structure_misc_documents') }}</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      <section>
         <div class="row">
            <div class="col-12 align-center">
               <input type="hidden" id="files-to-remove" name="files_to_remove" value="" />
               <input type="submit" class="blue button-save" value="@lang('buttons.save')" {{ $project->locked ? ' disabled' : '' }} />
            </div>
            <div class="col-12 align-center">
               <a class="link" href="{{ route('project_preview', ['id' => $project->id, 'step' => 'structure']) }}" target="_blank">@lang('buttons.preview')</a>
            </div>
         </div>
      </section>
   </div>
</form>
