@extends('back.layout.master')

@section('title', 'Contacts > '. $user->full_name)

@section('js')
   <script type="text/javascript" src="{{ asset('/js/back/user.js') }}"></script>
@endsection

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Contacts / {{ $user->full_name }} <span class="label">@lang('fields.account_types.'.$user->type, [], 'fr')</span></h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif

      @if( count($errors) > 0 )
         @include('back.partials.error_message')
      @endif
   </div>

   <a class="button-icon button-topright" href="/admin/users"><span class="icon-arrow-left"></span></a>

   <form method="post" action="/admin/users/{{ $user->id }}">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="row">
         <div class="col-12">
            <h2>Informations personnelles</h2>

            <section>
               <div class="col-6">
                  <div class="form-group">
                     <label for="user-title" class="required">Titre</label>
                     <select id="user-title" name="title" required>
                        <option value="M."{{ old('title', $user->title) === 'M.' ? ' selected' : '' }}>M.</option>
                        <option value="Mme"{{ old('title', $user->title) === 'Mme' ? ' selected' : '' }}>Mme</option>
                        <option value="Mlle"{{ old('title', $user->title) === 'Mlle' ? ' selected' : '' }}>Mlle</option>
                     </select>
                  </div>

                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                     <label for="user-first-name" class="required">Prénom</label>
                     <input id="user-first-name" type="text" name="first_name" value="{{ old('firstname', $user->first_name) }}" required />

                     @if( $errors->has('first_name') )
                        <p class="error">{{ $errors->first('first_name') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                     <label for="user-last-name" class="required">Nom</label>
                     <input id="user-last-name" type="text" name="last_name" value="{{ old('lastname', $user->last_name) }}" required />

                     @if( $errors->has('last_name') )
                        <p class="error">{{ $errors->first('last_name') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                     <label for="user-job">Fonction</label>
                     <input id="user-job" type="text" name="job" value="{{ old('job', $user->job) }}" />

                     @if( $errors->has('job') )
                        <p class="error">{{ $errors->first('job') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                     <label for="user-birth-date">Date de naissance</label>
                     <input id="user-birth-date" class="datepicker" type="text" name="birth_date" value="{{ old('birth_date', $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '') }}" />

                     @if( $errors->has('birth_date') )
                        <p class="error">{{ $errors->first('birth_date') }}</p>
                     @endif
                  </div>
               </div>

               <div class="col-6">
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                     <label for="user-email" class="required">Adresse email</label>
                     <input id="user-email" type="email" name="email" value="{{ old('email', $user->email) }}" required />

                     @if( $errors->has('email') )
                        <p class="error">{{ $errors->first('email') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('phone_mobile') ? ' has-error' : '' }}">
                     <label for="user-phone-mobile">Téléphone mobile</label>
                     <input id="user-phone-mobile" type="tel" name="phone_mobile" class="phone-number" value="{{ old('phone_mobile', $user->phone_mobile) }}" />

                     @if( $errors->has('phone_mobile') )
                        <p class="error">{{ $errors->first('phone_mobile') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('phone_fixed') ? ' has-error' : '' }}">
                     <label for="user-phone-fixed">Téléphone fixe</label>
                     <input id="user-phone-fixed" type="tel" name="phone_fixed" class="phone-number" value="{{ old('phone_fixed', $user->phone_fixed) }}" />

                     @if( $errors->has('phone_fixed') )
                        <p class="error">{{ $errors->first('phone_fixed') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('linkedin_url') ? ' has-error' : '' }}">
                     <label for="user-linkedin-url">LinkedIn</label>
                     <input id="user-linkedin-url" type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" />

                     @if( $errors->has('linkedin_url') )
                        <p class="error">{{ $errors->first('linkedin_url') }}</p>
                     @endif
                  </div>

                  <div class="form-group{{ $errors->has('viadeo_url') ? ' has-error' : '' }}">
                     <label for="user-viadeo-url">Viadeo</label>
                     <input id="user-viadeo-url" type="url" name="viadeo_url" value="{{ old('viadeo_url', $user->viadeo_url) }}" />

                     @if( $errors->has('viadeo_url') )
                        <p class="error">{{ $errors->first('viadeo_url') }}</p>
                     @endif
                  </div>
               </div>

               @if( $user->source )
                  <div class="col-12">
                     <div class="form-group">
                        <label>Comment cet utilisateur a connu Equiteasy :</label>
                        <p>@lang('fields.sources.' . $user->source, [], 'fr')</p>
                     </div>
                  </div>
               @endif

               <div class="col-12">
                  <div class="form-group">
                     <input type="submit" value="Enregistrer les modifications" />
                  </div>
               </div>
            </section>
         </div>
      </form>

      @if( $subscription )
         <div class="col-12">
            <h2>Abonnement</h2>

            <section>
               <div class="col-12">
                  <div class="form-group">
                     <strong>@lang('fields.subscription_plans.'. $subscription->stripe_plan, [], 'fr')</strong>
                     @if( $subscription->ends_at )
                        @if( $subscription->onGracePeriod() )
                           <p>Prend fin le <strong>{{ date('d/m/Y', strtotime($subscription->ends_at)) }}</strong></p>
                        @else
                           <p>Désabonné depuis le <strong>{{ date('d/m/Y', strtotime($subscription->ends_at)) }}</strong></p>
                        @endif
                     @endif
                  </div>

                  @if( $user->subscribed($user->type) )
                     <div class="form-group">
                        <form id="cancel-subscription" method="post" action="/admin/users/{{ $user->id }}/cancel_subscription">
                           {{ csrf_field() }}

                           <button type="button" class="red">Arrêter l'abonnement</button>
                        </form>
                     </div>
                  @endif
            </div>
            </section>
         </div>

         <div class="col-12">
            <h2>Factures</h2>

            <table class="data">
               <thead>
                  <tr>
                     <th><span>Numéro</span></th>
                     <th><span>Date</span></th>
                     <th><span>Montant</span></th>
                     <th width="60"></th>
                  </tr>
               </thead>
               <tbody>
                  @if( $user->invoices->count() > 0 )
                     @foreach( $user->invoices as $invoice )
                        <tr>
                           <td>{{ $invoice->id }}</td>
                           <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                           <td>{{ number_format($invoice->amount, 2, ',', ' ') }} €</td>
                           <td class="align-right">
                              <a href="/admin/invoices/{{ $invoice->id }}/download" target="_blank"><span class="icon-download"></span></a>
                           </td>
                        </tr>
                     @endforeach
                  @else
                     <tr>
                        <td colspan="4" class="align-center">Aucune facture</td>
                     </tr>
                  @endif
               </tbody>
            </table>
         </div>
      @endif

      <div class="col-12">
         <h2>Société</h2>

         <section>
            <div class="col-12">
               @if( $user->company )
                  <div class="form-group">{{ $user->full_name }} est {{ mb_strtolower(trans('fields.company_roles.'.$user->company_role, [], 'fr')) }} de la société <strong>{{ $user->company->name }}</strong></div>
               @else
                  <div class="form-group">Cet utilisateur n'est associé à aucune société.</div>
               @endif
            </div>
         </section>
      </div>
   </div>

   <div class="col-12 form-footer align-right">
      <form id="delete-user" method="post" action="/admin/users/{{ $user->id }}">
         {{ csrf_field() }}
         {{ method_field('DELETE') }}

         <button type="button" class="red">Supprimer ce contact</button>
      </form>
   </div>
@endsection
