@extends('front.layout.master')

@section('title', trans('concept.title'))

@section('content')

   <div id="concept" class="page">
      {{-- Heading --}}
      <section id="team-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('concept.title')</h1>
            </div>
         </div>
      </section>

      {{-- Intro --}}
      <section id="intro">
         <div class="container">
            <div class="col-8 lg-7 s-12">
               <h2 class="align-left">@lang('concept.subtitle')</h2>
               @lang('concept.intro')
            </div>

            <div class="col-4 lg-5 s-12 image-container">
               <img src="{{ asset('img/concept/screen.png') }}" alt="Screen" />
            </div>
         </div>
      </section>

      {{-- We are / We ain't --}}
      <section id="what-we-do">
         <div class="container">
            <div class="flex">
               <div class="col-6 s-12">
                  <div class="list blue">
                     <h4>@lang('concept.we_are.title')</h4>
                     <ul>
                        <li><span class="icon-check"></span>@lang('concept.we_are.list_1')</li>
                        <li><span class="icon-check"></span>@lang('concept.we_are.list_2')</li>
                        <li><span class="icon-check"></span>@lang('concept.we_are.list_3')</li>
                        <li><span class="icon-check"></span>@lang('concept.we_are.list_4')</li>
                     </ul>
                  </div>
               </div>

               <div class="col-6 s-12">
                  <div class="list red">
                     <h4>@lang('concept.we_aint.title')</h4>
                     <ul>
                        <li><span class="icon-delete"></span>@lang('concept.we_aint.list_1')</li>
                        <li><span class="icon-delete"></span>@lang('concept.we_aint.list_2')</li>
                        <li><span class="icon-delete"></span>@lang('concept.we_aint.list_3')</li>
                        <li><span class="icon-delete"></span>@lang('concept.we_aint.list_4')</li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </section>

      {{-- Target --}}
      <section id="target" class="blue-pattern">
         <div class="container">
            <div class="col-12 align-center">
               <p>@lang('concept.equiteasy_target')</p>
            </div>
         </div>
      </section>

      {{-- Profiles --}}
      <section id="profiles">
         <div class="container">
            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}" class="image">
                     <img src="{{ asset('img/home/contractor.png')}}" width="175" height="175" alt="Contractor" />
                  </a>
                  <div class="title">@lang('fields.account_types.contractor')</div>
                  <p>@lang('home.section_2.text_contractor')</p>
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}" class="image">
                     <img src="{{ asset('img/home/advisor.png')}}" width="175" height="175" alt="Advisor" />
                  </a>
                  <div class="title">@lang('fields.account_types.advisor')</div>
                  <p>@lang('home.section_2.text_advisor')</p>
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}" class="image">
                     <img src="{{ asset('img/home/investor.png')}}" width="175" height="175" alt="Investor" />
                  </a>
                  <div class="title">@lang('fields.account_types.investor')</div>
                  <p>@lang('home.section_2.text_investor')</p>
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
            <div class="col-3 lg-6 m-6 s-6 xs-4">
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
