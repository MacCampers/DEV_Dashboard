@extends('front.layout.dashboard')

@section('title', trans('dashboard.title'))

@section('content')
   <div id="projects">
      <div class="container">
         <div class="col-12">
            <section class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.home.title')</h1>
                  </div>

                  @if( !$user->confirmed )
                     <div class="col-12 align-center">
                        <p>@lang('auth.account_unverified')</p>

                        <form method="post" action="{{ route('send_activation_link') }}">
                           {{ csrf_field() }}

                           <input type="submit" class="button red small" value="@lang('auth.send_activation_link')" />
                        </form>
                     </div>
                  @else
                     @if( isset($projects) )
                        <div class="projects-container">
                           @foreach( $projects as $project )
                              @include('front.dashboard.partials.project')
                           @endforeach
                        </div>
                     @endif
                  @endif
               </div>
            </section>
         </div>
      </div>
   </div>
@endsection
