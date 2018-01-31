<div id="newsletter-popup" class="popup-container align-center">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="title">@lang('home.newsletter_popup.title')</div>

      <p>@lang('home.newsletter_popup.text')</p>
      <h4>@lang('home.newsletter_popup.cta_title')</h4>

      <div class="row">
         @include('front.partials.newsletter_form')
      </div>
   </div>
</div>
