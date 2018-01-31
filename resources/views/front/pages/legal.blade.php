@extends('front.layout.master')

@section('title', trans('legal.title'))

@section('content')

   <div id="team" class="page">
      {{-- Heading --}}
      <section id="team-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('legal.title')</h1>
            </div>
         </div>
      </section>

      <section id="team-members">
         <div class="container">
            <div class="col-12">
               @lang('legal.text')
            </div>
         </div>
      </section>
   </div>

@endsection
