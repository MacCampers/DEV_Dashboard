@extends('front.layout.master')

@section('title', trans('terms.title'))

@section('content')

   <div id="terms" class="page">
      <section id="team-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('terms.title_page')</h1>
            </div>
         </div>
      </section>

      <section id="terms-content">
         <div class="container">
            <div class="col-12">
               <p class="intro">@lang('terms.intro')</p>

               <article>
                  <h3>@lang('terms.article_1_title')</h3>
                  <div class="content">@lang('terms.article_1')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_2_title')</h3>
                  <div class="content">@lang('terms.article_2')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_3_title')</h3>
                  <div class="content">
                     <ol>
                        <li>@lang('terms.article_3_1')</li>
                        <li>@lang('terms.article_3_2')</li>
                        <li>@lang('terms.article_3_3')</li>
                        <li>@lang('terms.article_3_4')</li>
                        <li>@lang('terms.article_3_5')</li>
                     </ol>
                  </div>
               </article>

               <article>
                  <h3>@lang('terms.article_4_title')</h3>
                  <div class="content">@lang('terms.article_4')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_5_title')</h3>
                  <div class="content">@lang('terms.article_5')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_6_title')</h3>
                  <div class="content">@lang('terms.article_6')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_7_title')</h3>
                  <div class="content">@lang('terms.article_7')</div>
               </article>

               {{-- <article>
                  <p>@lang('terms.article_8_title')</p>
                  <div class="content">@lang('terms.article_8')</div>
               </article> --}}

               <article>
                  <h3>@lang('terms.article_8_title')</h3>
                  <div class="content">@lang('terms.article_8')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_9_title')</h3>
                  <div class="content">@lang('terms.article_9')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_10_title')</h3>
                  <div class="content">@lang('terms.article_10')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_11_title')</h3>
                  <div class="content">@lang('terms.article_11')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_12_title')</h3>
                  <div class="content">
                     <ol>
                        <li>@lang('terms.article_12_1')</li>
                        <li>@lang('terms.article_12_2')</li>
                        <li>@lang('terms.article_12_3')</li>
                        <li>@lang('terms.article_12_4')</li>
                     </ol>
                  </div>
               </article>

               <article>
                  <h3>@lang('terms.article_13_title')</h3>
                  <div class="content">@lang('terms.article_13')</div>
               </article>

               <article>
                  <h3>@lang('terms.article_14_title')</h3>
                  <div class="content">
                     <ol>
                        <li>@lang('terms.article_14_1')</li>
                        <li>@lang('terms.article_14_2')</li>
                        <li>@lang('terms.article_14_3')</li>
                        <li>@lang('terms.article_14_4')</li>
                     </ol>
                  </div>
               </article>

               <article>
                  <h3>@lang('terms.article_15_title')</h3>
                  <div class="content">
                     <ol>
                        <li>@lang('terms.article_15_1')</li>
                        <li>@lang('terms.article_15_2')</li>
                     </ol>
                  </div>
               </article>

               <article>
                  <h3>@lang('terms.article_16_title')</h3>
                  <div class="content">@lang('terms.article_16')</div>
               </article>
            </div>
         </div>
      </div>
   </section>

@endsection
