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
               </div>

               @if( !$user->confirmed )
                  <div class="container">
                     <div class="col-12 align-center">
                        <p>@lang('auth.account_unverified')</p>

                        <form method="post" action="{{ route('send_activation_link') }}">
                           {{ csrf_field() }}

                           <input type="submit" class="button red small" value="@lang('auth.send_activation_link')" />
                        </form>
                     </div>
                  </div>
               @else
                  @if( $user->company_role === 'pending' )
                     <div class="container">
                        <div class="col-12 align-center">
                           <p>@lang('dashboard.home.investor.pending', ['company' => $user->company->name])</p>
                        </div>
                     </div>
                  @else
                     @if( $matches->count() > 0 )
                        <div class="container">
                           <div class="projects-container">
                              @foreach( $matches as $match )
                                 @php $project = $match->project; @endphp
                                 @include('front.dashboard.partials.match')
                              @endforeach
                           </div>
                        </div>
                     @else
                        <section class="alert">
                           <div class="row">
                              <div class="col-12 align-center">
                                 <p>@lang('dashboard.home.investor.empty')</p>
                              </div>
                           </div>
                        </section>

                        @if( $user->is_admin )
                           <div class="container">
                              <section>
                                 <div class="row">
                                    <div class="col-12 align-center">
                                       <p>@lang('dashboard.home.investor.company')</p>
                                       <a class="blue button" href="{{ route('company_information') }}">@lang('buttons.company')</a>
                                    </div>
                                 </div>
                              </section>
                           </div>
                        @endif
                     @endif
                  @endif
               @endif
            </section>
         </div>
      </div>
   </div>
@endsection
