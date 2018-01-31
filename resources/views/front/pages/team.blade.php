@extends('front.layout.master')

@section('title', trans('team.title'))

@section('content')

   <div id="team" class="page">
      {{-- Heading --}}
      <section id="team-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('team.title')</h1>
            </div>
         </div>
      </section>

      {{-- Team members --}}
      <section id="team-members">
         <div class="container">
            <div class="col-12 align-left">
               <div class="intro">
                  @lang('team.subtitles')
               </div>
            </div>
         </div>
         <div class="container">
            <div class="col-10 m-12 member">
               <div class="image" style="background-image: url({{ asset('img/team/quentin.jpg') }});"></div>

               <div class="text">
                  <h2>Quentin Ducouret</h2>
                  <div class="title">@lang('team.quentin.title')</div>
                  <p>@lang('team.quentin.text')</p>
               </div>
            </div>

            <div class="col-10 m-12 member">
               <div class="image" style="background-image: url({{ asset('img/team/barthelemy.jpg') }});"></div>

               <div class="text">
                  <h2>Barthélémy Névot</h2>
                  <div class="title">@lang('team.barthelemy.title')</div>
                  <p>@lang('team.barthelemy.text')</p>
               </div>
            </div>

            <div class="col-10 m-12 member">
               <div class="image" style="background-image: url({{ asset('img/team/thibault.jpg') }});"></div>

               <div class="text">
                  <h2>Thibault Pellequer</h2>
                  <div class="title">@lang('team.thibault.title')</div>
                  <p>@lang('team.thibault.text')</p>
               </div>
            </div>

            <div class="col-10 m-12 member">
               <div class="image" style="background-image: url({{ asset('img/team/anthea.jpg') }});"></div>

               <div class="text">
                  <h2>Anthéa Pernaud</h2>
                  <div class="title">@lang('team.anthea.title')</div>
                  <p>@lang('team.anthea.text')</p>
               </div>
            </div>

            <div class="col-10 m-12 member">
               <div class="image" style="background-image: url({{ asset('img/team/florian.jpg') }});"></div>

               <div class="text">
                  <h2>Florian Ano</h2>
                  <div class="title">@lang('team.florian.title')</div>
                  <p>@lang('team.florian.text')</p>
               </div>
            </div>
         </div>
      </section>
   </div>

@endsection
