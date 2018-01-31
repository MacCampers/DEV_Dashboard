@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.guests'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/guests.js') }}"></script>
@endsection

@section('content')
   <div id="project-guests">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="row">
                     @if( session('success_message') )
                        @include('front.dashboard.project.form.partials.success_message', ['message' => session('success_message')])
                     @endif

                     @if( session('error_message') )
                        @include('front.dashboard.project.form.partials.error_message', ['message' => session('error_message')])
                     @endif

                     <div class="col-12 align-center">
                        <h1>@lang('dashboard.guests.title')</h1>
                        <p class="subtitle">@lang('dashboard.guests.subtitle')</p>

                        <p>@lang('dashboard.guests.text')</p>

                        <section>
                           @if( $project->guests->count() > 0 )
                              <table id="guests" class="table valign-middle">
                                 <tr>
                                    <th width="33.333%">@lang('fields.last_name')</th>
                                    <th width="33.333%" class="align-center">@lang('common.roles.admin')</th>
                                    <th width="33.333%">&nbsp;</th>
                                 </tr>

                                 @foreach( $project->guests as $user )
                                    <tr>
                                       <td>{{ $user->full_name }} ({{ $user->email }})</td>
                                       @if( $user->is_admin )
                                          <td class="align-center">@lang('common.roles.' . $user->company_role)</td>
                                          <td class="align-right">
                                             <div class="button grey disabled small">@lang('buttons.delete')</div>
                                          </td>
                                       @elseif( $user->id === $project->signatory_id )
                                          <td class="switch-role align-center">
                                             <input id="user-{{ $user->id }}-admin" type="checkbox" name="user_admin" class="checkbox hidden"{{ $user->pivot->admin ? ' checked' : '' }} disabled />
                                             <label class="switchbox" for="user-{{ $user->id }}-admin"></label>
                                          </td>
                                          <td class="align-right">
                                             <div class="button grey disabled small">@lang('buttons.delete')</div>
                                          </td>
                                       @else
                                          <td class="switch-role align-center">
                                             <input type="hidden" name="project_id" value="{{ $project->id }}" />
                                             <input type="hidden" name="user_id" value="{{ $user->id }}" />

                                             <input id="user-{{ $user->id }}-admin" type="checkbox" name="user_admin" class="checkbox hidden"{{ $user->pivot->admin ? ' checked' : '' }} />
                                             <label class="switchbox" for="user-{{ $user->id }}-admin"></label>
                                          </td>
                                          <td class="align-right">
                                             @if( Auth::id() !== $user->id )
                                                <form method="post" action="{{ route('project_delete_guest', ['id' => $project->id, 'userId' => $user->id]) }}">
                                                   {{ csrf_field() }}
                                                   {{ method_field('delete') }}

                                                   <input type="submit" class="button red small" value="@lang('buttons.delete')" />
                                                </form>
                                             @else
                                                <div class="button small disabled">@lang('buttons.delete')</div>
                                             @endif
                                          </td>
                                       @endif
                                    </tr>
                                 @endforeach
                              </table>

                              @if( $project->guests->count() < 4 && !$project->stopped )
                                 <div id="add-guest" class="button blue small">@lang('buttons.add_guest_project')</div>
                              @endif
                           @else
                              @if( !$project->stopped )
                                 <div class="align-center">
                                    <p>@lang('dashboard.guests.empty')</p>

                                    <div id="add-guest" class="button blue small">@lang('buttons.add_guest_project')</div>
                                 </div>
                              @endif
                           @endif
                        </section>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="add-guest-popup" class="popup-container">
      <div class="popup">
         <span class="close icon-cross"></span>

         <div class="row">
            <div class="col-12">
               <div class="title">@lang('dashboard.guests.new_guest')</div>
            </div>
         </div>

         <form method="post" action="{{ route('project_add_guest', ['id' => $project->id]) }}" >
            {{ csrf_field() }}

            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('user_first_name') ? ' has-error' : '' }} required">
                     <label for="user-first-name">@lang('fields.first_name')</label>
                     <input type="text" id="user-first-name" name="user_first_name" placeholder="@lang('fields.first_name')" required />

                     @if( $errors->has('user_first_name') )
                        <p class="form-error">{{ $errors->first('user_first_name') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('user_last_name') ? ' has-error' : '' }} required">
                     <label for="user-last-name">@lang('fields.last_name')</label>
                     <input type="text" id="user-last-name" name="user_last_name" placeholder="@lang('fields.last_name')" required />

                     @if( $errors->has('user_last_name') )
                        <p class="form-error">{{ $errors->first('user_last_name') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('user_email') ? ' has-error' : '' }} required">
                     <label for="user-email">@lang('fields.email')</label>
                     <input type="text" id="user-email" name="user_email" placeholder="@lang('fields.email')" required />

                     @if( $errors->has('user_email') )
                        <p class="form-error">{{ $errors->first('user_email') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('user_phone_number') ? ' has-error' : '' }}">
                     <label for="user-phone-number">@lang('fields.phone_mobile')</label>
                     <input type="text" id="user-phone-number" class="phone-number" name="user_phone_number" placeholder="@lang('fields.phone_mobile')" />

                     @if( $errors->has('user_phone_number') )
                        <p class="form-error">{{ $errors->first('user_phone_number') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <div class="form-group{{ $errors->has('user_role') ? ' has-error' : '' }} required">
                     <label for="user-role">@lang('fields.role')</label>
                     <div class="hint">@lang('fields.role_hint')</div>
                     <select id="user-role" class="small" name="user_role">
                        <option value="1"{{ old('user_role', 0) == 1 ? ' selected' : '' }}>@lang('common.roles.admin')</option>
                        <option value="0"{{ old('user_role', 0) == 0 ? ' selected' : '' }}>@lang('common.roles.guest')</option>
                     </select>

                     @if( $errors->has('user_role') )
                        <p class="form-error">{{ $errors->first('user_role') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12 align-center">
                  <input type="submit" class="blue" value="@lang('buttons.submit')" />
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection
