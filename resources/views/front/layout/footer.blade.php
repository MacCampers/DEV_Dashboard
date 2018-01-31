<footer>
   <div class="container row">
     <div class="col-4">
        <div class="copyrights">
          <h1>Benoit Tabry<span class="blue">.</span></h1>
          <p>Copyright © 2018. Tous droits réservés.</p>
        </div>
     </div>
         <div class="col-2 lg-3 xs-2">
         <ul>
            <li><a href="{{ route('home') }}">@lang('pages.home')</a></li>
            <li><a href="{{ route('contact') }}">@lang('pages.contact')</a></li>
         </ul>
      </div>

      <div class="col-2 lg-3 xs-2">
         <ul>
            <li><a href="{{ route('cursus') }}">@lang('pages.cursus')</a></li>
            <li><a href="{{ route('legal') }}">@lang('legal.title')</a></li>
         </ul>
      </div>

      <div class="col-4 lg-6 s-12 newsletter">
         @include('front.partials.newsletter_form')

         <div class="social-icons">
            <a href="https://www.facebook.com/Sir.Ben.TimeLord" target="_blank"><span class="icon-facebook"></span></a>
            <a href="https://www.linkedin.com/in/benoit-tabry-7234b113b/" target="_blank"><span class="icon-linkedin"></span></a>
         </div>
      </div>
   </div>
</footer>
