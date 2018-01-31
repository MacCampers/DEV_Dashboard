@extends('front.layout.dashboard')

@section('title', trans('fields.company'))

@section('js')
   <script type="text/javascript">
      // Decline user request
      $('.decline-user-request').on('submit', function(e) {
         e.preventDefault();

         var form = $(this);

         swal({
            title: "@lang('popups.decline_user_request.title')",
            text: "@lang('popups.decline_user_request.text')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: false,
            cancelButtonColor: false,
            confirmButtonText: "@lang('popups.decline_user_request.confirm')",
            cancelButtonText: "@lang('buttons.cancel')"
         }, function(confirm) {
            if( confirm ) {
               form.get(0).submit();
            } else {
               form.find('input[type=submit]').prop('disabled', false);
            }
         });
      });

      // Accept user request
      $('.accept-user-request').on('submit', function(e) {
         e.preventDefault();

         var form = $(this);

         swal({
            title: "@lang('popups.accept_user_request.title')",
            text: "@lang('popups.accept_user_request.text')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: false,
            cancelButtonColor: false,
            confirmButtonText: "@lang('popups.accept_user_request.confirm')",
            cancelButtonText: "@lang('buttons.cancel')"
         }, function(confirm) {
            if( confirm ) {
               form.get(0).submit();
            } else {
               form.find('input[type=submit]').prop('disabled', false);
            }
         });
      });

      // Decline user request
      $('.delete-user').on('submit', function(e) {
         e.preventDefault();

         var form = $(this);

         swal({
            title: "@lang('popups.delete_user.title')",
            text: "@lang('popups.delete_user.text')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: false,
            cancelButtonColor: false,
            confirmButtonText: "@lang('popups.delete_user.confirm')",
            cancelButtonText: "@lang('buttons.cancel')"
         }, function(confirm) {
            if( confirm ) {
               form.get(0).submit();
            } else {
               form.find('input[type=submit]').prop('disabled', false);
            }
         });
      });
   </script>

   <script type="text/javascript" src="{{ asset('/js/front/parameters.js') }}"></script>
@endsection

@section('content')
   <div id="parameters">
      <div class="container">
         <div class="col-12">
            <div class="panel{{ $company->pending_users->count() > 0 ? ' with-alert': '' }}">
               @include('front.dashboard.company.nav')

               @if( $user->is_admin )
                  @if( session('success_message') )
                     <div class="container">
                        @include('front.dashboard.project.form.partials.success_message')
                     </div>
                  @endif

                  @if( $company->pending_users->count() > 0 )
                     @include('front.dashboard.partials.warning', ['message' => trans('parameters.company.members.pending_request')])
                  @endif

                  <div class="container">
                     <div class="col-12">
                        @if( $company->pending_users->count() > 0 )
                           <section>
                              <table class="table">
                                 <tr>
                                    <th>@lang('fields.last_name')</th>
                                    <th>@lang('fields.email')</th>
                                    <th>&nbsp;</th>
                                 </tr>
                                 @foreach( $company->pending_users as $user )
                                    <tr>
                                       <td>{{ $user->full_name }}</td>
                                       <td>{{ $user->email }}</td>
                                       <td class="align-right">
                                          <form method="post" action="{{ route('accept_company_user', ['companyId' => $company->id, 'userId' => $user->id]) }}" class="inline accept-user-request">
                                             {{ csrf_field() }}
                                             <input type="submit" class="button blue small" value="@lang('buttons.accept')" />
                                          </form>
                                          <form method="post" action="{{ route('decline_company_user', ['companyId' => $company->id, 'userId' => $user->id]) }}" class="inline decline-user-request">
                                             {{ csrf_field() }}
                                             <input type="submit" class="button red small" value="@lang('buttons.decline')" />
                                          </form>
                                       </td>
                                    </tr>
                                 @endforeach
                              </table>
                           </section>
                        @endif

                        <section>
                           <h2>@lang('parameters.company.members.members_list')</h2>

                           <table id="company-members" class="table valign-middle">
                              <tr>
                                 <th width="30%">@lang('fields.last_name')</th>
                                 <th width="30%" class="align-center">@lang('common.roles.admin')</th>
                                 <th width="20%" class="align-center">@lang('parameters.company.members.strategies')</th>
                                 <th width="20%">&nbsp;</th>
                              </tr>

                              @foreach( $company->active_users as $user )
                                 <tr>
                                    <td>{{ $user->full_name }}</td>
                                    @if( $user->company_role === 'representative' || $user->id === Auth::user()->id )
                                       <td class="align-center">@lang('common.roles.' . $user->company_role)</td>
                                       <td class="align-center">{{ $user->strategies->count() }}</td>
                                       <td class="align-right">
                                          <div class="button disabled small">@lang('buttons.delete')</div>
                                       </td>
                                    @else
                                       <td class="switch-role align-center">
                                          <input type="hidden" name="company_id" value="{{ $company->id }}" />
                                          <input type="hidden" name="user_id" value="{{ $user->id }}" />

                                          <input id="user-{{ $user->id }}-admin" type="checkbox"  name="user_admin" class="checkbox hidden"{{ $user->company_role === 'admin' ? ' checked' : '' }} />
                                          <label class="switchbox" for="user-{{ $user->id }}-admin"></label>
                                       </td>
                                       <td class="align-center">{{ $user->strategies->count() }}</td>
                                       <td class="align-right">
                                          <form method="post" action="{{ route('delete_company_user', ['companyId' => $company->id, 'userId' => $user->id]) }}" class="delete-user">
                                             {{ csrf_field() }}
                                             <input type="submit" class="button red small" value="@lang('buttons.delete')" />
                                          </form>
                                       </td>
                                    @endif
                                 </tr>
                              @endforeach
                           </table>

                           <div id="add-member" class="button blue small">@lang('buttons.add_member')</div>
                        </section>
                     </div>
                  </div>
               @else
                  <div class="container">
                     <div class="col-12">
                        <section>
                           <h2>@lang('parameters.company.members.members_list')</h2>

                           <table class="table">
                              <tr>
                                 <th>@lang('fields.last_name')</th>
                                 <th>@lang('fields.role')</th>
                              </tr>
                              @foreach( $company->users as $user )
                                 <tr>
                                    <td>{{ $user->full_name }}</td>
                                    <td>@lang('common.roles.' . $user->company_role)</td>
                                 </tr>
                              @endforeach
                           </table>
                        </section>
                     </div>
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>

   <div id="add-member-popup" class="popup-container">
      <div class="popup large">
         <span class="close icon-cross"></span>

         <div class="row">
            <div class="col-12">
               <div class="title">@lang('parameters.company.members.new_member')</div>
            </div>
         </div>

         <form method="post" action="{{ route('add_company_user', ['companyId' => $company->id]) }}" >
            {{ csrf_field() }}

            <div class="row">
               <div class="col-6">
                  <div class="form-group{{ $errors->has('user_first_name') ? ' has-error' : '' }} required">
                     <label for="user-first-name">@lang('fields.first_name')</label>
                     <input type="text" id="user-first-name" name="user_first_name" placeholder="@lang('fields.first_name')" required />

                     @if( $errors->has('user_first_name') )
                        <p class="form-error">{{ $errors->first('user_first_name') }}</p>
                     @endif
                  </div>
               </div>
               <div class="col-6">
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
               <div class="col-6">
                  <div class="form-group{{ $errors->has('user_email') ? ' has-error' : '' }} required">
                     <label for="user-email">@lang('fields.email')</label>
                     <input type="text" id="user-email" name="user_email" placeholder="@lang('fields.email')" required />

                     @if( $errors->has('user_email') )
                        <p class="form-error">{{ $errors->first('user_email') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-6">
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
               <div class="col-6">
                  <div class="form-group{{ $errors->has('user_role') ? ' has-error' : '' }} required">
                     <label for="user-role">@lang('fields.role')</label>
                     <select id="user-role" name="user_role">
                        <option value="admin"{{ old('user_role', 'guest') === 'admin' ? ' selected' : '' }}>@lang('common.roles.admin')</option>
                        <option value="guest"{{ old('user_role', 'guest') === 'guest' ? ' selected' : '' }}>@lang('common.roles.guest')</option>
                     </select>

                     @if( $errors->has('user_role') )
                        <p class="form-error">{{ $errors->first('user_role') }}</p>
                     @endif
                  </div>
               </div>
            </div>

            @if( $company->strategies->count() > 0 )
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>@lang('parameters.company.members.attach_strategies')</label>
                        <ul class="recursive-list">
                           @foreach( $company->strategies as $strategy )
                              <li>
                                 <input id="strategy-{{ $strategy->id }}" type="checkbox" name="user_strategies[]" value="{{ $strategy->id }}"{{ in_array($strategy->id, old('user_strategies', [])) ? ' checked' : '' }} />
                                 <label for="strategy-{{ $strategy->id }}">{{ $strategy->name }}</label>
                                 <span class="checkmark"></span>
                              </li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
               </div>
            @endif

            <div class="row">
               <div class="col-12 align-center">
                  <input type="submit" class="blue" value="@lang('buttons.submit')" />
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection
