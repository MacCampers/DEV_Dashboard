@extends('front.layout.master')

@section('title', trans('contact.title'))

@section('js')
   <script>
   function initMap() {
      var coord = {lat: 48.831677, lng: 2.236384};

      var map = new google.maps.Map(document.getElementById('map'), {
         zoom: 15,
         center: coord,
         mapTypeControl: false,
         fullscreenControl: false,
         styles: [
            {
               "featureType": "landscape.man_made",
               "elementType": "geometry",
               "stylers": [
                  {
                     "color": "#f7f1df"
                  }
               ]
            },
            {
               "featureType": "landscape.natural",
               "elementType": "geometry",
               "stylers": [
                  {
                     "color": "#d0e3b4"
                  }
               ]
            },
            {
               "featureType": "landscape.natural.terrain",
               "elementType": "geometry",
               "stylers": [
                  {
                     "visibility": "off"
                  }
               ]
            },
            {
               "featureType": "poi",
               "elementType": "labels",
               "stylers": [
                  {
                     "visibility": "off"
                  }
               ]
            },
            {
               "featureType": "poi.business",
               "elementType": "all",
               "stylers": [
                  {
                     "visibility": "off"
                  }
               ]
            },
            {
               "featureType": "poi.medical",
               "elementType": "geometry",
               "stylers": [
                  {
                     "color": "#fbd3da"
                  }
               ]
            },
            {
               "featureType": "poi.park",
               "elementType": "geometry",
               "stylers": [
                  {
                     "color": "#bde6ab"
                  }
               ]
            },
            {
               "featureType": "road",
               "elementType": "geometry.stroke",
               "stylers": [
                  {
                     "visibility": "off"
                  }
               ]
            },
            {
               "featureType": "road",
               "elementType": "labels",
               "stylers": [
                  {
                     "visibility": "off"
                  }
               ]
            },
            {
               "featureType": "road.highway",
               "elementType": "geometry.fill",
               "stylers": [
                  {
                     "color": "#ffe15f"
                  }
               ]
            },
            {
               "featureType": "road.highway",
               "elementType": "geometry.stroke",
               "stylers": [
                  {
                     "color": "#efd151"
                  }
               ]
            },
            {
               "featureType": "road.arterial",
               "elementType": "geometry.fill",
               "stylers": [
                  {
                     "color": "#ffffff"
                  }
               ]
            },
            {
               "featureType": "road.local",
               "elementType": "geometry.fill",
               "stylers": [
                  {
                     "color": "black"
                  }
               ]
            },
            {
               "featureType": "transit.station.airport",
               "elementType": "geometry.fill",
               "stylers": [
                  {
                     "color": "#cfb2db"
                  }
               ]
            },
            {
               "featureType": "water",
               "elementType": "geometry",
               "stylers": [
                  {
                     "color": "#a2daf2"
                  }
               ]
            }
         ]
      });
      var marker = new google.maps.Marker({
         position: coord,
         map: map
      });
   }

   var contactCaptchaCallback = function(response) {
      $('#contact-form button').addClass('disabled');
      $('#contact-form form').submit();
   };
   </script>

   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoygY0lBIqaLC9rhnYR2PZaYSffLRhgyE&callback=initMap"></script>
@endsection

@section('content')

   <div id="contact" class="page">
      {{-- Heading --}}
      <section id="contact-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('contact.title')</h1>
            </div>
         </div>
      </section>

      {{-- Contact form --}}
      <section id="contact-form">
         <div class="container">
            <div class="col-12">
               <form method="post" action="{{ route('contact_post') }}">
                  {{ csrf_field() }}

                  <div class="row">
                     <div class="col-6 s-12">
                        <div class="form-group required{{ $errors->has('name') ? ' has-error' : '' }}">
                           <label for="contact-name">@lang('contact.form.name')</label>
                           <input type="text" id="contact-name" name="name" value="{{ old('name') }}" />

                           @if( $errors->has('name') )
                              <p class="form-error">{{ $errors->first('name') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-6 s-12">
                        <div class="form-group required{{ $errors->has('email') ? ' has-error' : '' }}">
                           <label for="contact-email">@lang('contact.form.email')</label>
                           <input type="email" id="contact-email" name="email" value="{{ old('email') }}" />

                           @if( $errors->has('email') )
                              <p class="form-error">{{ $errors->first('email') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-8 s-12">
                        <div class="form-group required{{ $errors->has('subject') ? ' has-error' : '' }}">
                           <label for="contact-subject">@lang('contact.form.subject')</label>
                           <input type="text" id="contact-subject" name="subject" value="{{ old('subject') }}" />

                           @if( $errors->has('subject') )
                              <p class="form-error">{{ $errors->first('subject') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-12">
                        <div class="form-group required{{ $errors->has('name') ? ' has-error' : '' }}">
                           <label for="contact-message">@lang('contact.form.message')</label>
                           <textarea id="contact-message" name="message">{{ old('message') }}</textarea>

                           @if( $errors->has('message') )
                              <p class="form-error">{{ $errors->first('message') }}</p>
                           @endif
                        </div>

                        {{-- <div class="form-group">
                           <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-callback="contactCaptchaCallback"></div>

                           @if( $errors->has('g-recaptcha-response') )
                              <p class="form-error">{{ $errors->first('g-recaptcha-response') }}</p>
                           @endif
                        </div> --}}
                     </div>

                     <div class="col-12 align-center">
                        <button class="g-recaptcha blue" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-callback="contactCaptchaCallback">@lang('buttons.send')</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </section>

      {{-- Map --}}
      <section id="map-container">
         <div class="container">
            <div class="col-4 m-6 s-8 xs-4">
               <div class="address">
                  <p>
                     <strong>Equiteasy</strong><br />
                     84 avenue du Général Leclerc<br />
                     92100 Boulogne-Billancourt
                  </p>

                  <p><span class="icon-metro"></span><span>Billancourt</span></p>

                  <p>
                     +33 (0)1 84 19 49 40<br />
                     <strong>contact@equiteasy.com</strong>
                  </p>
               </div>
            </div>
         </div>

         <div id="map"></div>
      </section>
   </div>

@endsection
