<div class="alert account-unverified">
   <p>@lang('auth.account_unverified')</p>

   <form method="post" action="{{ route('send_activation_link') }}">
      {{ csrf_field() }}
      <p><input type="submit" class="link" value="@lang('auth.send_activation_link')" /></p>
   </form>
</div>
