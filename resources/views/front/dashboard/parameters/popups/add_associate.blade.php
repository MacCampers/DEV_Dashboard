<div id="add-associate-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('dashboard.guests.new_guest')</div>
         </div>
      </div>

      <form method="post" action="{{ route('add_associate', ['companyId' => $user->company_id]) }}" >
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
            <div class="col-12 align-center">
               <input type="submit" class="blue" value="@lang('buttons.submit')" />
            </div>
         </div>
      </form>
   </div>
</div>
