@extends('front.layout.dashboard')

@section('title', trans('parameters.title'))

@section('content')
   <div id="parameters">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               <section>
                  @include('front.dashboard.parameters.nav')
               </section>

               <div class="container">
                  {{--
                  |--------------------------------------------------------------------------
                  | Personnal info
                  |--------------------------------------------------------------------------
                  --}}
                  <section>
                     <form method="post" action="{{ route('update_personal_info') }}" >
                        {{ csrf_field() }}

                        @if( session('success_message') )
                           @include('front.dashboard.project.form.partials.success_message')
                        @endif

                        @if( count($errors) > 0 )
                           @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
                        @endif

                        <div class="row">
                           <div class="col-6">
                              <h2>@lang('parameters.personal.update_info')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group required{{ $errors->has('user_first_name') ? ' has-error' : '' }}">
                                 <label for="user-first-name">@lang('fields.first_name')</label>
                                 <input type="text" id="user-first-name" name="user_first_name" placeholder="@lang('fields.first_name')" value="{{ old('user_first_name', $user->first_name) }}" />

                                 @if( $errors->has('user_first_name') )
                                    <p class="form-error">{{ $errors->first('user_first_name') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group required{{ $errors->has('user_last_name') ? ' has-error' : '' }}">
                                 <label for="user-last-name">@lang('fields.last_name')</label>
                                 <input type="text" id="user-last-name" name="user_last_name" placeholder="@lang('fields.last_name')" value="{{ old('user_last_name', $user->last_name) }}" />

                                 @if( $errors->has('user_last_name') )
                                    <p class="form-error">{{ $errors->first('user_last_name') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('user_job') ? ' has-error' : '' }}">
                                 <label for="user-job">@lang('fields.job')</label>
                                 <input type="text" id="user-job" name="user_job" placeholder="@lang('fields.job')" value="{{ old('user_job', $user->job) }}" />

                                 @if( $errors->has('user_job') )
                                    <p class="form-error">{{ $errors->first('user_job') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-3">
                              <div class="form-group{{ $errors->has('user_birth_date') ? ' has-error' : '' }}">
                                 <label for="user-birth-date">@lang('fields.birth_date')</label>
                                 <input type="text" id="user-birth-date" name="user_birth_date" class="datepicker" placeholder="@lang('fields.birth_date')" autocomplete="off" value="{{ old('user_birth_date', $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '') }}" />

                                 @if( $errors->has('user_birth_date') )
                                    <p class="form-error">{{ $errors->first('user_birth_date') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('user_phone_mobile') ? ' has-error' : '' }}">
                                 <label for="user-phone-mobile">@lang('fields.phone_mobile')</label>
                                 <input type="text" id="user-phone-mobile" name="user_phone_mobile" class="phone-number" value="{{ old('user_phone_mobile', $user->phone_mobile) }}" />

                                 @if( $errors->has('user_phone_mobile') )
                                    <p class="form-error">{{ $errors->first('user_phone_mobile') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group{{ $errors->has('user_phone_fixed') ? ' has-error' : '' }}">
                                 <label for="user-phone-fixed">@lang('fields.phone_fixed')</label>
                                 <input type="text" id="user-phone-fixed" name="user_phone_fixed" class="phone-number" value="{{ old('user_phone_fixed', $user->phone_fixed) }}" />

                                 @if( $errors->has('user_phone_fixed') )
                                    <p class="form-error">{{ $errors->first('user_phone_fixed') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('user_linkedin_url') ? ' has-error' : '' }}">
                                 <label for="user-linkedin-url">@lang('fields.linkedin_url')</label>
                                 <input type="text" id="user-linkedin-url" name="user_linkedin_url" value="{{ old('user_linkedin_url', $user->linkedin_url) }}" placeholder="@lang('fields.url')" />

                                 @if( $errors->has('user_linkedin_url') )
                                    <p class="form-error">{{ $errors->first('user_linkedin_url') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group{{ $errors->has('user_viadeo_url') ? ' has-error' : '' }}">
                                 <label for="user-viadeo-url">@lang('fields.viadeo_url')</label>
                                 <input type="text" id="user-viadeo-url" name="user_viadeo_url" value="{{ old('user_viadeo_url', $user->viadeo_url) }}" placeholder="@lang('fields.url')" />

                                 @if( $errors->has('user_viadeo_url') )
                                    <p class="form-error">{{ $errors->first('user_viadeo_url') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              <input type="submit" class="blue" value="@lang('buttons.save')"/>
                           </div>
                        </div>
                     </form>
                  </section>

                  {{--
                  |--------------------------------------------------------------------------
                  | Email
                  |--------------------------------------------------------------------------
                  --}}
                  <section>
                     <form method="post" action="{{ route('update_email') }}" >
                        {{ csrf_field() }}

                        <div class="row">
                           <div class="col-6">
                              <h2>@lang('parameters.personal.update_email')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group">
                                 <label for="user-current-email">@lang('fields.current_email')</label>
                                 <input type="email" id="user-current-email" name="user_current_email" value="{{ $user->email }}" disabled />
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="form-group {{ $errors->has('user_email') ? ' has-error' : '' }}">
                                 <label for="user-email">@lang('fields.new_email')</label>
                                 <input type="email" id="user-email" name="user_email" placeholder="@lang('fields.email')" value="{{ old('user_email') }}" />

                                 @if( $errors->has('user_email') )
                                    <p class="form-error">{{ $errors->first('user_email') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              <input type="submit" class="blue" value="@lang('buttons.save')"/>
                           </div>
                        </div>
                     </form>
                  </section>

                  {{--
                  |--------------------------------------------------------------------------
                  | Password
                  |--------------------------------------------------------------------------
                  --}}
                  <section>
                     <form method="post" action="{{ route('update_password') }}" >
                        {{ csrf_field() }}

                        <div class="row">
                           <div class="col-6">
                              <h2>@lang('parameters.personal.update_password')</h2>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                 <label for="current-password">@lang('fields.current_password')</label>
                                 <input type="password" id="current-password" name="current_password" placeholder="@lang('fields.current_password')" />

                                 @if( $errors->has('current_password') )
                                    <p class="form-error">{{ $errors->first('current_password') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                 <label for="new-password">@lang('fields.new_password')</label>
                                 <input type="password" id="new-password" name="new_password" placeholder="@lang('fields.new_password')" />

                                 @if( $errors->has('new_password') )
                                    <p class="form-error">{{ $errors->first('new_password') }}</p>
                                 @endif
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                 <label for="new-password-confirmation">@lang('fields.new_password_confirmation')</label>
                                 <input type="password" id="new-password-confirmation" name="new_password_confirmation" placeholder="@lang('fields.password_confirmation')" />

                                 @if( $errors->has('new_password_confirmation') )
                                    <p class="form-error">{{ $errors->first('new_password_confirmation') }}</p>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-12">
                              <input type="submit" class="blue" value="@lang('buttons.save')"/>
                           </div>
                        </div>
                     </form>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
