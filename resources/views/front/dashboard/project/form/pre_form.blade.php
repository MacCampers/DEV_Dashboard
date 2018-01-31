@extends('front.layout.dashboard')

@section('title', trans('dashboard.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/project.js') }}"></script>
@endsection

@section('content')
   <div id="project-pre-form">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('fields.project.pre_form.title')</h1>
                     <p class="subtitle">@lang('fields.project.pre_form.subtitle')</p>
                  </div>
               </div>

               <form method="post" id="project-store" action="{{ route('project_store') }}">
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
                     | Company
                     |--------------------------------------------------------------------------
                     --}}
                     <section>
                        <div class="row">
                           <div class="col-6 lg-12">
                              <h2>@lang('fields.project.synthesis.identification')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                 <label for="company-name">@lang('fields.project.synthesis.company_name')</label>
                                 <input type="text" id="company-name" name="company_name" placeholder="@lang('fields.project.synthesis.company_name')" value="{{ old('company_name') }}" />

                                 @if( $errors->has('company_name') )
                                    <p class="form-error">{{ $errors->first('company_name') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('code_name') ? ' has-error' : '' }}">
                                 <label for="project-code-name">@lang('fields.project.synthesis.code_name')</label>
                                 <input type="text" id="project-code-name" name="code_name" placeholder="@lang('fields.project.synthesis.code_name')" value="{{ old('code_name') }}" />

                                 @if( $errors->has('code_name') )
                                    <p class="form-error">{{ $errors->first('code_name') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('company_registration_number') ? ' has-error' : '' }}">
                                 <label for="company-registration-number">@lang('fields.project.synthesis.company_registration_number')</label>
                                 <input type="text" id="company-registration-number" name="company_registration_number" placeholder="@lang('fields.project.synthesis.company_registration_number')" value="{{ old('company_registration_number') }}"/>

                                 @if( $errors->has('company_registration_number') )
                                    <p class="form-error">{{ $errors->first('company_registration_number') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('company_address_1') ? ' has-error' : '' }}">
                                 <label for="company-address-1">@lang('fields.project.synthesis.company_address')</label>
                                 <input type="text" id="company-address-1" name="company_address_1" placeholder="@lang('fields.project.synthesis.company_address_placeholder')" value="{{ old('company_address_1') }}"/>

                                 @if( $errors->has('company_address_1') )
                                    <p class="form-error">{{ $errors->first('company_address_1') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6 lg-12">
                              <div class="form-group {{ $errors->has('company_address_2') ? ' has-error' : '' }}">
                                 <label for="company-address-2">@lang('fields.address_2')</label>
                                 <input type="text" id="company-address-2" name="company_address_2" placeholder="@lang('fields.address_2_placeholder')" value="{{ old('company_address_2') }}"/>

                                 @if( $errors->has('company_address_2') )
                                    <p class="form-error">{{ $errors->first('company_address_2') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-2 lg-3 xs-4">
                              <div class="form-group required{{ $errors->has('company_zipcode') ? ' has-error' : '' }}">
                                 <label for="company-zipcode">@lang('fields.zipcode')</label>
                                 <input type="text" id="company-zipcode" name="company_zipcode" placeholder="@lang('fields.zipcode')" value="{{ old('company_zipcode') }}" />

                                 @if( $errors->has('company_zipcode') )
                                    <p class="form-error">{{ $errors->first('company_zipcode') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-4 lg-9 xs-4">
                              <div class="form-group required{{ $errors->has('company_city') ? ' has-error' : '' }}">
                                 <label for="company-city">@lang('fields.city')</label>
                                 <input type="text" id="company-city" name="company_city" placeholder="@lang('fields.project.synthesis.company_city')" value="{{ old('company_city') }}" />

                                 @if( $errors->has('company_city') )
                                    <p class="form-error">{{ $errors->first('company_city') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 m-12">
                              <div class="form-group required{{ $errors->has('company_country_id') ? ' has-error' : '' }}" data-name="company_country_id">
                                 <label for="company-country-id">@lang('fields.country')</label>
                                 <select id="company-country-id" class="country-selector" name="company_country_id" data-regions="company-region-id">
                                    @foreach( $countries as $country )
                                       <option value="{{ $country->id }}"{{ old('company_country_id', 69) == $country->id ? ' selected' : '' }}>@lang('zones.country.'.$country->code)</option>
                                    @endforeach
                                 </select>

                                 @if( $errors->has('company_country_id') )
                                    <p class="form-error">{{ $errors->first('company_country_id') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-6 m-12">
                              <div class="form-group required{{ $errors->has('company_region_id') ? ' has-error' : '' }}" data-name="company_region_id">
                                 <label for="company-region-id">@lang('fields.region')</label>
                                 <select id="company-region-id" class="region-selector" name="company_region_id">
                                    <option value="">@lang('fields.region_placeholder')</option>
                                    @foreach( $regions as $region )
                                       <option value="{{ $region->id }}" {{ old('company_region_id') == $region->id ? ' selected' : '' }} data-country="{{ $region->parent }}">@lang('zones.region.'.$region->code)</option>
                                    @endforeach
                                 </select>

                                 @if( $errors->has('company_region_id') )
                                    <p class="form-error">{{ $errors->first('company_region_id') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </section>

                     {{--
                     |--------------------------------------------------------------------------
                     | Representative
                     |--------------------------------------------------------------------------
                     --}}
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('fields.project.pre_form.representative')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('representative_status') ? ' has-error' : '' }}">
                                 <label for="representative-status">@lang('fields.project.synthesis.representative_status')</label>
                                 <input type="text" id="representative-status" name="representative_status" placeholder="@lang('fields.project.synthesis.representative_status')" value="{{ old('representative_status') }}"/>

                                 @if( $errors->has('representative_status') )
                                    <p class="form-error">{{ $errors->first('representative_status') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('representative_first_name') ? ' has-error' : '' }}">
                                 <label for="representative-first-name">@lang('fields.first_name')</label>
                                 <input type="text" id="representative-first-name" name="representative_first_name" placeholder="@lang('fields.first_name')" value="{{ old('representative_first_name') }}" autocomplete="off" />

                                 @if( $errors->has('representative_first_name') )
                                    <p class="form-error">{{ $errors->first('representative_first_name') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('representative_last_name') ? ' has-error' : '' }}">
                                 <label for="representative-last-name">@lang('fields.last_name')</label>
                                 <input type="text" id="representative-last-name" name="representative_last_name" placeholder="@lang('fields.last_name')" value="{{ old('representative_last_name') }}" autocomplete="off" />

                                 @if( $errors->has('representative_last_name') )
                                    <p class="form-error">{{ $errors->first('representative_last_name') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('representative_email') ? ' has-error' : '' }}">
                                 <label for="representative-email">@lang('fields.email')</label>
                                 <input type="email" id="representative-email" name="representative_email" placeholder="@lang('fields.email')" value="{{ old('representative_email') }}" autocomplete="off" />

                                 @if( $errors->has('representative_email') )
                                    <p class="form-error">{{ $errors->first('representative_email') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6 lg-12">
                              <div class="form-group required{{ $errors->has('representative_phone') ? ' has-error' : '' }}">
                                 <label for="representative-phone">@lang('fields.phone_mobile')</label>
                                 <input type="text" id="representative-phone" name="representative_phone" class="phone-number" value="{{ old('representative_phone') }}" autocomplete="off" />

                                 @if( $errors->has('representative_phone') )
                                    <p class="form-error">{{ $errors->first('representative_phone') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              @lang('fields.project.pre_form.representative_info')
                           </div>
                        </div>
                     </section>

                     {{--
                     |--------------------------------------------------------------------------
                     | Signatory
                     |--------------------------------------------------------------------------
                     --}}
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('fields.project.pre_form.licence_signatory')</h2>

                              @lang('fields.project.pre_form.licence_info')
                           </div>

                           <div class="col-6">
                              <div class="form-group required">
                                 <label for="project-signatory">@lang('fields.project.pre_form.signatory')</label>
                                 <select id="project-signatory" name="signatory">
                                    <option value="counsel"{{ old('signatory') == 'counsel' ? ' selected' : '' }}>@lang('fields.project.pre_form.signatory_selection.yourself')</option>
                                    <option value="representative"{{ old('signatory') == 'representative' ? ' selected' : '' }}>@lang('fields.project.pre_form.signatory_selection.representative')</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group required">
                                 <label for="signatory-phone">@lang('fields.phone_mobile')</label>
                                 <input type="text" id="signatory-phone" name="signatory_phone" class="phone-number" data-default="{{ $user->phone_mobile }}" value="{{ old('signatory_phone', $user->phone_mobile) }}"/>

                                 @if( $errors->has('signatory_phone') )
                                    <p class="form-error">{{ $errors->first('signatory_phone') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </section>

                     {{--
                     |--------------------------------------------------------------------------
                     | Project type
                     |--------------------------------------------------------------------------
                     --}}
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('fields.project.synthesis.type')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              <div class="form-group{{ $errors->has('project_type') ? ' has-error' : '' }}">
                                 <div class="checkbox">
                                    <input type="radio" id="type-fundraising" name="project_type" value="fundraising" checked />
                                    <label for="type-fundraising">@lang('fields.project.synthesis.fundraising')</label>
                                    <span class="checkmark"></span>
                                 </div>

                                 <div class="checkbox">
                                    <input type="radio" id="type-handover" name="project_type" value="handover"{{ old('project_type') === 'handover' ? ' checked' : '' }}/>
                                    <label for="type-handover">@lang('fields.project.synthesis.handover')</label>
                                    <span class="checkmark"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>

                     <section>
                        <div class="col-12 align-center">
                           <div class="form-group{{ $errors->has('certified') ? ' has-error' : '' }}">
                              <div class="checkbox centered">
                                 <input type="checkbox" id="certified" name="certified" value="certified" />
                                 <label for="certified">@lang('legal.certification')</label>
                                 <span class="checkmark"></span>
                              </div>
                           </div>

                           <input type="submit" id="preform-submit" class="blue" value="@lang('buttons.create_project')" />
                        </div>
                     </section>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
