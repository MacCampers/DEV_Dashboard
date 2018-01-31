@extends('front.layout.master')

@section('title', trans('fields.account_types.investor'))

@section('content')

   <div id="profile" class="page">
      {{-- Heading --}}
      <section class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <div class="image">
                  <img src="{{ asset('img/home/investor.png')}}" width="175" height="175" alt="Contractor" />
               </div>
            </div>
         </div>
      </section>

      {{-- Steps --}}
      <section>
         <div class="container">
            <div class="col-12">
               <div class="intro">
                  <h1>@lang('fields.account_types.investor')</h1>
                  <h2>@lang('profiles.investor.title')</h2>
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
                           <p>@lang('profiles.investor.step_1')</p>
                        </div>
                     </div>
                     <div class="col-6 s-12 image">
                        <img src="{{ asset('img/profiles/notification.png')}}" width="340" alt="Notification" />
                     </div>
                  </div>
               </div>

               <div class="step">
                  <div class="row">
                     <div class="col-6 s-12 text">
                        <div class="step-text">
                           <div class="step-number">2.</div>
                           <p>@lang('profiles.investor.step_2')</p>
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
                           <div class="step-number">3.</div>
                           <p>@lang('profiles.investor.step_3')</p>
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
                     <li><span class="icon-check"></span>@lang('profiles.investor.li_1')</li>
                     <li><span class="icon-check"></span>@lang('profiles.investor.li_2')</li>
                     <li><span class="icon-check"></span>@lang('profiles.investor.li_3')</li>
                     <li><span class="icon-check"></span>@lang('profiles.investor.li_4')</li>
                     <li><span class="icon-check"></span>@lang('profiles.investor.li_5')</li>
                  </ul>

                  <p class="align-center"><strong>@lang('profiles.investor.li_6')</strong></p>

                  <div class="cta align-center">
                     <a href="{{ route('registration_form', ['type' => 'investor']) }}" class="button blue">@lang('home.section_4.button')</a>
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
