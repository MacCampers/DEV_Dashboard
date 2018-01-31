var buttonsDisabled = false;

function nextStep() {
   if( !buttonsDisabled ) {
      buttonsDisabled = true;

      var currentStep = $('.registration-step.current');
      var nextStep = $('.registration-step.current').next();

      // Move current step to the left
      TweenMax.to(currentStep, .4, {marginLeft: -1200, alpha: 0, ease: Power1.easeInOut, onComplete: function() {
         currentStep.removeClass('current');
         nextStep.addClass('current');

         buttonsDisabled = false;
      }});

      // Place next step at the center of the screen
      TweenMax.to(nextStep, .6, {marginLeft: 0, alpha: 1, ease: Power2.easeOut});

      var currentDot = $('.dot.current');
      currentDot.next().addClass('current');
      currentDot.removeClass('current');
   }
}

function previousStep() {
   if( !buttonsDisabled ) {
      buttonsDisabled = true;

      var currentStep = $('.registration-step.current');
      var previousStep = $('.registration-step.current').prev();

      // Move current step to the right
      TweenMax.to(currentStep, .4, {marginLeft: 800, alpha: 0, ease: Power1.easeInOut, onComplete: function() {
         currentStep.removeClass('current');
         previousStep.addClass('current');

         buttonsDisabled = false;
      }});

      // Place previous step at the center of the screen
      TweenMax.to(previousStep, .6, {marginLeft: 0, alpha: 1, ease: Power2.easeOut});

      var currentDot = $('.dot.current');
      currentDot.prev().addClass('current');
      currentDot.removeClass('current');
   }
}

function validateForm(errors) {
   $('.form-group').removeClass('has-error');

   if( Object.keys(errors).length > 0 ) {
      $.each(errors, function(index, error) {
         var group = $('.form-group[data-name='+ index +']');

         group.addClass('has-error');
         group.find('.form-error').html(error[0]);
      });
   } else {
      if( Modernizr.mq('(max-width: 850px)') ) {
         $('html, body').animate({ scrollTop: 0 }, 400, nextStep);
      } else {
         nextStep();
      }
   }
}

function setRequiredFields() {
   var companyType = $('.company-category-selector').val();

   if( companyType === 'business_angel' ) {
      $('#company-name').parents('.form-group').hide();
   } else {
      $('#company-name').parents('.form-group').show();
   }

   if( companyType === 'business_angel' || companyType === 'business_angels_assoc' ) {
      $('#company-name').prop('required', false);
      $('#company-name').parents('.form-group').removeClass('required');

      $('#company-registration-number').prop('required', false);
      $('#company-registration-number').parent().removeClass('required');
   } else {
      $('#company-name').prop('required', true);
      $('#company-name').parents('.form-group').addClass('required');

      $('#company-registration-number').prop('required', true);
      $('#company-registration-number').parent().addClass('required');
   }
}

$(function() {

   // Show / hide elements
   $('.checkbox.with-input > input').on('click', function(){
      $('.related-inputs').slideUp(100);
      $(this).parent().find('.related-inputs').slideDown(100);
   })

   // Disable form submissing by hitting enter
   $('#register-form').on('keypress', function(e) {
      if( e.which === 13 ) {
         e.preventDefault();
         return false;
      }
   });

   // Disable button when terms and conditions are not accepted
   $('#cgu').on('click', function() {
      if( $(this).is(':checked') ) {
         $('#button-payment').removeAttr('disabled');
         $('#submit-cgu').removeClass('disabled');
      } else {
         $('#button-payment').attr('disabled', true);
         $('#submit-cgu').addClass('disabled');
      }
   });

   // Open terms validation in a popup for investors
   $('#investor-register').on('click', function() {
      openPopup($('#cgu-popup'));
   });

   // Submit coupon for validation
   $('#submit-coupon').on('click', function() {
      var coupon = $('.coupon');
      var button = $(this);
      var input = $(this).parent().find('input');

      coupon.addClass('disabled').removeClass('has-error');
      button.addClass('disabled');

      $.ajax({
         method: 'POST',
         url: '/register/validate_coupon',
         dataType: 'json',
         data: {
            coupon: $('#coupon').val()
         },
         success: function(response) {
            if( response.error ) {
               coupon.addClass('has-error');
               coupon.find('.form-error').html(response.error);

               coupon.removeClass('disabled');
               button.removeClass('disabled');
            } else {
               button.html('<span class="icon-check"></span>');
               coupon.addClass('verified');
               input.prop('readonly', true);
            }
         }
      });
   });

   // Accept terms and condition
   $('#submit-cgu').on('click', function(){
      $('#register-form').submit();
   });

   // Validate user
   $('#submit-user').on('click', function() {
      $.ajax({
         method: 'POST',
         url: '/register/validate_user',
         dataType: 'json',
         data: {
            user_title: $('#user-title').val(),
            user_first_name: $('#user-first-name').val(),
            user_last_name: $('#user-last-name').val(),
            user_email: $('#user-email').val(),
            user_phone_mobile: $('#user-phone-mobile').val(),
            user_birth_date: $('#user-birth-date').val(),
            user_password: $('#user-password').val(),
            user_password_confirmation: $('#user-password-confirmation').val()
         },
         success: function(response) {
            validateForm(response.errors);
         }
      });
   });

   // Validate company
   $('#submit-company').on('click', function() {
      $.ajax({
         method: 'POST',
         url: '/register/validate_company',
         dataType: 'json',
         data: {
            company_name: $('#company-name').val(),
            company_registration_number: $('#company-registration-number').val(),
            company_address: $('#company-address').val(),
            company_phone: $('#company-phone').val(),
            company_zipcode: $('#company-zipcode').val(),
            company_city: $('#company-city').val(),
            company_country_id: $('#company-country-id').val()
         },
         success: function(response) {
            validateForm(response.errors);
         }
      });
   });

   // Validate subscription
   $('.plan-selector').on('click', function() {
      $('#submit-subscription').removeClass('disabled');
   });
   $('#submit-subscription').on('click', function() {
      if( $('input[name=subscription]:checked').length > 0 ) {
         validateForm([]);
      }
   });

   // Set required fields depending on selected company category
   $('.company-category-selector').on('change', function() {
      $('#company-name-autocomplete .reset').trigger('click');
      setRequiredFields();
   });

   // Autocomplete company information
   $('#company-name').on('keyup focus', function() {
      var value = $(this).val();
      var list = $(this).parent().find('ul');

      if( value.length > 2 ) {
         $.ajax({
            method: 'POST',
            url: '/register/autocomplete_company',
            data: {
               search: value
            },
            success: function(response) {
               list.find('li').remove();

               $.each(response.companies, function(i, company) {
                  var address = company.zipcode ? ' ' + company.zipcode : '';
                  address += company.city ? ' ' + company.city : '';

                  var item = $('<li data-id="'+ company.id +'"><span>' + company.name + '</span> <span class="option">' + address + '</span></li>');

                  list.append(item);

                  item.on('click', function() {
                     $('#company-name').prop('disabled', true);

                     $('#company-category').val(company.category);
                     $('#company-category').prop('disabled', true);
                     $('#company-category').selectric('refresh');

                     $('#company-registration-number').val(company.registration_number);
                     $('#company-registration-number').prop('disabled', true);

                     $('#company-address').val(company.address_1);
                     $('#company-address').prop('disabled', true);

                     $('#company-address-2').val(company.address_2);
                     $('#company-address-2').prop('disabled', true);

                     $('#company-phone').prop('disabled', true);

                     $('#company-zipcode').val(company.zipcode);
                     $('#company-zipcode').prop('disabled', true);

                     $('#company-city').val(company.city);
                     $('#company-city').prop('disabled', true);

                     $('#company-country-id').val(company.country_id);
                     $('#company-country-id').prop('disabled', true);
                     $('#company-country-id').trigger('change').selectric('refresh');

                     $('#company-region-id').val(company.region_id);
                     $('#company-region-id').prop('disabled', true);
                     $('#company-region-id').trigger('change').selectric('refresh');

                     setRequiredFields();
                  });
               });

               if( response.companies.length > 0 ) {
                  list.show();
               } else {
                  list.hide();
               }
            }
         });
      } else {
         list.hide();
         list.find('li').remove();
      }
   });

   // Reset company information
   $('#company-name-autocomplete').on('click', '.reset', function() {
      $('#company-name').prop('disabled', false);

      $('#company-category').prop('disabled', false);
      $('#company-category').selectric('refresh');

      $('#company-registration-number').val('');
      $('#company-registration-number').prop('disabled', false);

      $('#company-address').val('');
      $('#company-address').prop('disabled', false);

      $('#company-address-2').val('');
      $('#company-address-2').prop('disabled', false);

      $('#company-phone').val('');
      $('#company-phone').prop('disabled', false);

      $('#company-zipcode').val('');
      $('#company-zipcode').prop('disabled', false);

      $('#company-city').val('');
      $('#company-city').prop('disabled', false);

      $('#company-country-id').prop('disabled', false);
      $('#company-country-id').trigger('change').selectric('refresh');

      $('#company-region-id').val('');
      $('#company-region-id').prop('disabled', false);
      $('#company-region-id').trigger('change').selectric('refresh');
   });

   $('.previous-step').on('click', previousStep);


   /*
   |--------------------------------------------------------------------------
   | Checkout
   |--------------------------------------------------------------------------
   */

   function stripeResponseHandler(status, response) {
      var form = $('#register-form');

      if( response.error ) {
         $('#register-form input[type=submit]').prop('disabled', false).removeClass('disabled'); // Re-enable submission
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

   // Submit credit card information
   $('#register-form.subscription').on('submit', function(e) {
      e.preventDefault();

      var method = $('input[name=payment_method]:checked').val();

      if( method === 'credit_card' ) {
         Stripe.card.createToken({
            number: $('#cc-number').val(),
            cvc: $('#cc-cvc').val(),
            exp_month: $('#cc-exp-month').val(),
            exp_year: $('#cc-exp-year').val(),
            name: $('#cc-name').val()
         }, stripeResponseHandler);
      }
      else if( method === 'sepa' ) {
         Stripe.source.create({
            type: 'sepa_debit',
            sepa_debit: {
               iban: $('#sepa-iban').val(),
            },
            currency: 'eur',
            owner: {
               name: $('#sepa-name').val(),
            },
         }, stripeResponseHandler);
      }
   });

});
