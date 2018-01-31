<div class="row">
   <div class="col-6">
      <div class="form-group">
         <label for="user-title" class="required">Titre</label>
         <select id="user-title" name="title" required>
            <option value="M."{{ old('title', 'M.') === 'M.' ? ' selected' : '' }}>M.</option>
            <option value="Mme"{{ old('title', 'M.') === 'Mme' ? ' selected' : '' }}>Mme</option>
            <option value="Mlle"{{ old('title', 'M.') === 'Mlle' ? ' selected' : '' }}>Mlle</option>
         </select>
      </div>

      <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
         <label for="user-first-name" class="required">Prénom</label>
         <input id="user-first-name" type="text" name="first_name" value="{{ old('first_name') }}" />

         @if( $errors->has('first_name') )
            <p class="error">{{ $errors->first('first_name') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
         <label for="user-last-name" class="required">Nom</label>
         <input id="user-last-name" type="text" name="last_name" value="{{ old('last_name') }}" />

         @if( $errors->has('last_name') )
            <p class="error">{{ $errors->first('last_name') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
         <label for="user-job">Fonction</label>
         <input id="user-job" type="text" name="job" value="{{ old('job') }}" />

         @if( $errors->has('job') )
            <p class="error">{{ $errors->first('job') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
         <label for="user-birth-date">Date de naissance</label>
         <input id="user-birth-date" class="datepicker" type="text" name="birth_date" value="{{ old('birth_date') }}" />

         @if( $errors->has('birth_date') )
            <p class="error">{{ $errors->first('birth_date') }}</p>
         @endif
      </div>
   </div>
   <div class="col-6">
      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
         <label for="user-email" class="required">Adresse email</label>
         <input id="user-email" type="email" name="email" value="{{ old('email') }}" />

         @if( $errors->has('email') )
            <p class="error">{{ $errors->first('email') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('phone_mobile') ? ' has-error' : '' }}">
         <label for="user-phone-mobile">Téléphone mobile</label>
         <input id="user-phone-mobile" type="tel" name="phone_mobile" class="phone-number" value="{{ old('phone_mobile') }}" />

         @if( $errors->has('phone_mobile') )
            <p class="error">{{ $errors->first('phone_mobile') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('phone_fixed') ? ' has-error' : '' }}">
         <label for="user-phone-fixed">Téléphone fixe</label>
         <input id="user-phone-fixed" type="tel" name="phone_fixed" class="phone-number" value="{{ old('phone_fixed') }}" />

         @if( $errors->has('phone_fixed') )
            <p class="error">{{ $errors->first('phone_fixed') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('linkedin_url') ? ' has-error' : '' }}">
         <label for="user-linkedin-url">LinkedIn</label>
         <input id="user-linkedin-url" type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" />

         @if( $errors->has('linkedin_url') )
            <p class="error">{{ $errors->first('linkedin_url') }}</p>
         @endif
      </div>

      <div class="form-group{{ $errors->has('viadeo_url') ? ' has-error' : '' }}">
         <label for="user-viadeo-url">Viadeo</label>
         <input id="user-viadeo-url" type="url" name="viadeo_url" value="{{ old('viadeo_url') }}" />

         @if( $errors->has('viadeo_url') )
            <p class="error">{{ $errors->first('viadeo_url') }}</p>
         @endif
      </div>
   </div>
</div>
