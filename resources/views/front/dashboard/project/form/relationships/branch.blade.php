<li class="item">
   <div class="delete" data-items="branches">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.name') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-name">@lang('fields.company_description')</label>
            <input type="text" id="branches-{{ $i }}-name" name="branches[{{ $i }}][name]" placeholder="@lang('fields.project.synthesis.company_name')" value="{{ old('branches.'. $i .'.name', isset($branch) ? $branch->name : '') }}" autocomplete="off"/>

            @if( $errors->has('branches.'. $i .'.name') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.name') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.registration_number') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-registration-number">@lang('fields.registration_number')</label>
            <input type="text" id="branches-{{ $i }}-registration_number" name="branches[{{ $i }}][registration_number]" placeholder="@lang('fields.project.synthesis.company_registration_hint')" value="{{ old('branches.'. $i .'.registration_number', isset($branch) ? $branch->registration_number : '') }}" autocomplete="off"/>

            @if( $errors->has('branches.'. $i .'.registration_number') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.registration_number') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.address_1') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-address-1">@lang('fields.address')</label>
            <input type="text" id="branches-{{ $i }}-address-1" name="branches[{{ $i }}][address_1]" placeholder="@lang('fields.project.synthesis.company_address_placeholder')" value="{{ old('branches.'. $i .'.address_1', isset($branch) ? $branch->address_1 : '') }}" autocomplete="off"/>

            @if( $errors->has('branches.'. $i .'.address_1') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.address_1') }}</p>
            @endif
         </div>
      </div>
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.address_2') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-address-2">&nbsp;</label>
            <input type="text" id="branches-{{ $i }}-address_2" name="branches[{{ $i }}][address_2]" placeholder="@lang('fields.address_2')" value="{{ old('branches.'. $i .'.address_2', isset($branch) ? $branch->address_2 : '') }}" autocomplete="off"/>

            @if( $errors->has('competitors.'. $i .'.address_2') )
               <p class="form-error">{{ $errors->first('competitors.'. $i .'.address_2') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-2 lg-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.zipcode') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-zipcode">@lang('fields.zipcode')</label>
            <input type="number" id="branches-{{ $i }}-zipcode" name="branches[{{ $i }}][zipcode]" placeholder="@lang('fields.project.synthesis.company_zipcode')" value="{{ old('branches.'. $i .'.zipcode', isset($branch) ? $branch->zipcode : '') }}" autocomplete="off"/>

            @if( $errors->has('branches.'. $i .'.zipcode') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.zipcode') }}</p>
            @endif
         </div>
      </div>
      <div class="col-4 lg-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.city') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-city">@lang('fields.city')</label>
            <input type="text" id="branches-{{ $i }}-city" name="branches[{{ $i }}][city]" placeholder="@lang('fields.project.synthesis.company_city')" value="{{ old('branches.'. $i .'.city', isset($branch) ? $branch->city : '') }}" autocomplete="off"/>


            @if( $errors->has('branches.'. $i .'.city') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.city') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.country_id') ? ' has-error' : '' }}" data-name="branches[{{ $i }}][country_id]">
            <label for="branches-{{ $i }}-country-id">@lang('fields.country')</label>
            <select id="branches-{{ $i }}-country-id" class="country-selector" name="branches[{{ $i }}][country_id]" data-regions="branches-{{ $i }}-region-id">
               @foreach( $countries as $country )
                  <option value="{{ $country->id }}"{{ $country->id === old('company_country_id', $project->company_country_id ? $project->company_country_id : 69) ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
               @endforeach
            </select>

            @if( $errors->has('branches.'. $i .'.country_id') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.country_id') }}</p>
            @endif
         </div>
      </div>

      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.region_id') ? ' has-error' : '' }}" data-name="branches[{{ $i }}][region_id]">
            <label for="branches-{{ $i }}-region-id">@lang('fields.region')</label>
            <select id="branches-{{ $i }}-region-id" class="region-selector" name="branches[{{ $i }}][region_id]">
               <option value="">@lang('fields.region_placeholder')</option>
               @foreach( $regions as $region )
                  <option value="{{ $region->id }}"{{ $region->id === old('company_region_id', null) ? ' selected' : '' }} data-country="{{ $region->parent }}">@lang('zones.region.'.$region->code)</option>
               @endforeach
            </select>

            @if( $errors->has('branches.'. $i .'.region_id') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.region_id') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.corporate_representative') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-corporate-representative">@lang('fields.project.structure.corporate_representative')</label>
            <input type="text" id="branches-{{ $i }}-corporate-representative" name="branches[{{ $i }}][corporate_representative]" placeholder="@lang('fields.project.structure.corporate_representative')" value="{{ old('branches.'. $i .'.corporate_representative', isset($branch) ? $branch->corporate_representative : '') }}" autocomplete="off"/>

            @if( $errors->has('branches.'. $i .'.corporate_representative') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.corporate_representative') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-12">
         <div class="form-group{{ $errors->has('branches.'. $i .'.shareholding') ? ' has-error' : '' }}">
            <label for="branches-{{ $i }}-shareholding">@lang('fields.project.structure.shareholding')</label>
            <textarea id="branches-{{ $i }}-shareholding" name="branches[{{ $i }}][shareholding]" placeholder="@lang('fields.project.structure.shareholding')" maxlength="5000">{{ old('branches.'. $i .'.shareholding', isset($branch) ? $branch->shareholding : '') }}</textarea>
            <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

            @if( $errors->has('branches.'. $i .'.shareholding') )
               <p class="form-error">{{ $errors->first('branches.'. $i .'.shareholding') }}</p>
            @endif
         </div>
      </div>
   </div>
</li>
