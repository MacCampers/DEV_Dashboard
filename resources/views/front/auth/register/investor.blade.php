@extends('front.layout.master')

@section('title', trans('auth.register.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/register.js') }}"></script>
@endsection

@section('content')
   <div id="register" class="blue-pattern">
      <div class="container">
         <div class="col-12">
            <h1>@lang('auth.register.title')</h1>

            <form id="register-form" method="post" action="{{ route('register_user', ['type' => 'investor']) }}" autocomplete="off">
               {{ csrf_field() }}

               <div class="form-wrapper">
                  {{-- Personal information --}}
                  <div class="registration-step current">
                     <div class="content">
                        <h3>@lang('auth.register.form.personal_information')</h3>

                        @include('front.auth.register.user')

                        <div class="buttons">
                           <button id="submit-user" type="button" class="blue next-step">@lang('buttons.next')</button>

                           <div class="terms">
                              <a class="link" href="{{ route('terms') }}" target="_blank">@lang('buttons.view_terms')</a>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- Company type --}}
                  <div class="registration-step">
                     <div class="content">
                        <h3>@lang('auth.register.form.company_information')</h3>

                        <div class="row">
                           <div class="col-12">
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

                                 <div class="form-error"></div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              <div class="form-group required" data-name="company_name">
                                 <label for="company-name">@lang('fields.company_name')</label>
                                 <div id="company-name-autocomplete" class="autocomplete" data-hidden="company-id" data-input="company-name">
                                    <span class="icon-cross reset"></span>
                                    <input type="text" id="company-name" class="autocomplete-input" name="company_name" placeholder="@lang('fields.company_name')" autocomplete="off" required />
                                    <ul style="display: none;"></ul>
                                 </div>
                                 <input type="hidden" id="company-id" name="company_id" />

                                 <div class="form-error"></div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group required" data-name="company_registration_number">
                                 <label for="company-registration-number">@lang('fields.siren')</label>
                                 <input type="text" id="company-registration-number" name="company_registration_number" placeholder="@lang('fields.siren')" required />

                                 <div class="form-error"></div>
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group required" data-name="company_address">
                                 <label for="company-address">@lang('fields.address')</label>
                                 <input type="text" id="company-address" name="company_address" placeholder="@lang('fields.address_placeholder')" required />

                                 <div class="form-error"></div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group" data-name="company_phone">
                                 <label for="company-phone">@lang('fields.phone')</label>
                                 <input type="text" id="company-phone" name="company_phone" class="phone-number" placeholder="@lang('fields.phone')" />

                                 <div class="form-error"></div>
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group">
                                 <label for="company-address-2">@lang('fields.address_2')</label>
                                 <input type="text" id="company-address-2" name="company_address_2" placeholder="@lang('fields.address_2_placeholder')" />
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-4">
                              <div class="form-group required" data-name="company_zipcode">
                                 <label for="company-zipcode">@lang('fields.zipcode')</label>
                                 <input type="text" id="company-zipcode" name="company_zipcode" placeholder="@lang('fields.zipcode')" required />

                                 <div class="form-error"></div>
                              </div>
                           </div>
                           <div class="col-8">
                              <div class="form-group required" data-name="company_city">
                                 <label for="company-city">@lang('fields.city')</label>
                                 <input type="text" id="company-city" name="company_city" placeholder="@lang('fields.city')" required />

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
                                       <option value="{{ $country->id }}"{{ $country->code === 'fr' ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
                                    @endforeach
                                 </select>

                                 <div class="form-error"></div>
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group" data-name="company_region_id">
                                 <label for="company-region-id">@lang('fields.region')</label>
                                 <select id="company-region-id" class="region-selector" name="company_region_id">
                                    <option value="">@lang('fields.region_placeholder')</option>
                                    @foreach( $regions as $region )
                                       <option value="{{ $region->id }}" data-country="{{ $region->parent }}">@lang('zones.region.'.$region->code)</option>
                                    @endforeach
                                 </select>

                                 <div class="form-error"></div>
                              </div>
                           </div>
                        </div>

                        <div class="buttons">
                           <button type="button" class="grey previous-step">@lang('buttons.previous')</button>
                           <button type="button" id="investor-register" class="blue" >@lang('buttons.submit')</button>

                           <div class="terms">
                              <a class="link" href="{{ route('terms') }}" target="_blank">@lang('buttons.view_terms')</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </form>

            <div class="dots">
               <div class="dot current"></div>
               <div class="dot"></div>
            </div>
         </div>
      </div>
   </div>

   @include('front.auth.register.popup.cgu_popup')
@endsection
