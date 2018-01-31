@extends('front.layout.master')

@section('title', 'Shortcut to Equity')

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/home.js') }}"></script>
@endsection

@section('content')

   <div id="home">

      {{-- Heading --}}
      <section id="heading" class="blue-pattern">
         <div class="container">
            <div class="col-12 slider-wrapper">
               <div class="content-wrapper">
                  <div class="content-slider">
                     <p>@lang('home.slider.slide_1')</p>
                     <p>@lang('home.slider.slide_2', ['strategy' => $strategy])</p>
                     <p>@lang('home.slider.slide_3')</p>
                     <p>@lang('home.slider.slide_4')</p>
                  </div>

                  <a href="{{ route('concept') }}" class="button red full-width">@lang('home.slider.button')</a>
               </div>

               <div class="image-slider">
                  <div class="slide">
                     <div class="container">
                        <img src="{{ asset('img/home/slider/slide_1.png') }}" alt="Epitech" />
                     </div>
                  </div>
                  <div class="slide">
                     <div class="container"><img src="{{ asset('img/home/slider/slide_2.png') }}" alt="" /></div>
                  </div>
                  <div class="slide">
                     <div class="container"><img src="{{ asset('img/home/slider/slide_3.png') }}" alt="" /></div>
                  </div>
                  <div class="slide">
                     <div class="container"><img src="{{ asset('img/home/slider/slide_4.png') }}" alt="" /></div>
                  </div>
               </div>

               <div class="dots"></div>
            </div>
         </div>
      </section>

      {{-- Account type --}}
      <section id="profiles">
         <div class="container">
            <div class="col-12">
               <h2>@lang('home.section_2.title')</h2>
            </div>
         </div>

         <div class="container">
            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}" class="image">
                     <img src="{{ asset('img/home/contractor.png')}}" width="175" alt="Contractor" />
                  </a>
                  <div class="title">@lang('fields.account_types.contractor')</div>
                  <p>@lang('home.section_2.text_contractor')</p>
                  <a href="{{ route('profile', ['slug' => 'entrepreneur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>

            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}" class="image">
                     <img src="{{ asset('img/home/advisor.png')}}" width="175" alt="Advisor" />
                  </a>
                  <div class="title">@lang('fields.account_types.advisor')</div>
                  <p>@lang('home.section_2.text_advisor')</p>
                  <a href="{{ route('profile', ['slug' => 'conseiller']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>

            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}" class="image">
                     <img src="{{ asset('img/home/investor.png')}}" width="175" alt="Investor" />
                  </a>
                  <div class="title">@lang('fields.account_types.investor')</div>
                  <p>@lang('home.section_2.text_investor')</p>
                  <a href="{{ route('profile', ['slug' => 'investisseur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>

            <div class="col-3 lg-6 m-6 s-6 xs-4">
               <div class="user">
                  <a href="{{ route('profile', ['slug' => 'repreneur']) }}" class="image">
                     <img src="{{ asset('img/home/manager.png')}}" width="175" alt="Manager" />
                  </a>
                  <div class="title">@lang('fields.account_types.manager')</div>
                  <p>@lang('home.section_2.text_manager')</p>
                  <a href="{{ route('profile', ['slug' => 'repreneur']) }}">@lang('buttons.read_more')</a>
               </div>
            </div>
         </div>
      </section>

      {{-- Banner --}}
      <section id="banner" class="blue-pattern">
         <div class="container">
            <div class="col-12">
               <p>@lang('home.section_3.title')</p>
            </div>
         </div>
      </section>

      {{-- Project steps --}}
      <section id="steps">
         <div class="container">
            <div class="col-12">
               <h2>@lang('home.section_4.title')</h2>
               <div class="step">
                  <div class="image-number">
                     <img src="{{ asset('img/home/step_1.png') }}" width="150"  alt="Projet" />
                     <div class="bottomright">1</div>
                  </div>
                  <p>@lang('home.section_4.picture_1')</p>
               </div>
               <div class="step">
                  <div class="image-number">
                     <img src="{{ asset('img/home/step_2.png')}}" width="150"  alt="Investors" />
                     <div class="bottomright">2</div>
                  </div>
                  <p>@lang('home.section_4.picture_2')</p>
               </div>
               <div class="step">
                  <div class="image-number">
                     <img src="{{ asset('img/home/step_3.png') }}" width="150"  alt="Notifications" />
                     <div class="bottomright">3</div>
                  </div>
                  <p>@lang('home.section_4.picture_3')</p>
               </div>
               <div class="step">
                  <div class="image-number">
                     <img src="{{ asset('img/home/step_4.png') }}" width="150"  alt="Documents" />
                     <div class="bottomright">4</div>
                  </div>
                  <p>@lang('home.section_4.picture_4')</p>
               </div>
               <div class="step">
                  <div class="image-number">
                     <img src='{{ asset('img/home/step_5.png') }}' width="150"  alt="Offers" />
                     <div class="bottomright">5</div>
                  </div>
                  <p>@lang('home.section_4.picture_5')</p>
               </div>
            </div>

            @if( env('APP_ENV') !== 'production' )
               <div class="col-12 align-center">
                  <a href="{{ route('register') }}" class="button blue">@lang('home.section_4.button')</a>
               </div>
            @endif
         </div>
      </section>

      {{-- Features --}}
      <section id="features" class="grey-background">
         <div class="container">
            <div class="col-12">
               <h2>@lang('home.section_5.title')</h2>
               <p class="subtitle">@lang('home.section_5.subtitle')</p>
            </div>

            <div class="col-4 lg-4 m-6 s-6 xs-4">
               <div class="feature">
                  <div class="image">
                     <img src="{{ asset('img/home/feature_1.png')}}" width="160" alt="Relations" />
                  </div>
                  <p class="title">@lang('home.section_5.feature1title')</p>
                  <p>@lang('home.section_5.feature1')</p>
               </div>
            </div>

            <div class="col-4 lg-4 m-6 s-6 xs-4">
               <div class="feature">
                  <div class="image">
                     <img src="{{ asset('img/home/feature_2.png')}}" width="160" alt="Project" />
                  </div>
                  <p class="title">@lang('home.section_5.feature2title')</p>
                  <p>@lang('home.section_5.feature2')</p>
               </div>
            </div>

            <div class="col-4 lg-4 m-6 s-6 xs-4">
               <div class="feature">
                  <div class="image">
                     <img src="{{ asset('img/home/feature_3.png')}}" width="160" alt="Signature" />
                  </div>
                  <p class="title">@lang('home.section_5.feature3title')</p>
                  <p>@lang('home.section_5.feature3')</p>
               </div>
            </div>

            <div class="col-2 m-0 empty"></div>

            <div class="col-4 lg-4 m-6 s-6 xs-4">
               <div class="feature">
                  <div class="image">
                     <img src="{{ asset('img/home/feature_4.png')}}" width="160" alt="Directory" />
                  </div>
                  <p class="title">@lang('home.section_5.feature4title')</p>
                  <p>@lang('home.section_5.feature4')</p>
               </div>
            </div>

            <div class="col-4 lg-4 m-6 s-6 xs-4 last-feature">
               <div class="feature">
                  <div class="image">
                     <img src="{{ asset('img/home/feature_5.png')}}" width="160" alt="Dashboard" />
                  </div>
                  <p class="title">@lang('home.section_5.feature5title')</p>
                  <p>@lang('home.section_5.feature5')</p>
               </div>
            </div>
         </div>
      </section>

      {{-- Manager --}}
      <section id="manager" class="grey-pattern">
         <div class="container">
            <div class="col-6 lg-12 m-12 s-12 xs-4">
               <img class="montana" src="{{ asset('img/home/manager_schema.png')}}" width="400" alt="@lang('home.section_6.title')" />
            </div>

            <div class="col-6 lg-12 m-12 s-12 xs-4">
               <h2>@lang('home.section_6.title')</h2>

               <p>@lang('home.section_6.subtitle1')</p>
               <p>@lang('home.section_6.subtitle2')</p>
               <p>@lang('home.section_6.subtitle3')</p>
            </div>

            <div class="col-12 lg-12 m-12 s-12 xs-4 align-center">
               <button class="cta" disabled>@lang('home.section_6.button')</button>
            </div>
         </div>
      </section>

      {{-- Purpose --}}
      <section id="purpose" class="blue-pattern">
         <div class="container">
            <div class="row">
               <div class="col-1 lg-1 m-1 s-1 empty"></div>
               <div class="col-10 lg-10 m-10 s-10 xs-4">
                  <h2>@lang('home.section_7.title')</h2>
               </div>
            </div>

            <div class="row">
               <div class="col-1 lg-1 m-1 s-1 empty"></div>
               <div class="col-10 lg-10 m-10 s-10 xs-4">
                  <p>@lang('home.section_7.subtitle1')</p>
                  <p>@lang('home.section_7.subtitle2')</p>
               </div>
               <div class="col-12 align-center">
                  <a href="{{ route('team') }}" class="button red">@lang('home.section_7.button')</a>
               </div>
            </div>
         </div>
      </section>

      {{-- Banner --}}
      {{-- <section id="home-society">
      <div class="container">
      <div class="col-2 empty"></div>
      <div class="col-8">
      <p>@lang('home.section_8.title')</p>
      </div>
      <div class="col-2 empty"></div>
      </div>
      </section> --}}

      {{-- Customers --}}
      {{-- <section id="home-trust" class="grey-pattern-small">
      <div class="container">
      <div class="col-12">
      <h2>@lang('home.section_8.titletrust')</h2>
      </div>

      <div class="col-4">
      <div class="person">
      <img src="{{ asset('img/home/tmp/edgar.jpg') }}" width="85" height="85" alt="Edgar Morris" />
      <p>@lang('home.section_8.person_1.name')</p>
      </div>
      <div class="quote">
      <img src="{{ asset('img/home/tmp/airbnb.png') }}" height="30" alt="Airbnb" />
      <p>@lang('home.section_8.person_1.quote')</p>
      </div>
      </div>

      <div class="col-4">
      <div class="person">
      <img src="{{ asset('img/home/tmp/evelyn.jpg') }}" width="85" height="85" alt="Edgar Morris" />
      <p>@lang('home.section_8.person_2.name')</p>
      </div>
      <div class="quote">
      <img src="{{ asset('img/home/tmp/airbnb.png') }}" height="30" alt="Airbnb" />
      <p>@lang('home.section_8.person_2.quote')</p>
      </div>
      </div>

      <div class="col-4">
      <div class="person">
      <img src="{{ asset('img/home/tmp/alfred.jpg') }}" width="85" height="85" alt="Edgar Morris" />
      <p>@lang('home.section_8.person_3.name')</p>
      </div>
      <div class="quote">
      <img src="{{ asset('img/home/tmp/airbnb.png') }}" height="30" alt="Airbnb" />
      <p>@lang('home.section_8.person_3.quote')</p>
      </div>
      </div>
      </div>
      </section> --}}

      {{-- Social network --}}
      {{-- <section id="home-external-link">
      <div class="container">
      <div class="col-12 align-center">
      <a href="#" target="_blank"><span class="icon-facebook"></span></a>
      <a href="#" target="_blank"><span class="icon-twitter"></span></a>
      <a href="#" target="_blank"><span class="icon-linkedin"></span></a>
      </div>
      </div>
      </section> --}}
   </div>
@endsection
