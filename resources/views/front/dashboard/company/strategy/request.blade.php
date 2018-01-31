@extends('front.layout.dashboard')

@section('title', trans('parameters.company.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/parameters.js') }}"></script>
@endsection

@section('content')
   <div id="parameters">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               <section>
                  @include('front.dashboard.company.nav')
               </section>

               <div class="container">
                  <section>
                     <div class="row">
                        <div class="col-12 align-center">
                           <h3>@lang('parameters.company.strategies.create')</h3>
                           <p>@lang('parameters.company.strategies.create_hint')</p>
                        </div>
                     </div>
                  </section>

                  <section>
                     <form method="post" action="{{ route('send_strategy_creation_request') }}">
                        {{ csrf_field() }}

                        @include('front.dashboard.partials.strategy_request')

                        <div class="col-12 align-center">
                           <input type="submit" class="button blue" value="@lang('buttons.send')" />
                        </div>
                     </form>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
