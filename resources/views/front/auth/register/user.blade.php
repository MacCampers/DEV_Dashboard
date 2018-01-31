<div class="row">
   <div class="col-4 s-6">
      <div class="form-group required" data-name="user_title">
         <label for="user-title">@lang('fields.title')</label>
         <select id="user-title" name="user_title" required>
            <option value="M.">M.</option>
            <option value="Mme">Mme</option>
            <option value="Mlle">Mlle</option>
         </select>

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6 s-12">
      <div class="form-group required" data-name="user_first_name">
         <label for="user-first-name">@lang('fields.first_name')</label>
         <input type="text" id="user-first-name" name="user_first_name" placeholder="@lang('fields.first_name')" value="{{ old('user_first_name') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
   <div class="col-6 s-12">
      <div class="form-group required" data-name="user_last_name">
         <label for="user-last-name">@lang('fields.last_name')</label>
         <input type="text" id="user-last-name" name="user_last_name" placeholder="@lang('fields.last_name')" value="{{ old('user_last_name') }}"  required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6 s-12">
      <div class="form-group" data-name="user_phone_mobile">
         <label for="user-phone-mobile">@lang('fields.phone_mobile')</label>
         <input type="tel" id="user-phone-mobile" name="user_phone_mobile" class="phone-number" value="{{ old('user_phone_mobile') }}" />

         <div class="form-error"></div>
      </div>
   </div>

   <div class="col-6 s-12">
      <div class="form-group" data-name="user_birth_date">
         <label for="user-birthdate">@lang('fields.birth_date')</label>
         <input type="text" id="user-birth-date" name="user_birth_date" class="datepicker" placeholder="@lang('fields.birth_date')" value="{{ old('user_birth_date') }}" autocomplete="nope" />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6 s-12">
      <div class="form-group required" data-name="user_email">
         <label for="user-email">@lang('fields.email')</label>
         <input type="email" id="user-email" name="user_email" placeholder="@lang('fields.email')" value="{{ old('user_email') }}" required />

         <div class="form-error"></div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6 s-12">
      <div class="form-group required" data-name="user_password">
         <label for="user-password">@lang('fields.password')</label>
         <input type="password" id="user-password" name="user_password" placeholder="@lang('fields.password')" autocomplete="off" required />

         <div class="form-error"></div>
      </div>
   </div>
   <div class="col-6 s-12">
      <div class="form-group required">
         <label for="user-password-confirmation">@lang('fields.password_confirmation')</label>
         <input type="password" id="user-password-confirmation" name="user_password_confirmation" placeholder="@lang('fields.password_confirmation')" autocomplete="off" required />
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group">
         <label for="user-source">@lang('fields.source')</label>
         <select id="user-source" name="source">
            <option value=""{{ old('source') === '' ? ' selected' : '' }}>@lang('fields.select_placeholder')</option>
            <option value="search_engine"{{ old('source') === 'search_engine' ? ' selected' : '' }}>@lang('fields.sources.search_engine')</option>
            <option value="social_media"{{ old('source') === 'social_media' ? ' selected' : '' }}>@lang('fields.sources.social_media')</option>
            <option value="advertising"{{ old('source') === 'advertising' ? ' selected' : '' }}>@lang('fields.sources.advertising')</option>
            <option value="external_link"{{ old('source') === 'external_link' ? ' selected' : '' }}>@lang('fields.sources.external_link')</option>
            <option value="circle"{{ old('source') === 'circle' ? ' selected' : '' }}>@lang('fields.sources.circle')</option>
            <option value="other"{{ old('source') === 'other' ? ' selected' : '' }}>@lang('fields.sources.other')</option>
         </select>
      </div>
   </div>
</div>
