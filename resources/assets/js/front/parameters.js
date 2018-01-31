$(function() {

   /*
   |--------------------------------------------------------------------------
   | Company
   |--------------------------------------------------------------------------
   */

   // Cancel company member
   $('#add-member').on('click', function() {
      openPopup($('#add-member-popup'));
   });

   // Switch user's role
   $('#company-members').on('click', '.switch-role .checkbox', function() {
      var companyId = $(this).parent().find('input[name=company_id]').val();
      var userId = $(this).parent().find('input[name=user_id]').val();

      $.ajax({
         method: 'POST',
         url: '/company/' + companyId + '/switch_role/' + userId,
         data: {
            admin: $(this).prop('checked')
         }
      });
   });


   /*
   |--------------------------------------------------------------------------
   | Strategies
   |--------------------------------------------------------------------------
   */

   // Switch user's strat
   $('#company-members-strategy').on('click', '.switch-role .checkbox', function() {

      if( $('#company-members-strategy .switch-role .checkbox:checked').length < 2 ) {
         $('#company-members-strategy .switch-role .checkbox:checked').prop('disabled', true);
      } else {
         $('#company-members-strategy .switch-role .checkbox:checked').prop('disabled', false);
      }

      var strategyId = $(this).parent().find('input[name=strategy_id]').val();

      $.ajax({
         method: 'POST',
         url: '/company/strategy/' + strategyId + '/switch_user',
         data: {
            checked: $(this).prop('checked'),
            userId: $(this).val(),
         }
      });

   });
   if( $('#company-members-strategy .switch-role .checkbox:checked').length < 2 ) {
      $('#company-members-strategy .switch-role .checkbox:checked').prop('disabled', true);
   }


   /*
   |--------------------------------------------------------------------------
   | Subscription
   |--------------------------------------------------------------------------
   */

   // Update credit card
   $('#update-credit-card').on('click', function() {
      openPopup($('#credit-card-popup'));
   });

   // Update IBAN
   $('#update-sepa').on('click', function() {
      openPopup($('#sepa-popup'));
   });

   // Upgrade subscription
   $('#upgrade-subscription').on('click', function() {
      openPopup($('#upgrade-subscription-popup'));
   });

   // Cancel subscription
   $('#cancel-subscription').on('click', function() {
      openPopup($('#cancel-subscription-popup'));
   });

   // Update billing address
   $('#update-billing-address').on('click', function() {
      openPopup($('#update-billing-address-popup'));
   });

   function creditCardStripeResponseHandler(status, response) {
      var form = $('#update-card-form');

      if( response.error ) {
         $('#update-card-form input[type=submit]').prop('disabled', false).removeClass('disabled'); // Re-enable submission
         showError(response.error);
      } else {
         var token = response.id;

         // Insert the token into the form so it gets submitted to the server:
         form.append($('<input type="hidden" name="stripeToken" />').val(token));

         // Submit the form:
         form.get(0).submit();
      }
   }

   function stripeResponseHandlerSepa(status, response) {
      var form = $('#update-sepa-form');

      if( response.error ) {
         $('#update-card-form input[type=submit]').prop('disabled', false).removeClass('disabled'); // Re-enable submission
         showError(response.error);
      } else {
         var token = response.id;

         // Insert the token into the form so it gets submitted to the server:
         form.append($('<input type="hidden" name="stripeToken" />').val(token));

         // Submit the form:
         form.get(0).submit();
      }
   }

   // Submit credit card information
   $('#credit-card-popup').on('submit', '#update-card-form', function(e) {
      e.preventDefault();

      $('#update-card-form input[type=submit]').prop('disabled', true).addClass('disabled'); // Disable submit button

      Stripe.card.createToken({
         number: $('#cc-number').val(),
         cvc: $('#cc-cvc').val(),
         exp_month: $('#cc-exp-month').val(),
         exp_year: $('#cc-exp-year').val(),
         name: $('#cc-name').val(),
      }, creditCardStripeResponseHandler);
   });

   // Submit sepa information
   $('#sepa-popup').on('submit', '#update-sepa-form', function(e) {
      e.preventDefault();

      $('#update-sepa-form input[type=submit]').prop('disabled', true).addClass('disabled'); // Disable submit button

      Stripe.source.create({
         type: 'sepa_debit',
         sepa_debit: {
            iban: $('#sepa-iban').val(),
         },
         currency: 'eur',
         owner: {
            name: $('#sepa-name').val(),
         },
      }, stripeResponseHandlerSepa);
   });

   function newSubscriptionStripeResponseHandler(status, response) {
      var form = $('#new-subscription-popup form');

      if( response.error ) {
         $('#new-subscription-popup input[type=submit]').prop('disabled', false).removeClass('disabled'); // Re-enable submission
         showError(response.error);
      } else {
         var token = response.id;

         // Insert the token into the form so it gets submitted to the server:
         form.append($('<input type="hidden" name="stripeToken" />').val(token));

         // Submit the form:
         form.get(0).submit();
      }
   }

   function showError(error) {
      $('.form-group').removeClass('has-error');

      if( error.code === 'invalid_expiry_month' ) {
         $('.form-group[data-name=cc_exp_month]').addClass('has-error');
      } else if( error.code === 'incorrect_number' || error.type === 'invalid_request_error' || error.type === 'invalid_request_error' ) {
         $('.form-group[data-name=cc_number]').addClass('has-error');
      }
   }

   // Open popup
   $('#renew-subscription').on('click', function() {
      openPopup($('#new-subscription-popup'));
   });

   // Next/previous step
   $('#new-subscription-popup').on('click', '.next-step', function() {
      var popup = $('#new-subscription-popup');

      var currentStep = popup.find('.subscription-step.current');
      var nextStep = currentStep.next();

      // Move current step to the left
      TweenMax.to(currentStep, .4, {x: -800, alpha: 0, ease: Power1.easeInOut, onComplete: function() {
         currentStep.removeClass('current');
         nextStep.addClass('current');
      }});

      // Place next step at the center of the screen
      TweenMax.to(nextStep, .6, {x: 0, alpha: 1, ease: Power2.easeOut});

      var currentDot = $('.dot.current');
      currentDot.next().addClass('current');
      currentDot.removeClass('current');
   }).on('click', '.previous-step', function() {
      var popup = $('#new-subscription-popup');

      var currentStep = popup.find('.subscription-step.current');
      var previousStep = currentStep.prev();

      // Move current step to the right
      TweenMax.to(currentStep, .4, {x: 800, alpha: 0, ease: Power1.easeInOut, onComplete: function() {
         currentStep.removeClass('current');
         previousStep.addClass('current');
      }});

      // Place next step at the center of the screen
      TweenMax.to(previousStep, .6, {x: 0, alpha: 1, ease: Power2.easeOut});

      var currentDot = $('.dot.current');
      currentDot.prev().addClass('current');
      currentDot.removeClass('current');
   }).on('click', '.plan-selector', function() {
      $('#new-subscription-popup').find('.next-step').removeClass('disabled');
   });

   // Submit form
   $('#new-subscription-popup').on('submit', 'form', function(e) {
      e.preventDefault();

      Stripe.card.createToken({
         number: $('#cc-number').val(),
         cvc: $('#cc-cvc').val(),
         exp_month: $('#cc-exp-month').val(),
         exp_year: $('#cc-exp-year').val(),
         name: $('#cc-name').val()
      }, newSubscriptionStripeResponseHandler);
   });

});
