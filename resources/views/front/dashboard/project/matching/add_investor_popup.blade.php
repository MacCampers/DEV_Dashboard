<div id="add-investor-popup" class="popup-container"{!! count($errors) > 0 ? ' style="display: block;"' : '' !!}>
   <div class="popup{{ count('errors') > 0 ? ' visible' : '' }}">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('buttons.add_investor')</div>
         </div>
      </div>

      <form id="search-investor" method="post" action="#">
         {{ csrf_field() }}

         <div class="row">
            <div class="col-12">
               <div class="form-group required" data-name="contact_email">
                  <label for="search-email">@lang('fields.email')</label>
                  <input type="email" id="search-email" name="search_email" placeholder="@lang('fields.email')" required />

                  <p class="form-error"></p>
               </div>
            </div>

            <div class="row">
               <div class="col-12 align-center">
                  <input type="submit" class="blue" value="@lang('buttons.submit')" />
               </div>
            </div>
         </div>
      </form>

      <form id="select-investor" method="post" action="{{ route('add_investor', ['id' => $project->id]) }}" style="display: none;">
         {{ csrf_field() }}

         <input type="hidden" id="found-contact-id" name="contact_id" value="" />

         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <div class="align-center">
                     <p>@lang('popups.add_investor.user_found')</p>

                     <div id="found-contact-name"></div>
                     <div id="found-contact-company"></div>
                  </div>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12 align-center">
               <input type="submit" class="blue" value="@lang('buttons.submit')" />
               <div class="cancel">
                  <span>@lang('buttons.cancel')</span>
               </div>
            </div>
         </div>
      </form>

      <form id="create-investor" method="post" action="{{ route('add_investor', ['id' => $project->id]) }}" style="display: none;">
         {{ csrf_field() }}

         <div class="row">
            <div class="col-12">
               <input type="hidden" id="contact-email" name="contact_email" value="" />

               <div class="form-group required{{ $errors->has('contact_first_name') ? ' has-error' : '' }}">
                  <label for="contact-first-name">@lang('fields.first_name')</label>
                  <input type="text" id="contact-first-name" name="contact_first_name" value="{{ old('contact_first_name') }}" placeholder="@lang('fields.first_name')" required />

                  @if( $errors->has('contact_first_name') )
                     <p class="form-error">{{ $errors->first('contact_first_name') }}</p>
                  @endif
               </div>

               <div class="form-group required{{ $errors->has('contact_last_name') ? ' has-error' : '' }}">
                  <label for="contact-last-name">@lang('fields.last_name')</label>
                  <input type="text" id="contact-last-name" name="contact_last_name" value="{{ old('contact_last_name') }}" placeholder="@lang('fields.last_name')" required />

                  @if( $errors->has('contact_last_name') )
                     <p class="form-error">{{ $errors->first('contact_last_name') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('contact_phone') ? ' has-error' : '' }}">
                  <label for="contact-phone">@lang('fields.phone_mobile')</label>
                  <input type="text" id="contact-phone" class="phone-number" name="contact_phone" value="{{ old('contact_phone') }}" />

                  @if( $errors->has('contact_phone') )
                     <p class="form-error">{{ $errors->first('contact_phone') }}</p>
                  @endif
               </div>

               <div class="form-group required">
                  <label for="company-category">@lang('fields.company_category')</label>
                  <select id="company-category" class="company-category-selector" name="company_category">
                     <option value="investment_fund">@lang('fields.company_categories.investment_fund')</option>
                     <option value="business_angel">@lang('fields.company_categories.business_angel')</option>
                     <option value="business_angels_assoc">@lang('fields.company_categories.business_angels_assoc')</option>
                     <option value="bank">@lang('fields.company_categories.bank')</option>
                     <option value="industrial">@lang('fields.company_categories.industrial')</option>
                     <option value="other">@lang('fields.company_categories.other')</option>
                  </select>
               </div>

               <div class="form-group required{{ $errors->has('company_name') ? ' has-error' : '' }}">
                  <label for="company-name">@lang('fields.company_name')</label>
                  <input type="text" id="company-name" name="company_name" placeholder="@lang('fields.company_name')" value="{{ old('company_name') }}" required />

                  @if( $errors->has('company_name') )
                     <p class="form-error">{{ $errors->first('company_name') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('company_registration_number') ? ' has-error' : '' }}">
                  <label for="company-registration-number">@lang('fields.registration_number')</label>
                  <input type="text" id="company-registration-number" name="company_registration_number" value="{{ old('company_registration_number') }}" placeholder="@lang('fields.registration_number')" />

                  @if( $errors->has('company_registration_number') )
                     <p class="form-error">{{ $errors->first('company_registration_number') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12 align-center">
               <input type="submit" class="blue" value="@lang('buttons.submit')" />
               <div class="cancel">
                  <span>@lang('buttons.cancel')</span>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
