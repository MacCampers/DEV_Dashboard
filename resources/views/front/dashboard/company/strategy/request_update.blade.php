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
                           <h3>@lang('parameters.company.strategies.add_member')</h3>
                        </div>
                        <div class="col-12 align-left">
                           <p>@lang('parameters.company.strategies.add_member_hint')</p>
                        </div>

                        <table class="table" id="company-members-strategy">
                           <tr>
                              <th width="33%">@lang('fields.last_name')</th>
                              <th width="33%" class="align-center">@lang('fields.email')</th>
                              <th width="34%">&nbsp;</th>
                           </tr>


                           @foreach( $company->users as $user )
                              <tr>
                                 <td>{{ $user->full_name }}</td>
                                 <td class="align-center">{{ $user->email }}</td>
                                 <td class="switch-role align-center">
                                    <input type="hidden" name="strategy_id" value="{{ $strategy->id }}" />

                                    <input id="user-{{ $user->id }}-admin" type="checkbox"  name="user_strategy" value="{{ $user->id }}" class="checkbox hidden"{{ $strategy->users->contains($user) ? ' checked' : '' }} />
                                    <label class="switchbox" for="user-{{ $user->id }}-admin"></label>
                                 </td>
                              </tr>
                           @endforeach
                        </table>

                     </div>
                  </section>

                  <section>
                     <div class="col-12 align-center">
                        <h3>@lang('parameters.company.strategies.update')</h3>
                     </div>
                     <form method="post" action="{{ route('send_strategy_update_request', ['id' => $strategy->id]) }}">
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
