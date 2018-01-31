@extends('front.layout.dashboard')

@section('title', trans('fields.company'))

@section('content')
   <div id="parameters">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('front.dashboard.company.nav')

               <div class="container">
                  @if( session('success_message') )
                     @include('front.dashboard.project.form.partials.success_message')
                  @endif

                  @if( count($errors) > 0 )
                     @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
                  @endif

                  <form method="post" action="{{ route('company_information_update') }}" >
                     {{ csrf_field() }}

                     <section>
                        <div class="row">
                           <div class="col-6">
                              <div class="form-group required{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                 <label for="company-name">@lang('fields.company_name')</label>
                                 <input type="text" id="company-name" name="company_name" value="{{ old('company_name', $company->name) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_name') )
                                    <p class="form-error">{{ $errors->first('company_name') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('company_registration_number') ? ' has-error' : '' }}">
                                 <label for="company-registration-number">@lang('fields.registration_number')</label>
                                 <input type="text" id="company-registration-number" name="company_registration_number" value="{{ old('company_registration_number', $company->registration_number) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_registration_number') )
                                    <p class="form-error">{{ $errors->first('company_registration_number') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group required{{ $errors->has('company_address_1') ? ' has-error' : '' }}">
                                 <label for="company-address">@lang('fields.address')</label>
                                 <input type="text" id="company-address" name="company_address_1" value="{{ old('company_address_1', $company->address_1) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_address_1') )
                                    <p class="form-error">{{ $errors->first('company_address_1') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('company_address_2') ? ' has-error' : '' }}">
                                 <label for="company-address-2">@lang('fields.address_2')</label>
                                 <input type="text" id="company-address-2" name="company_address_2" value="{{ old('company_address_2', $company->address_2) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_address_2') )
                                    <p class="form-error">{{ $errors->first('company_address_2') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-2">
                              <div class="form-group required{{ $errors->has('company_zipcode') ? ' has-error' : '' }}">
                                 <label for="company-zipcode">@lang('fields.zipcode')</label>
                                 <input type="text" id="company-zipcode" name="company_zipcode" value="{{ old('company_zipcode', $company->zipcode) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_zipcode') )
                                    <p class="form-error">{{ $errors->first('company_zipcode') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="form-group required{{ $errors->has('company_city') ? ' has-error' : '' }}">
                                 <label for="company-city">@lang('fields.city')</label>
                                 <input type="text" id="company-city" name="company_city" value="{{ old('company_city', $company->city) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_city') )
                                    <p class="form-error">{{ $errors->first('company_city') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('company_phone') ? ' has-error' : '' }}">
                                 <label for="company-phone">@lang('fields.phone')</label>
                                 <input type="text" id="company-phone" name="company_phone" class="phone-number" value="{{ old('company_city', $company->phone) }}"{{ !$user->is_admin ? ' disabled' : '' }} />

                                 @if( $errors->has('company_phone') )
                                    <p class="form-error">{{ $errors->first('company_phone') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 m-12">
                              <div class="form-group required{{ $errors->has('company_country') ? ' has-error' : '' }}" data-name="company_country_id">
                                 <label for="company-country-id">@lang('fields.country')</label>
                                 <select id="company-country-id" class="country-selector" name="company_country_id" data-regions="company-region-id"{{ !$user->is_admin ? ' disabled' : '' }}>
                                    @foreach( $countries as $country )
                                       <option value="{{ $country->id }}"{{ $country->id == old('company_country_id', $company->country_id ? $company->country_id : 69) ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
                                    @endforeach
                                 </select>

                                 @if( $errors->has('company_country_id') )
                                    <p class="form-error">{{ $errors->first('company_country_id') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6 m-12">
                              <div class="form-group{{ $errors->has('company_region_id') ? ' has-error' : '' }}" data-name="company_region">
                                 <label for="company-region-id">@lang('fields.region')</label>
                                 <select id="company-region-id" class="region-selector" name="company_region_id"{{ !$user->is_admin ? ' disabled' : '' }}>
                                    <option value="">@lang('fields.region_placeholder')</option>
                                    @foreach( $regions as $region )
                                       <option value="{{ $region->id }}"{{ $region->id == old('company_region_id', $company->region_id ? $company->region_id : null) ? ' selected' : '' }} data-country="{{ $region->parent }}">@lang('zones.region.'.$region->code)</option>
                                    @endforeach
                                 </select>

                                 @if( $errors->has('company_region_id') )
                                    <p class="form-error">{{ $errors->first('company_region_id') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </section>

                     @if( $user->is_admin )
                        <section>
                           <div class="row">
                              <div class="col-12 align-center">
                                 <input type="submit" class="blue" value="@lang('buttons.edit')"/>
                              </div>
                           </div>
                        </section>
                     @endif
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
