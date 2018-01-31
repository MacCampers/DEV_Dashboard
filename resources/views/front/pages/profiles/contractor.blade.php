@extends('front.layout.master')

@section('title', trans('fields.account_types.contractor'))

@section('content')

   <div id="profile" class="page">
      {{-- Heading --}}
      <section class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <div class="image">
                  <img src="{{ asset('img/home/contractor.png')}}" width="175" height="175" alt="Contractor" />
               </div>
            </div>
         </div>
      </section>

      {{-- Steps --}}
      <section>
         <div class="container">
            <div class="col-12">
               <div class="intro">
                  <h1>@lang('fields.account_types.contractor')</h1>
                  <h2>@lang('profiles.contractor.title')</h2>
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
                           <p>@lang('profiles.contractor.step_1')</p>
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
                           <p>@lang('profiles.contractor.step_2')</p>
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
                           <div class="step-number">3.</div>
                           <p>@lang('profiles.contractor.step_3')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/mail.png')}}" width="340" alt="Mail" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">4.</div>
                           <p>@lang('profiles.contractor.step_4')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/signature.png')}}" width="340" alt="Signature" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">5.</div>
                           <p>@lang('profiles.contractor.step_5')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/project.png')}}" width="360" alt="Project" />
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
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_1')</li>
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_2')</li>
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_3')</li>
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_4')</li>
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_5')</li>
                     <li><span class="icon-check"></span>@lang('profiles.contractor.li_6')</li>
                  </ul>

                  <p class="align-center"><strong>@lang('profiles.contractor.li_7')</strong></p>

                  <div class="cta align-center">
                     <a href="{{ route('registration_form', ['type' => 'contractor']) }}" class="button blue">@lang('home.section_4.button')</a>
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
            <div class="col-4 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'repreneur']) }}" class="image">
                     <img src="{{ asset('img/home/manager.png')}}" width="175" height="175" alt="Manager" />
                  </a>
                  <div class="title">@lang('fields.account_types.manager')</div>
                  <p>@lang('home.section_2.text_manager')</p>
                  <a href="{{ route('profile', ['slug' => 'repreneur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
         </div>
      </section>
   </div>
@endsection
