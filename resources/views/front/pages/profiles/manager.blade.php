@extends('front.layout.master')

@section('title', trans('fields.account_types.manager'))

@section('content')

   <div id="profile" class="page">
      {{-- Heading --}}
      <section class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <div class="image">
                  <img src="{{ asset('img/home/manager.png')}}" width="175" height="175" alt="Contractor" />
               </div>
            </div>
         </div>
      </section>

      {{-- Steps --}}
      <section>
         <div class="container">
            <div class="col-12">
               <div class="intro">
                  <h1>@lang('fields.account_types.manager')</h1>
                  <h2>@lang('profiles.manager.title')</h2>
                  <p>@lang('profiles.manager.subtitle')</p>
               </div>
            </div>
         </div>

         <div class="container">
            <div class="steps">
               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">1.</div>
                           <p>@lang('profiles.manager.step_1')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/form.png')}}" width="340" alt="Form" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">2.</div>
                           <p>@lang('profiles.manager.step_2')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/manager.png')}}" width="340" alt="Manager" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">3.</div>
                           <p>@lang('profiles.manager.step_3')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/equartyp.png')}}" width="360" alt="Equartyp" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">4.</div>
                           <p>@lang('profiles.manager.step_4')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/mail.png')}}" width="340" alt="Mail" />
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </section>

      {{-- Features --}}
      <section id="features" class="grey-pattern">

         <div class="container">
            <div class="col-12">
               <div class="features">
                  <h2>@lang('profiles.advantages')</h2>

                  <ul>
                     <li><span class="icon-check"></span>@lang('profiles.manager.li_1')</li>
                     <li><span class="icon-check"></span>@lang('profiles.manager.li_2')</li>
                     <li><span class="icon-check"></span>@lang('profiles.manager.li_3')</li>
                  </ul>

                  <p class="align-center"><strong>@lang('profiles.manager.li_4')</strong></p>

                  <div class="cta align-center">
                     <button class="grey" disabled>@lang('common.coming_soon')</button>
                  </div>
               </div>
            </div>
         </div>
      </section>

      {{-- Profiles --}}
      <section id="profiles">
         <div class="container">
            <div class="col-4 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}" class="image">
                     <img src="{{ asset('img/home/contractor.png')}}" width="175" height="175" alt="Contractor" />
                  </a>
                  <div class="title">@lang('fields.account_types.contractor')</div>
                  <p>@lang('home.section_2.text_contractor')</p>
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
            <div class="col-4 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}" class="image">
                     <img src="{{ asset('img/home/advisor.png')}}" width="175" height="175" alt="Advisor" />
                  </a>
                  <div class="title">@lang('fields.account_types.advisor')</div>
                  <p>@lang('home.section_2.text_advisor')</p>
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
            <div class="col-4 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}" class="image">
                     <img src="{{ asset('img/home/investor.png')}}" width="175" height="175" alt="Investor" />
                  </a>
                  <div class="title">@lang('fields.account_types.investor')</div>
                  <p>@lang('home.section_2.text_investor')</p>
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
         </div>
      </section>
   </div>
@endsection
