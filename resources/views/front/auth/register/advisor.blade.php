@extends('front.layout.master')

@section('title', trans('auth.register.title'))

@section('js')
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
   Stripe.setPublishableKey("{{ env('STRIPE_KEY') }}");
   </script>

   <script type="text/javascript" src="{{ asset('/js/front/register.js') }}"></script>
@endsection

@section('content')
   <div id="register" class="blue-pattern">
      <div class="container">
         <div class="col-12">
            <h1>@lang('auth.register.title')</h1>

            <form id="register-form" class="subscription" method="post" action="{{ route('register_user', ['type' => 'advisor']) }}" autocomplete="off">
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


                  {{-- Company information --}}
                  <div class="registration-step">
                     <div class="content">
                        <h3>@lang('auth.register.form.company_information')</h3>

                        @include('front.auth.register.company')

                        <div class="buttons">
                           <button type="button" class="grey previous-step">@lang('buttons.previous')</button>
                           <button id="submit-company" type="button" class="blue next-step">@lang('buttons.next')</button>

                           <div class="terms">
                              <a class="link" href="{{ route('terms') }}" target="_blank">@lang('buttons.view_terms')</a>
                           </div>
                        </div>
                     </div>
                  </div>


                  {{-- Subscription plan --}}
                  <div class="registration-step">
                     <div class="content">
                        <h3>@lang('auth.register.form.subscription')</h3>

                        <div class="row">
                           <div class="col-12">
                              <div class="plan-selector featured">
                                 <input type="radio" id="subscription-3" name="subscription" value="advisor_24"{{ old('subscription') === 'advisor_24' ? ' checked' : '' }} />
                                 <label for="subscription-3">
                                    <span>@lang('auth.register.plans.commitment', ['n' => 24])</span>
                                    <span class="price">159€ <span>@lang('common.per_month')</span></span>
                                 </label>

                                 <span class="checkmark"></span>
                              </div>

                              <div class="plan-selector">
                                 <input type="radio" id="subscription-2" name="subscription" value="advisor_12"{{ old('subscription') === 'advisor_12' ? ' checked' : '' }} />
                                 <label for="subscription-2">
                                    <span>@lang('auth.register.plans.commitment', ['n' => 12])</span>
                                    <span class="price">189€ <span>@lang('common.per_month')</span></span>
                                 </label>

                                 <span class="checkmark"></span>
                              </div>
                           </div>

                           <span class="blue-span">@lang('prices.advisor.flat_fee_advisor')</span>
                        </div>

                        <div class="row">
                           <div class="col-12 align-center">
                              <div class="coupon form-group row" data-name="coupon">
                                 <p>@lang('auth.register.plans.coupon')</p>

                                 <div class="input">
                                    <input type="text" id="coupon" name="coupon" />
                                    <div id="submit-coupon" class="button red small">@lang('buttons.submit')</div>
                                 </div>

                                 <div class="form-error"></div>
                              </div>
                           </div>
                        </div>

                        <div class="buttons">
                           <button type="button" class="grey previous-step">@lang('buttons.previous')</button>
                           <button id="submit-subscription" type="button" class="blue next-step disabled">@lang('buttons.next')</button>

                           <div class="terms">
                              <a class="link" href="{{ route('terms') }}" target="_blank">@lang('buttons.view_terms')</a>
                           </div>
                        </div>
                     </div>
                  </div>


                  {{-- Payment form --}}
                  <div class="registration-step">
                     <div class="content">
                        <h3>@lang('auth.register.form.payment')</h3>

                        @include('front.auth.register.payment')

                        <div class="buttons align-center">
                           <div class="checkbox centered">
                              <input type="checkbox" id="cgu" name="cgu" value="certified" />
                              <label for="cgu">@lang('fields.cgu', ['url' => route('terms')])</label>
                              <span class="checkmark"></span>
                           </div>

                           <button type="button" class="grey previous-step">@lang('buttons.previous')</button>
                           <input type="submit" class="blue" id="button-payment" value="@lang('fields.payment_form.button')" disabled />

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
               <div class="dot"></div>
               <div class="dot"></div>
            </div>
         </div>
      </div>
   </div>
@endsection
