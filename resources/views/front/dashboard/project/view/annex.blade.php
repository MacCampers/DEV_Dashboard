<div class="container">
   @if( count($errors) > 0 )
      @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
   @endif

   <div id="annex-view">
      @if( Auth::user()->type !== 'investor' )
         <form method="post" action="{{ route('annex_documents', ['id' => $project->id]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
               <div class="col-12">
                  <h2>@lang('fields.annex_document')</h2>

                  <div class="form-group required{{ $errors->has('annex_document') ? ' has-error' : '' }}">
                     <label for="annex-document">@lang('fields.annex_hint')</label>
                     <div class="hint">@lang('fields.document_mimes')</div>
                     <div class="single-file row">
                        <div class="file-input">
                           <input type="file" id="annex-document" name="annex_document" />
                           <label for="annex-document" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                           <div class="delete-file icon-delete"></div>
                        </div>
                     </div>
                     @if( $errors->has('annex_document') )
                        <p class="form-error">{{ $errors->first('annex_document') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-6 m-12">
                  <div class="form-group required">
                     <label for="section-id">@lang('fields.annex_section')</label>
                     <select id="section-id" name="annex_section">
                        <option value="synthesis">@lang('dashboard.project.synthesis')</option>
                        <option value="activities">@lang('dashboard.project.activities')</option>
                        <option value="structure">@lang('dashboard.project.structure')</option>
                        <option value="elements">@lang('dashboard.project.elements')</option>
                        <option value="business_plan">@lang('dashboard.project.business_plan')</option>
                     </select>
                  </div>
               </div>

               <div class="col-12">
                  <div class="form-group{{ $errors->has('annex_comment') ? ' has-error' : '' }}">
                     <label for="synthesis-various">@lang('fields.annex_comment')</label>
                     <textarea id="annex_comment" name="annex_comment" maxlength="5000" placeholder="@lang('fields.project.synthesis.various_info_placeholder')"></textarea>
                     <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</span></div>

                     @if( $errors->has('annex_comment') )
                        <p class="form-error">{{ $errors->first('annex_comment') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-12 align-center">
                  <input type="hidden" id="files-to-remove" name="files_to_remove" value="" />
                  <input type="submit" class="blue button-save small" value="@lang('buttons.save')" />
               </div>
            </div>
         </form>
      @endif

      @php $folders = ['synthesis', 'activities', 'structure', 'elements', 'business_plan']; @endphp

      @foreach( $folders as $folder )
         @php $annexes = $project->getDocuments($folder.'_annex')->sortByDesc('created_at'); @endphp

         @if( $annexes->count() > 0 )
            <section class="row">
               <div class="col-12">
                  <h2>@lang('dashboard.project.'.$folder)</h2>

                  @foreach( $annexes as $document )
                     <div class="document">
                        <strong>@lang('common.datetime', ['date' => date('d/m/Y', strtotime($document->created_at)), 'time' => date('H:i', strtotime($document->created_at))])</strong><br />
                        @if( $document->document_comments->comment )
                           <div class="comment">{!! nl2br($document->document_comments->comment ? $document->document_comments->comment : '') !!}</div>
                        @endif

                        <a class="button small red" href="{{ route('serve_document', ['id' => $document->id]) }}" target="_blank">{{ $document->name }}</a>
                     </div>
                  @endforeach
               </div>
            </section>
         @endif
      @endforeach
   </div>
</div>
