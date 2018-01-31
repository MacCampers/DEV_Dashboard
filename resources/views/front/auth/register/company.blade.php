<div class="row">
   <div class="col-12">
      <div class="form-group required" data-name="company_name">
         <label for="company-name">@lang('fields.company_name')</label>
         <input type="text" id="company-name" name="company_name" placeholder="@lang('fields.company_name')" value="{{ old('company_name') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group required" data-name="company_registration_number">
         <label for="company-registration-number">@lang('fields.registration_number')</label>
         <input type="text" id="company-registration-number" name="company_registration_number" placeholder="@lang('fields.registration_number')" value="{{ old('company_registration_number') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group required" data-name="company_address">
         <label for="company-address">@lang('fields.address')</label>
         <input type="text" id="company-address" name="company_address" placeholder="@lang('fields.address_placeholder')" value="{{ old('company_address') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6 s-12">
      <div class="form-group">
         <label for="company-address-2">@lang('fields.address_2')</label>
         <input type="text" id="company-address-2" name="company_address_2" placeholder="@lang('fields.address_2_placeholder')" value="{{ old('company_address_2') }}" />
      </div>
   </div>

   <div class="col-6 s-12">
      <div class="form-group" data-name="company_phone">
         <label for="company-phone">@lang('fields.phone')</label>
         <input type="text" id="company-phone" name="company_phone" class="phone-number" placeholder="@lang('fields.phone')" value="{{ old('company_phone') }}" />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-4">
      <div class="form-group required" data-name="company_zipcode">
         <label for="company-zipcode">@lang('fields.zipcode')</label>
         <input type="text" id="company-zipcode" name="company_zipcode" placeholder="@lang('fields.zipcode')" value="{{ old('company_zipcode') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
   <div class="col-8">
      <div class="form-group required" data-name="company_city">
         <label for="company-city">@lang('fields.city')</label>
         <input type="text" id="company-city" name="company_city" placeholder="@lang('fields.city')" value="{{ old('company_city') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6">
      <div class="form-group required" data-name="company_country_id">
         <label for="company-country-id">@lang('fields.country')</label>
         <select id="company-country-id" class="country-selector" name="company_country_id" data-regions="company-region-id" required>
            @foreach( $countries as $country )
               <option value="{{ $country->id }}"{{ $country->id == old('company_country_id', 69) ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
            @endforeach
         </select>

         <div class="form-error"></div>
      </div>
   </div>

   <div class="col-6 s-12">
      <div class="form-group" data-name="company_region_id">
         <label for="company-region-id">@lang('fields.region')</label>
         <select id="company-region-id" class="region-selector" name="company_region_id">
            <option value="">@lang('fields.region_placeholder')</option>
            @foreach( $regions as $region )
               <option value="{{ $region->id }}"{{ $region->id == old('company_region_id') ? ' selected' : '' }} data-country="{{ $region->parent }}">@lang('zones.region.'.$region->code)</option>
            @endforeach
         </select>

         <div class="form-error"></div>
      </div>
   </div>
</div>
