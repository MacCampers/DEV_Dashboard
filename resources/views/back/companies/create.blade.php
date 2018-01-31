@extends('back.layout.master')

@section('title', 'Sociétés > Nouvelle société')

@section('js')
   <script type="text/javascript" src="{{ asset('/js/back/company.js') }}"></script>
@endsection

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Sociétés / Nouvelle société</h1>
      </div>

      @if( count($errors) > 0 )
         @include('back.partials.error_message')
      @endif
   </div>

   @if( Auth::guard('admin')->user()->role !== 'cdd' )
      <a class="button-icon button-topright" href="/admin/companies"><span class="icon-arrow-left"></span></a>
   @endif

   <form id="create-company" method="post" action="/admin/companies">
      {{ csrf_field() }}

      <div class="row">
         <div class="col-12">
            <h2>Informations</h2>

            <section>
               <div class="col-6">
                  <div class="form-group{{ $errors->has('company.name') ? ' has-error' : '' }}">
                     <label for="company-name" class="required">Nom</label>
                     <input id="company-name" type="text" name="company[name]" value="{{ old('company.name') }}" required />

                     @if( $errors->has('company.name') )
                        <p class="error">{{ $errors->first('company.name') }}</p>
                     @endif
                  </div>

                  <div class="form-group">
                     <label for="company-type" class="required">Type d'établissement</label>
                     <select id="company-type" name="company[type]" class="company-type-selector" required>
                        <option value="company"{{ old('company.type', 'investment') === 'company' ? ' selected' : '' }}>Société</option>
                        <option value="counsel"{{ old('company.type', 'investment') === 'counsel' ? ' selected' : '' }}>Société de conseil</option>
                        <option value="investment"{{ old('company.type', 'investment') === 'investment' ? ' selected' : '' }}>Société d'investissement</option>
                     </select>
                  </div>

                  <div class="form-group">
                     <label for="company-category">Catégorie</label>
                     <select id="company-category" name="company[category]" class="company-category-selector">
                        <option value="">Sélectionnez une catégorie</option>

                        <option value="accounting" data-type="counsel"{{ old('company.category') === 'accounting' ? ' selected' : '' }}>Cabinet d'expertise comptable</option>
                        <option value="law" data-type="counsel"{{ old('company.category') === 'law' ? ' selected' : '' }}>Cabinet d'avocats</option>
                        <option value="fundraiser" data-type="counsel"{{ old('company.category') === 'fundraiser' ? ' selected' : '' }}>Conseil en levée de fonds</option>
                        <option value="property_management" data-type="counsel"{{ old('company.category') === 'property_management' ? ' selected' : '' }}>Conseil en gestion de patrimoine</option>
                        <option value="strategy_counsel" data-type="counsel"{{ old('company.category') === 'strategy_counsel' ? ' selected' : '' }}>Conseil en stratégie</option>
                        <option value="other" data-type="counsel"{{ old('company.category') === 'other' ? ' selected' : '' }}>Autre</option>

                        <option value="investment_fund" data-type="investment"{{ old('company.category') === 'investment_fund' ? ' selected' : '' }}>Fonds d'investissement</option>
                        <option value="business_angel" data-type="investment"{{ old('company.category') === 'business_angel' ? ' selected' : '' }}>Business Angel</option>
                        <option value="business_angels_assoc" data-type="investment"{{ old('company.category') === 'business_angels_assoc' ? ' selected' : '' }}>Association de Business Angels</option>
                        <option value="bank" data-type="investment"{{ old('company.category') === 'bank' ? ' selected' : '' }}>Banque</option>
                        <option value="industrial" data-type="investment"{{ old('company.category') === 'industrial' ? ' selected' : '' }}>Industriel</option>
                        <option value="other" data-type="investment"{{ old('company.category') === 'other' ? ' selected' : '' }}>Autre</option>
                     </select>
                  </div>

                  <div class="form-group{{ $errors->has('company.registration_number') ? ' has-error' : '' }}">
                     <label for="company-registration-number">Numéro d'identification</label>
                     <input id="company-registration-number" type="text" name="company[registration_number]" value="{{ old('company.registration_number') }}" />

                     @if( $errors->has('company.registration_number') )
                        <p class="error">{{ $errors->first('company.registration_number') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('company.email') ? ' has-error' : '' }}">
                     <label for="company-email">Adresse email</label>
                     <input id="company-email" type="email" name="company[email]" value="{{ old('company.email') }}" />

                     @if( $errors->has('company.email') )
                        <p class="error">{{ $errors->first('company.email') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('company.phone') ? ' has-error' : '' }}">
                     <label for="company-phone">Téléphone</label>
                     <input id="company-phone" type="tel" name="company[phone]" class="phone-number" value="{{ old('company.phone') }}" />

                     @if( $errors->has('company.phone') )
                        <p class="error">{{ $errors->first('company.phone') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('company.website') ? ' has-error' : '' }}">
                     <label for="company-website">Site web</label>
                     <input id="company-website" type="text" name="company[website]" value="{{ old('company.website') }}" />

                     @if( $errors->has('company.website') )
                        <p class="error">{{ $errors->first('company.website') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('company.deals_per_year') ? ' has-error' : '' }}">
                     <label for="company-deals-per-year">Nombre de deals par an</label>
                     <input id="company-deals-per-year" class="small" type="number" min="0" name="company[deals_per_year]" value="{{ old('company.deals_per_year') }}" />

                     @if( $errors->has('company.deals_per_year') )
                        <p class="error">{{ $errors->first('company.deals_per_year') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-6">
                  <div class="form-group">
                     <label for="company-address-1">Adresse (ligne 1)</label>
                     <input id="company-address-1" type="text" name="company[address_1]" value="{{ old('company.address_1') }}" />
                  </div>

                  <div class="form-group">
                     <label for="company-address-2">Adresse (ligne 2)</label>
                     <input id="company-address-2" type="text" name="company[address_2]" value="{{ old('company.address_2') }}" />
                  </div>

                  <div class="form-group">
                     <div class="zipcode{{ $errors->has('company.zipcode') ? ' has-error' : '' }}">
                        <label for="company-zipcode">Code postal</label>
                        <input id="company-zipcode" type="text" name="company[zipcode]" value="{{ old('company.zipcode') }}" />

                        @if( $errors->has('company.zipcode') )
                           <p class="error">{{ $errors->first('company.zipcode') }}</p>
                        @endif
                     </div>

                     <div class="city">
                        <label for="company-city">Ville</label>
                        <input id="company-city" type="text" name="company[city]" value="{{ old('company.city') }}" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="company-country">Pays</label>
                     <select id="company-country" name="company[country_id]" class="country-selector">
                        <option value="">Sélectionnez un pays</option>

                        @foreach( $zones['country'] as $country )
                           <option value="{{ $country->id }}"{{ old('company.country_id') == $country->id ? ' selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="form-group">
                     <label for="company-region">Région</label>
                     <select id="company-region" name="company[region_id]" class="region-selector"{{ old('company.region') ?: ' disabled' }}>
                        <option value="">Sélectionnez une région</option>

                        @foreach( $zones['region'] as $region )
                           <option value="{{ $region->id }}" data-country="{{ $region->parent }}"{{ old('company.region_id') == $region->id ? ' selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </section>
         </div>

         <div class="col-12">
            <h2>Signataire</h2>

            <section>
               <div class="col-6">
                  <div class="form-group">
                     <label for="representative-title" class="required">Titre</label>
                     <select id="representative-title" name="representative[title]" required>
                        <option value="M."{{ old('representative.title', 'M.') === 'M.' ? ' selected' : '' }}>M.</option>
                        <option value="Mme"{{ old('representative.title', 'M.') === 'Mme' ? ' selected' : '' }}>Mme</option>
                        <option value="Mlle"{{ old('representative.title', 'M.') === 'Mlle' ? ' selected' : '' }}>Mlle</option>
                     </select>
                  </div>

                  <div class="form-group{{ $errors->has('representative.first_name') ? ' has-error' : '' }}">
                     <label for="representative-first-name" class="required">Prénom</label>
                     <input id="representative-first-name" type="text" name="representative[first_name]" value="{{ old('representative.first_name') }}" />

                     @if( $errors->has('representative.first_name') )
                        <p class="error">{{ $errors->first('representative.first_name') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.last_name') ? ' has-error' : '' }}">
                     <label for="representative-last-name" class="required">Nom</label>
                     <input id="representative-last-name" type="text" name="representative[last_name]" value="{{ old('representative.last_name') }}" />

                     @if( $errors->has('representative.last_name') )
                        <p class="error">{{ $errors->first('representative.last_name') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.job') ? ' has-error' : '' }}">
                     <label for="representative-job">Fonction</label>
                     <input id="representative-job" type="text" name="representative[job]" value="{{ old('representative.job') }}" />

                     @if( $errors->has('representative.job') )
                        <p class="error">{{ $errors->first('representative.job') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.birth_date') ? ' has-error' : '' }}">
                     <label for="representative-birth-date">Date de naissance</label>
                     <input id="representative-birth-date" class="datepicker" type="text" name="representative[birth_date]" value="{{ old('representative.birth_date') }}" />

                     @if( $errors->has('representative.birth_date') )
                        <p class="error">{{ $errors->first('representative.birth_date') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-6">
                  <div class="form-group{{ $errors->has('representative.email') ? ' has-error' : '' }}">
                     <label for="representative-email" class="required">Adresse email</label>
                     <input id="representative-email" type="email" name="representative[email]" value="{{ old('representative.email') }}" />

                     @if( $errors->has('representative.email') )
                        <p class="error">{{ $errors->first('representative.email') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.phone_mobile') ? ' has-error' : '' }}">
                     <label for="representative-phone-mobile">Téléphone mobile</label>
                     <input id="representative-phone-mobile" type="tel" name="representative[phone_mobile]" class="phone-number" value="{{ old('representative.phone_mobile') }}" />

                     @if( $errors->has('representative.phone_mobile') )
                        <p class="error">{{ $errors->first('representative.phone_mobile') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.phone_fixed') ? ' has-error' : '' }}">
                     <label for="representative-phone-fixed">Téléphone fixe</label>
                     <input id="representative-phone-fixed" type="tel" name="representative[phone_fixed]" class="phone-number" value="{{ old('representative.phone_fixed') }}" />

                     @if( $errors->has('representative.phone_fixed') )
                        <p class="error">{{ $errors->first('representative.phone_fixed') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.linkedin_url') ? ' has-error' : '' }}">
                     <label for="representative-linkedin-url">LinkedIn</label>
                     <input id="representative-linkedin-url" type="url" name="representative[linkedin_url]" value="{{ old('representative.linkedin_url') }}" />

                     @if( $errors->has('representative.linkedin_url') )
                        <p class="error">{{ $errors->first('representative.linkedin_url') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('representative.viadeo_url') ? ' has-error' : '' }}">
                     <label for="representative-viadeo-url">Viadeo</label>
                     <input id="representative-viadeo-url" type="url" name="representative[viadeo_url]" value="{{ old('representative.viadeo_url') }}" />

                     @if( $errors->has('representative.viadeo_url') )
                        <p class="error">{{ $errors->first('representative.viadeo_url') }}</p>
                     @endif
                  </div>
               </div>
            </section>
         </div>

         <div id="section-strategies" class="col-12 section-multiple">
            <div class="title">
               <h2>Stratégies</h2>
            </div>

            <div id="strategies">
               <section class="empty">
                  <div class="col-12">
                     <div class="form-group">Vous n'avez pas encore ajouté de stratégie.</p></div>
                  </div>
               </section>
            </div>

            <div id="add-strategy" class="button small">Ajouter une stratégie</div>
         </div>

         <div class="col-12 form-footer">
            <input type="submit" value="Enregistrer" />
         </div>
      </div>
   </form>
@endsection
