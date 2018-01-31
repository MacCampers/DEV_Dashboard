<section class="alert">
   <div class="container">
      <div class="col-12">
         <p>@lang('dashboard.match_overview.signatory_warning')</p>
      </div>
   </div>
</section>

<div class="container">
   <div class="col-12 align-center">
      <p><strong>@lang('dashboard.match_overview.select_signatory')</strong></p>

      <form id="select-signatory" method="post" action="{{ route('match_update_signatory', ['id' => $match->id]) }}">
         {{ csrf_field() }}

         <table class="table">
            <tr>
               <th width="30"></th>
               <th>@lang('fields.name')</th>
               <th>@lang('fields.email')</th>
               <th>@lang('fields.phone')</th>
            </tr>

            @foreach( $match->matchable->users as $user )
               <tr class="selectable">
                  <td class="align-center">
                     <input type="radio" id="signatory-id-{{ $user->id }}" name="signatory_id" value="{{ $user->id }}" data-phone-number="{{ $user->phone_mobile }}"{{ $user->company_role === 'representative' ? ' checked' : '' }} />
                  </td>
                  <td><strong>{{ $user->full_name }}</strong></td>
                  <td>{{ $user->email }}</td>
                  @if( !$user->phone_mobile )
                     <td><span class="missing">@lang('common.missing')</span></td>
                  @else
                     <td>{{ $user->phone_mobile }}</td>
                  @endif
               </tr>
            @endforeach
         </table>

         <div class="form-group">
            <div id="add-user" class="button blue small">@lang('buttons.add_user')</div>
         </div>

         <div id="signatory-phone-number-popup" class="popup-container">
            <div class="popup">
               <span class="close icon-cross"></span>

               <p><strong>@lang('dashboard.match_overview.signatory_phone_number')</strong></p>

               <div class="form-group">
                  <input type="text" id="signatory-phone-number" name="signatory_phone_number" class="phone-number" required />
               </div>

               <input type="submit" class="blue" value="@lang('buttons.submit')" />
            </div>
         </div>

         <div id="set-phone-number" class="button blue">@lang('buttons.submit')</div>
      </form>

      <div id="add-user-popup" class="popup-container align-left">
         <div class="popup">
            <span class="close icon-cross"></span>

            <div class="title">@lang('popups.add_user.title')</div>

            <form method="post" action="{{ route('add_company_user', ['companyId' => $match->matchable->company->id]) }}">
               {{ csrf_field() }}

               <div class="row">
                  <div class="col-12">
                     <div class="form-group required{{ $errors->has('user_first_name') ? ' has-error' : '' }}">
                        <label for="user-first-name">@lang('fields.first_name')</label>
                        <input type="text" id="user-first-name" name="user_first_name" placeholder="@lang('fields.first_name')" required />

                        @if( $errors->has('user_first_name') )
                           <p class="form-error">{{ $errors->first('user_first_name') }}</p>
                        @endif
                     </div>

                     <div class="form-group required{{ $errors->has('user_last_name') ? ' has-error' : '' }}">
                        <label for="user-last-name">@lang('fields.last_name')</label>
                        <input type="text" id="user-last-name" name="user_last_name" placeholder="@lang('fields.last_name')" required />

                        @if( $errors->has('user_last_name') )
                           <p class="form-error">{{ $errors->first('user_last_name') }}</p>
                        @endif
                     </div>

                     <div class="form-group required{{ $errors->has('user_email') ? ' has-error' : '' }}">
                        <label for="user-email">@lang('fields.email')</label>
                        <input type="email" id="user-email" name="user_email" placeholder="@lang('fields.email')" required />

                        @if( $errors->has('user_email') )
                           <p class="form-error">{{ $errors->first('user_email') }}</p>
                        @endif
                     </div>

                     <div class="form-group required{{ $errors->has('user_phone_number') ? ' has-error' : '' }}">
                        <label for="user-phone-number">@lang('fields.phone_mobile')</label>
                        <input type="text" id="user-phone-number" class="phone-number" name="user_phone_number" required />

                        @if( $errors->has('user_phone_number') )
                           <p class="form-error">{{ $errors->first('user_phone_number') }}</p>
                        @endif
                     </div>
                  </div>

                  <div class="col-12 align-center">
                     <input type="hidden" name="user_strategies[]" value="{{ $match->matchable_id }}" />

                     <input type="submit" class="blue" value="@lang('buttons.submit')" />
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
