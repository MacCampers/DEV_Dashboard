<script>
var newsletterCaptchaCallback = function(response) {
   $("#newsletters-form").submit();
};
</script>

<form method="post" id="newsletters-form" action="{{ route('newsletter') }}" class="newsletter-form">
   {{ csrf_field() }}

   <div class="row">
      <input type="email" name="email" placeholder="@lang('home.footer.box_mail')" required />
      <button class="g-recaptcha blue" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-callback="newsletterCaptchaCallback">@lang('home.footer.button')</button>
   </div>
</form>
