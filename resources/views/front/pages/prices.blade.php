@extends('front.layout.master')

@section('title', trans('prices.title'))

@section('content')

   <div id="prices" class="page">
      {{-- Heading --}}
      <section id="team-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('prices.title')</h1>
            </div>
         </div>
      </section>

      {{-- Intro --}}
      <section>
         <div class="container">
            <h2>@lang('prices.subtitles_1')</h2>
            <div class="col-12 align-center">
               <h3>@lang('prices.subtitles_2')</h3>
            </div>
         </div>
      </section>

      <section>
         <div class="container">
            <div class="row">
               <div class="col-6 m-12">
                  <div class="subscription">
                     <div class="image">
                        <img src="{{ asset('img/home/advisor.png')}}" width="175" alt="Advisor" />
                     </div>

                     <div class="top">
                        <div class="row">
                           <div class="col-12">
                              <h3>@lang('fields.account_types.advisor')</h3>
                           </div>
                        </div>

                        <div class="row prices">
                           <div class="col-6 align-center">
                              <p class="commitment">@lang('auth.register.plans.commitment', ['n' => 24])</p>
                              <div class="taxes">
                                 <p class="price">159€</p>
                                 <span>@lang('common.per_month')</span>
                              </div>
                           </div>
                           <div class="col-6 align-center">
                              <p class="commitment">@lang('auth.register.plans.commitment', ['n' => 12])</p>
                              <div class="taxes">
                                 <p class="price">189€</p>
                                 <span>@lang('common.per_month')</span>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="flat-flee">
                        <p>@lang('prices.advisor.flat_fee_advisor')</p>
                     </div>

                     <div class="section features">
                        <p><strong>@lang('prices.subscription')</strong></p>
                        <ul class="features">
                           <li>@lang('prices.advisor.features_1')</li>
                           <li>@lang('prices.advisor.features_2')</li>
                           <li>
                              @lang('prices.advisor.features_3')<br />
                              <div class="hint">@lang('prices.advisor.guest_hint')</div>
                           </li>
                           <li>
                              @lang('prices.advisor.features_4')<br />
                              <div class="hint">@lang('prices.advisor.features_hint')</div>
                           </li>
                        </ul>
                     </div>

                     <div class="section">
                        <div class="cta"><a href="{{ route('registration_form', ['type' => 'advisor']) }}" class="button blue">@lang('buttons.signup')</a></div>
                        <div><a href="{{ route('terms') }}" class="link">@lang('prices.cgu')</a></div>
                     </div>

                     <div class="section">
                        <span>@lang('prices.advisor.button_hint') <a href="{{ route('contact') }}" class="button red small">@lang('buttons.contact_us')</a></span>
                     </div>
                  </div>
               </div>

               <div class="col-6 m-12">
                  <div class="subscription">
                     <div class="image">
                        <img src="{{ asset('img/home/contractor.png')}}" width="175" alt="Contractor" />
                     </div>

                     <div class="top">
                        <div class="row">
                           <div class="col-12">
                              <h3>@lang('fields.account_types.contractor')</h3>
                           </div>
                        </div>

                        <div class="row prices">
                           <div class="col-6 align-center">
                              <p class="commitment">@lang('auth.register.plans.commitment', ['n' => 6])</p>
                              <div class="taxes">
                                 <p class="price">169€</p>
                                 <span>@lang('common.per_month')</span>
                              </div>
                           </div>
                           <div class="col-6 align-center">
                              <p class="commitment">@lang('auth.register.plans.no_commitment')</p>
                              <div class="taxes">
                                 <p class="price">199€</p>
                                 <span>@lang('common.per_month')</span>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="flat-flee">
                        <p>@lang('prices.contractor.flat_fee_contractor')</p>
                     </div>

                     <div class="section features">
                        <p><strong>@lang('prices.subscription')</strong></p>
                        <ul class="features">
                           <li>@lang('prices.contractor.features_1')</li>
                           <li>@lang('prices.contractor.features_2')</li>
                           <li>
                              @lang('prices.contractor.features_3')<br />
                              <div class="hint">@lang('prices.contractor.guest_hint')</div>
                           </li>
                           <li>
                              @lang('prices.contractor.features_4')<br />
                              <div class="hint">@lang('prices.contractor.features_hint')</div>
                           </li>
                        </ul>
                     </div>

                     <div class="section">
                        <div class="cta"><a href="{{ route('registration_form', ['type' => 'contractor']) }}" class="button blue">@lang('buttons.signup')</a></div>
                        <div><a href="{{ route('terms') }}" class="link">@lang('prices.cgu')</a></div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-6 m-12">
                  <div class="subscription">
                     <div class="image">
                        <img src="{{ asset('img/home/investor.png')}}" width="175" alt="Investor" />
                     </div>

                     <div class="top">
                        <div class="row">
                           <div class="col-12">
                              <h3>@lang('fields.account_types.investor')</h3>
                           </div>
                        </div>
                     </div>

                     <div class="section">
                        <p><strong>@lang('prices.free_licence')</strong></p>
                     </div>

                     <div class="section">
                        <a href="{{ route('registration_form', ['type' => 'investor']) }}" class="button blue">@lang('buttons.signup')</a>
                     </div>
                  </div>
               </div>

               <div class="col-6 m-12">
                  <div class="subscription">
                     <div class="image">
                        <img src="{{ asset('img/home/manager.png')}}" width="175" alt="Manager" />
                     </div>

                     <div class="top">
                        <div class="row">
                           <div class="col-12">
                              <h3>@lang('fields.account_types.manager')</h3>
                           </div>
                        </div>
                     </div>

                     <div class="section">
                        <p><strong>@lang('prices.manager_licence')</strong></p>
                     </div>

                     <div class="section">
                        <div class="button disabled">@lang('home.section_6.button')</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
@endsection
