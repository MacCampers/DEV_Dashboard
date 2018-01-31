@extends('front.layout.master')

@section('title', trans('auth.register.title'))

@section('content')
   <div id="register" class="blue-pattern">
      <div class="container">
         <div class="col-12">
            <h1>@lang('auth.register.title')</h1>

            <form id="account-selector" method="post" action="{{ route('registration_redirect') }}">
               {{ csrf_field() }}

               <div class="registration-step current">
                  <div class="content">
                     <h3>@lang('auth.register.profile_selection.title')</h3>
                     <p>@lang('auth.register.profile_selection.subtitle')</p>

                     <div class="row">
                        <div class="col-12">
                           <div class="form-group">
                              <div class="radio-button">
                                 <input type="radio" id="account-type-advisor" name="account_type" value="advisor" />
                                 <label for="account-type-advisor">@lang('fields.account_types.advisor')</label>
                                 <span class="checkmark"></span>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="radio-button">
                                 <input type="radio" id="account-type-contractor" name="account_type" value="contractor" />
                                 <label for="account-type-contractor">@lang('fields.account_types.contractor')</label>
                                 <span class="checkmark"></span>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="radio-button">
                                 <input type="radio" id="account-type-investor" name="account_type" value="investor" />
                                 <label for="account-type-investor">@lang('fields.account_types.investor')</label>
                                 <span class="checkmark"></span>
                              </div>
                           </div>

                           {{-- <div class="form-group">
                              <div class="radio-button">
                                 <input type="radio" id="account-type-manager" name="account_type" value="manager" />
                                 <label for="account-type-manager">@lang('fields.account_types.manager')</label>
                                 <span class="checkmark"></span>
                              </div>
                           </div> --}}

                           <p><a href="{{ route('concept') }}" target="_blank">@lang('auth.register.profile_selection.help')</a></p>
                        </div>
                     </div>

                     <button type="submit" class="blue next-step">@lang('buttons.continue')</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection
