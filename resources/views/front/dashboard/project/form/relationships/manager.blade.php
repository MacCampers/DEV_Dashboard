<li class="item">
   <div class="delete" data-items="managers">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('managers.'. $i .'.name') ? ' has-error' : '' }}">
            <label for="managers-{{ $i }}-name">@lang('fields.project.structure.manager_name')</label>
            <input type="text" id="managers-{{ $i }}-name" name="managers[{{ $i }}][name]" placeholder="@lang('fields.project.structure.manager_name')" value="{{ old('managers.'. $i .'.name', isset($manager) ? $manager->name : '') }}" autocomplete="off" />

            @if( $errors->has('managers.'. $i .'.name') )
               <p class="form-error">{{ $errors->first('managers.'. $i .'.name') }}</p>
            @endif
         </div>
      </div>

      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('managers.'. $i .'.position') ? ' has-error' : '' }}">
            <label for="managers-{{ $i }}-position">@lang('fields.project.structure.manager_position')</label>
            <input type="text" id="managers-{{ $i }}-position" name="managers[{{ $i }}][position]" placeholder="@lang('fields.project.structure.manager_position')" value="{{ old('managers.'. $i .'.position', isset($manager) ? $manager->position : '') }}" autocomplete="off"/>

            @if( $errors->has('managers.'. $i .'.position') )
               <p class="form-error">{{ $errors->first('managers.'. $i .'.position') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-12">
         <div class="form-group{{ $errors->has('managers.'. $i .'.description') ? ' has-error' : '' }}">
            <label for="managers-{{ $i }}-description">@lang('fields.project.structure.manager_description')</label>
            <div class="hint">@lang('fields.project.structure.manager_description_hint')</div>
            <textarea id="managers-{{ $i }}-description" name="managers[{{ $i }}][description]" placeholder="@lang('fields.project.structure.manager_description')" maxlength="5000">{{ old('managers.'. $i .'.description', isset($manager) ? $manager->description : '') }}</textarea>
            <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

            @if( $errors->has('managers.'. $i .'.description') )
               <p class="form-error">{{ $errors->first('managers.'. $i .'.description') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('managers.'. $i .'.url') ? ' has-error' : '' }}">
            <label for="managers-{{ $i }}-url">@lang('fields.project.structure.manager_url')</label>
            <input type="url" id="managers-{{ $i }}-position" name="managers[{{ $i }}][url]" placeholder="@lang('fields.project.structure.manager_url_hint')" value="{{ old('managers.'. $i .'.url', isset($manager) ? $manager->url : '') }}" autocomplete="off"/>

            @if( $errors->has('managers.'. $i .'.url') )
               <p class="form-error">{{ $errors->first('managers.'. $i .'.url') }}</p>
            @endif
         </div>
      </div>

      <div class="col-12">
         <div class="form-group{{ $errors->has('managers.'. $i .'.resume') ? ' has-error' : '' }}">
            <label>@lang('fields.project.structure.managers_resume_upload')</label>
            <div class="hint">@lang('fields.pdf_only')</div>

            <div class="single-file row">
               @if( isset($manager) && isset($manager->resume) && $manager->resume )
                  <div class="file-input">
                     <input type="hidden" name="managers[{{ $i }}][old_resume]" value="{{ $manager->resume->id }}" />
                     <input type="file" id="managers-{{ $i }}-resume" class="uploaded" name="managers[{{ $i }}][resume]" data-name="managers_resume" data-id="{{ $manager->resume->id }}" disabled />
                     <label for="managers-{{ $i }}-resume" class="button small" data-default="@lang('fields.upload_file')"><a href="{{ route('serve_document', ['id' => $manager->resume->id]) }}" target="_blank">{{ $manager->resume->name }}</a></label>
                     <div class="delete-file icon-delete"></div>
                  </div>
               @else
                  <div class="file-input">
                     <input type="file" id="managers-{{ $i }}-resume" class="no-upload" name="managers[{{ $i }}][resume]" data-name="managers_resume" accept="application/pdf" />
                     <label for="managers-{{ $i }}-resume" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                     <div class="delete-file icon-delete"></div>
                  </div>
               @endif
            </div>

            @if( $errors->has('managers.'. $i .'.resume') )
               <p class="form-error">{{ $errors->first('managers.'. $i .'.resume') }}</p>
            @endif
         </div>
      </div>
   </div>
</li>
