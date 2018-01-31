<div id="update-billing-address-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('parameters.subscription.billing_informations')</div>
         </div>
      </div>

      <form method="post" action="{{ route('user_billing_informations') }}">
         {{ csrf_field() }}

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('billing_company_name') ? ' has-error' : '' }}">
                  <label for="billing-company-name">@lang('fields.company_name')</label>
                  <input type="text" id="billing-company-name" name="billing_company_name" placeholder="@lang('fields.company_name')" value="{{ old('billing_company_name', $user->billing_company_name) }}" required />

                  @if( $errors->has('billing_company_name') )
                     <p class="form-error">{{ $errors->first('billing_company_name') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('billing_name') ? ' has-error' : '' }}">
                  <label for="billing-name">@lang('fields.last_name')</label>
                  <input type="text" id="billing-name" name="billing_name" placeholder="@lang('fields.last_name')" value="{{ old('billing_name', $user->billing_name) }}" required />

                  @if( $errors->has('billing_name') )
                     <p class="form-error">{{ $errors->first('billing_name') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('billing_address_1') ? ' has-error' : '' }}">
                  <label for="billing-address-1">@lang('fields.address')</label>
                  <input type="text" id="billing-address-1" placeholder="@lang('fields.address')" name="billing_address_1" value="{{ old('billing_address_1', $user->billing_address_1) }}" required />

                  @if( $errors->has('billing_address_1') )
                     <p class="form-error">{{ $errors->first('billing_address_1') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group{{ $errors->has('billing_address_2') ? ' has-error' : '' }}">
                  <label for="billing-address-2">@lang('fields.address_2')</label>
                  <input type="text" id="billing-address-2" placeholder="@lang('fields.address_2')" name="billing_address_2" value="{{ old('billing_address_2', $user->billing_address_2) }}" />

                  @if( $errors->has('billing_address_2') )
                     <p class="form-error">{{ $errors->first('billing_address_2') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-4">
               <div class="form-group required{{ $errors->has('billing_zipcode') ? ' has-error' : '' }}">
                  <label for="billing-zipcode">@lang('fields.zipcode')</label>
                  <input type="text" id="billing-zipcode" name="billing_zipcode" placeholder="@lang('fields.zipcode')" value="{{ old('billing_zipcode', $user->billing_zipcode) }}" required />

                  @if( $errors->has('billing_zipcode') )
                     <p class="form-error">{{ $errors->first('billing_zipcode') }}</p>
                  @endif
               </div>
            </div>
            <div class="col-8">
               <div class="form-group required{{ $errors->has('billing_city') ? ' has-error' : '' }}">
                  <label for="billing-city">@lang('fields.city')</label>
                  <input type="text" id="billing-city" name="billing_city" placeholder="@lang('fields.city')" value="{{ old('billing_city', $user->billing_city) }}" required />

                  @if( $errors->has('billing_city') )
                     <p class="form-error">{{ $errors->first('billing_city') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="form-group required{{ $errors->has('billing_country_id') ? ' has-error' : '' }}" data-name="billing_country_id">
                  <label for="billing-country-id">@lang('fields.country')</label>
                  <select id="billing-country-id" class="country-selector" name="billing_country_id" data-regions="billing-region-id">
                     @foreach( $countries as $country )
                        <option value="{{ $country->id }}"{{ $country->id == old('billing_country_id', $user->billing_country_id ? $user->billing_country_id : 69) ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
                     @endforeach
                  </select>

                  @if( $errors->has('billing_country_id') )
                     <p class="form-error">{{ $errors->first('billing_country_id') }}</p>
                  @endif
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12 align-center">
               <input type="submit" class="button blue" value="@lang('buttons.submit')" />
            </div>
         </div>
      </form>
   </div>
</div>
