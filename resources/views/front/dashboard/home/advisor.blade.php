@extends('front.layout.dashboard')

@section('title', trans('dashboard.title'))

@section('js')
   <script type="text/javascript">
   $(function() {
      $('.new-project').on('click', function(e) {
         if ($(this).hasClass('disabled')) {
            e.preventDefault();
         }
         $(this).addClass('disabled');
         $('.new').addClass('disabled');
      });
   });
   </script>
@endsection

@section('content')
   <div id="projects">
      <div class="container">
         <div class="col-12">
            <section class="panel {{ !$user->company->isSubscribed() ? 'with-alert' : ''}}">
               @if( !$user->company->isSubscribed() )
                  <section class="alert">
                     <div class="container">
                        <div class="col-12 align-center">
                           <p>@lang('auth.subscription_ended')</p>

                           @if( $user->company_role === 'representative' )
                              <a href="{{ route('parameters_subscription') }}" class="button red small">@lang('buttons.manage_subscription')</a>
                           @endif
                        </div>
                     </div>
                  </section>
               @endif
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
                     <div class="projects-container">
                        @if( isset($projects) )
                           @foreach( $projects as $project )
                              @include('front.dashboard.partials.project')
                           @endforeach
                        @endif

                        @if( $user->canCreateProject() && $user->company->isSubscribed() )
                           <div class="col-4 m-6 s-12">
                              <a class="new-project" href="{{ route('project_create') }}">
                                 <div class="new project">
                                    <div class="text">
                                       <span class="icon-add"></span>
                                       <p class="new-create">@lang('dashboard.new')</p>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        @else
                           <div class="col-12">
                              <p>@lang('dashboard.home.no_subscription')</p>
                           </div>
                        @endif
                     </div>
                  @endif
               </div>
            </section>
         </div>
      </div>
   </div>
@endsection
