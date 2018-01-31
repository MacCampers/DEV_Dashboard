@extends('back.layout.master')

@section('title', 'Sociétés > '. $company->name)

@section('js')
   <script type="text/javascript" src="{{ asset('/js/back/company.js') }}"></script>
@endsection

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Sociétés / {{ $company->name }}</h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif

      @if( count($errors) > 0 )
         @include('back.partials.error_message')
      @endif
   </div>

   @if( Auth::guard('admin')->user()->role !== 'cdd' )
      <a class="button-icon button-topright" href="/admin/companies"><span class="icon-arrow-left"></span></a>
   @endif

   <form method="post" action="/admin/companies/{{ $company->id }}">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="col-12">
         <h2>Informations</h2>

         <section>
            <div class="col-6">
               <div class="form-group{{ $errors->has('company.name') ? ' has-error' : '' }}">
                  <label for="company-name" class="required">Nom</label>
                  <input id="company-name" type="text" name="company[name]" value="{{ old('company.name', $company->name) }}" required />

                  @if( $errors->has('company.name') )
                     <p class="error">{{ $errors->first('company.name') }}</p>
                  @endif
               </div>

               <div class="form-group">
                  <label for="company-type" class="required">Type d'établissement</label>
                  <select id="company-type" name="company[type]" class="company-type-selector" required>
                     <option value="company"{{ old('company.type', $company->type) === 'company' ? ' selected' : '' }}>Société</option>
                     <option value="counsel"{{ old('company.type', $company->type) === 'counsel' ? ' selected' : '' }}>Société de conseil</option>
                     <option value="investment"{{ old('company.type', $company->type) === 'investment' ? ' selected' : '' }}>Société d'investissement</option>
                  </select>
               </div>

               <div class="form-group">
                  <label for="company-category">Catégorie</label>
                  <select id="company-category" name="company[category]" class="company-category-selector">
                     <option value="">Sélectionnez une catégorie</option>

                     <option value="accounting" data-type="counsel"{{ old('company.category', $company->category) === 'accounting' ? ' selected' : '' }}>Cabinet d'expertise comptable</option>
                     <option value="law" data-type="counsel"{{ old('company.category', $company->category) === 'law' ? ' selected' : '' }}>Cabinet d'avocats</option>
                     <option value="fundraiser" data-type="counsel"{{ old('company.category', $company->category) === 'fundraiser' ? ' selected' : '' }}>Conseil en levée de fonds</option>
                     <option value="property_management" data-type="counsel"{{ old('company.category', $company->category) === 'property_management' ? ' selected' : '' }}>Conseil en gestion de patrimoine</option>
                     <option value="strategy_counsel" data-type="counsel"{{ old('company.category', $company->category) === 'strategy_counsel' ? ' selected' : '' }}>Conseil en stratégie</option>
                     <option value="other" data-type="counsel"{{ old('company.category', $company->category) === 'other' ? ' selected' : '' }}>Autre</option>

                     <option value="investment_fund" data-type="investment"{{ old('company.category', $company->category) === 'investment_fund' ? ' selected' : '' }}>Fonds d'investissement</option>
                     <option value="business_angel" data-type="investment"{{ old('company.category', $company->category) === 'business_angel' ? ' selected' : '' }}>Business Angel</option>
                     <option value="business_angels_assoc" data-type="investment"{{ old('company.category', $company->category) === 'business_angels_assoc' ? ' selected' : '' }}>Association de Business Angels</option>
                     <option value="bank" data-type="investment"{{ old('company.category', $company->category) === 'bank' ? ' selected' : '' }}>Banque</option>
                     <option value="industrial" data-type="investment"{{ old('company.category', $company->category) === 'industrial' ? ' selected' : '' }}>Industriel</option>
                     <option value="other" data-type="investment"{{ old('company.category', $company->category) === 'other' ? ' selected' : '' }}>Autre</option>
                  </select>
               </div>

               <div class="form-group{{ $errors->has('company.registration_number') ? ' has-error' : '' }}">
                  <label for="company-registration-number">Numéro d'identification</label>
                  <input id="company-registration-number" type="text" name="company[registration_number]" value="{{ old('company.registration_number', $company->registration_number) }}" />

                  @if( $errors->has('company.registration_number') )
                     <p class="error">{{ $errors->first('company.registration_number') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('company.email') ? ' has-error' : '' }}">
                  <label for="company-email">Adresse email</label>
                  <input id="company-email" type="email" name="company[email]" value="{{ old('company.email', $company->email) }}" />

                  @if( $errors->has('company.email') )
                     <p class="error">{{ $errors->first('company.email') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('company.phone') ? ' has-error' : '' }}">
                  <label for="company-phone">Téléphone</label>
                  <input id="company-phone" type="tel" name="company[phone]" class="phone-number" value="{{ old('company.phone', $company->phone) }}" />

                  @if( $errors->has('company.phone') )
                     <p class="error">{{ $errors->first('company.phone') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('company.website') ? ' has-error' : '' }}">
                  <label for="company-website">Site web</label>
                  <input id="company-website" type="text" name="company[website]" value="{{ old('company.website', $company->website) }}" />

                  @if( $errors->has('company.website') )
                     <p class="error">{{ $errors->first('company.website') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('company.deals_per_year') ? ' has-error' : '' }}">
                  <label for="company-deals-per-year">Nombre de deals par an</label>
                  <input id="company-deals-per-year" class="small" type="number" name="company[deals_per_year]" value="{{ old('company.deals_per_year', $company->deals_per_year) }}" />

                  @if( $errors->has('company.deals_per_year') )
                     <p class="error">{{ $errors->first('company.deals_per_year') }}</p>
                  @endif
               </div>
            </div>

            <div class="col-6">
               <div class="form-group">
                  <label for="company-address-1">Adresse (ligne 1)</label>
                  <input id="company-address-1" type="text" name="company[address_1]" value="{{ old('company.address_1', $company->address_1) }}" />
               </div>

               <div class="form-group">
                  <label for="company-address-2">Adresse (ligne 2)</label>
                  <input id="company-address-2" type="text" name="company[address_2]" value="{{ old('company.address_2', $company->address_2) }}" />
               </div>

               <div class="form-group">
                  <div class="zipcode{{ $errors->has('company.zipcode') ? ' has-error' : '' }}">
                     <label for="company-zipcode">Code postal</label>
                     <input id="company-zipcode" type="text" name="company[zipcode]" value="{{ old('company.zipcode', $company->zipcode) }}" />

                     @if( $errors->has('company.zipcode') )
                        <p class="error">{{ $errors->first('company.zipcode') }}</p>
                     @endif
                  </div>

                  <div class="city">
                     <label for="company-city">Ville</label>
                     <input id="company-city" type="text" name="company[city]" value="{{ old('company.city', $company->city) }}" />
                  </div>
               </div>

               <div class="form-group">
                  <label for="company-country">Pays</label>
                  <select id="company-country" name="company[country_id]" class="country-selector">
                     <option value="">Sélectionnez un pays</option>

                     @foreach( $zones['country'] as $country )
                        <option value="{{ $country->id }}"{{ old('company.country_id', $company->country_id) == $country->id ? ' selected' : '' }}>{{ $country->name }}</option>
                     @endforeach
                  </select>
               </div>

               <div class="form-group">
                  <label for="company-region">Région</label>
                  <select id="company-region" name="company[region_id]" class="region-selector">
                     <option value="">Sélectionnez une région</option>

                     @foreach( $zones['region'] as $region )
                        <option value="{{ $region->id }}" data-country="{{ $region->parent }}"{{ old('company.region_id', $company->region_id) == $region->id ? ' selected' : '' }}>{{ $region->name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>

            <div class="col-12">
               <div class="form-group">
                  <input type="submit" value="Enregistrer les modifications" />
               </div>
            </div>
         </section>
      </div>
   </form>

   <div class="col-12">
      <h2>Signataire</h2>
   </div>
   <div class="row">
      <div class="col-4">
         <section>
            <div class="col-12">
               @if( $company->representative )
                  <div class="form-group">
                     <strong>{{ $company->representative->title }} {{ $company->representative->full_name }}</strong><br />
                     <a href="/admin/users/{{ $company->representative->id }}/edit" target="_blank">Voir la fiche du contact</a>
                  </div>

                  <div class="form-group align-right">
                     <span id="change-representative" class="edit-link" data-company="{{ $company->id }}">Modifier</span>
                  </div>
               @else
                  <div class="form-group">Cette société n'a pas de mandataire.</div>
               @endif
            </div>
         </section>
      </div>
   </div>

   <div class="col-12">
      <div class="title">
         <h2>Contacts</h2>
      </div>
   </div>

   <div class="row section-multiple">
      @php
      $users = $company->users()->where('company_role', '<>', 'representative')->get();
      @endphp

      @if( count($users) > 0 )
         @foreach( $users as $user )
            <div class="col-4">
               <section>
                  <div class="col-12">
                     <div class="form-group">
                        <strong>{{ $user->title }} {{ $user->full_name }}</strong><br />
                        @lang('fields.company_roles.'.$user->company_role)<br />
                        <a href="/admin/users/{{ $user->id }}/edit" target="_blank">Voir la fiche du contact</a>
                     </div>

                     <div class="form-group align-right">
                        <form method="post" action="/admin/companies/{{ $company->id }}/user/{{ $user->id }}">
                           {{ csrf_field() }}
                           {{ method_field('DELETE') }}
                        </form>

                        <span class="remove-company-user remove-link">Supprimer</span>
                     </div>
                  </div>
               </section>
            </div>
         @endforeach
      @else
         <div class="col-12">
            <section>
               <div class="col-12">
                  <div class="form-group">Cette société n'a aucun contact associé.</div>
               </div>
            </section>
         </div>
      @endif

      <div class="col-12">
         <div id="new-user" class="button small" data-company="{{ $company->id }}">Ajouter un contact</div>
      </div>
   </div>

   @if( $company->type === 'investment' )
      <div class="col-12 section-multiple">
         <div class="title">
            <h2>Stratégies</h2>
         </div>

         @if( count($company->strategies) > 0 )
            @foreach( $company->strategies as $strategy )
               <section>
                  <div class="col-7">
                     <div class="form-group">
                        <h3>{{ $strategy->name }}</h3>

                        <table class="report">
                           <tr>
                              <th width="250">Zones d'implantation</th>
                              <td>
                                 @if( count($strategy->locations) > 0 )
                                    <ul>
                                       @foreach( $strategy->locations as $location )
                                          <li>{{ $location->name }}</li>
                                       @endforeach
                                    </ul>
                                 @else
                                    Aucune
                                 @endif
                              </td>
                           </tr>
                           <tr>
                              <th width="250">Zones d'investissement</th>
                              <td>
                                 @if( count($strategy->investment_zones) > 0 )
                                    <ul>
                                       @foreach( $strategy->investment_zones as $investmentZone )
                                          <li>{{ $investmentZone->name }}</li>
                                       @endforeach
                                    </ul>
                                 @else
                                    Indifférent
                                 @endif
                              </td>
                           </tr>

                           <tr>
                              <th width="250">Secteurs d'activité officiels</th>
                              <td>
                                 @if( count($strategy->official_activity_areas) > 0 )
                                    <ul>
                                       @foreach( $strategy->official_activity_areas as $area )
                                          <li>{{ $area->name }}</li>
                                       @endforeach
                                    </ul>
                                 @else
                                    Pas de focus sectoriel
                                 @endif
                              </td>
                           </tr>

                           <tr>
                              <th width="250">Secteurs d'activité privilégiés</th>
                              <td>
                                 @if( count($strategy->privileged_activity_areas) > 0 )
                                    <ul>
                                       @foreach( $strategy->privileged_activity_areas as $area )
                                          <li>{{ $area->name }}</li>
                                       @endforeach
                                    </ul>
                                 @else
                                    Pas de focus sectoriel
                                 @endif
                              </td>
                           </tr>

                           <tr>
                              <th width="250">Types d'opérations</th>
                              <td>
                                 @if( count($strategy->development_stages) > 0 )
                                    <ul>
                                       @foreach( $strategy->development_stages as $stage )
                                          <li>{{ $stage->name }}</li>
                                       @endforeach
                                    </ul>
                                 @else
                                    Indifférent
                                 @endif
                              </td>
                           </tr>

                           <tr>
                              <th width="250">Ticket</th>
                              @if( $strategy->amount_max === null )
                                 @if( $strategy->amount_min === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->amount_min*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->amount_min*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->amount_max*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>
                           <tr>
                              <th width="250">Chiffre d'affaires</th>
                              @if( $strategy->revenues_max === null )
                                 @if( $strategy->revenues_min === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->revenues_min*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->revenues_min*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->revenues_max*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>
                           <tr>
                              <th width="250">Valorisation</th>
                              @if( $strategy->value_max === null )
                                 @if( $strategy->value_min === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->value_min*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->value_min*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->value_max*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>

                           <tr>
                              <th width="250">Ticket <span class="blue">Equiteasy</span></th>
                              @if( $strategy->amount_max_equiteasy === null )
                                 @if( $strategy->amount_min_equiteasy === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->amount_min_equiteasy*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->amount_min_equiteasy*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->amount_max_equiteasy*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>
                           <tr>
                              <th width="250">Chiffre d'affaires <span class="blue">Equiteasy</span></th>
                              @if( $strategy->revenues_max_equiteasy === null )
                                 @if( $strategy->revenues_min_equiteasy === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->revenues_min_equiteasy*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->revenues_min_equiteasy*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->revenues_max_equiteasy*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>
                           <tr>
                              <th width="250">Valorisation <span class="blue">Equiteasy</span></th>
                              @if( $strategy->value_max_equiteasy === null )
                                 @if( $strategy->value_min_equiteasy === null )
                                    <td>N/A</td>
                                 @else
                                    <td>À partir de <strong>{{ number_format($strategy->value_min_equiteasy*1000, 0, ',', ' ') }} €</td>
                                 @endif
                              @else
                                 <td>Entre <strong>{{ number_format($strategy->value_min_equiteasy*1000, 0, ',', ' ') }} €</strong> et <strong>{{ number_format($strategy->value_max_equiteasy*1000, 0, ',', ' ') }} €</strong></td>
                              @endif
                           </tr>

                           <tr>
                              <th width="250">Majoritaire exclusivement</th>
                              <td>{{ $strategy->majority === null ? 'Indifférent' : ($strategy->majority ? 'Oui' : 'Non') }}</td>
                           </tr>
                           <tr>
                              <th width="250">Minoritaire exclusivement</th>
                              <td>{{ $strategy->minority === null ? 'Indifférent' : ($strategy->minority ? 'Oui' : 'Non') }}</td>
                           </tr>
                           <tr>
                              <th width="250">Rentable exclusivement</th>
                              <td>{{ $strategy->profitable === null ? 'Indifférent' : ($strategy->profitable ? 'Oui' : 'Non') }}</td>
                           </tr>

                           <tr>
                              <th width="250">Type de société</th>
                              <td>@lang('fields.company_sizes.'.$strategy->company_size)</td>
                           </tr>

                           <tr>
                              <th width="250">MBI</th>
                              <td>{{ $strategy->mbi === null ? 'Indifférent' : ($strategy->mbi ? 'Oui' : 'Non') }}</td>
                           </tr>

                           <tr>
                              <th width="250">RSE exclusivement</th>
                              <td>{{ $strategy->social_impact === null ? 'Indifférent' : ($strategy->social_impact ? 'Oui' : 'Non') }}</td>
                           </tr>
                        </table>
                     </div>

                     @if( $strategy->notes !== null )
                        <div class="form-group notes">
                           <p><strong>Notes :</strong></p>
                           <p>{{ $strategy->notes }}</p>
                        </div>
                     @endif
                  </div>

                  <div class="col-5">
                     <div class="form-group">
                        <h3>Contacts associés</h3>

                        @if( count($company->users) > 0 )
                           <form method="post" action="/admin/strategies/{{ $strategy->id }}/attach_users">
                              {{ csrf_field() }}

                              @php
                              $users = $strategy->users->pluck('id')->toArray();
                              @endphp

                              <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                                 <table class="report">
                                    @foreach( $company->users as $user )
                                       <tr>
                                          <td><label for="strategy-{{ $strategy->id }}-user-{{ $user->id }}">{{ $user->full_name }}</label></td>
                                          <td><input type="checkbox" id="strategy-{{ $strategy->id }}-user-{{ $user->id }}" name="users[]" value="{{ $user->id }}"{{ in_array($user->id, $users) ? ' checked' : '' }} /></td>
                                       </tr>
                                    @endforeach
                                 </table>

                                 @if( $errors->has('users') )
                                    <p class="error">Vous devez associer au moins un contact à chaque stratégie.</p>
                                 @endif
                              </div>

                              <input type="submit" value="Enregistrer" />
                           </form>
                        @else
                           <em>Aucun contact associé à cette société</em>
                        @endif
                     </div>
                  </div>

                  <div class="col-12">
                     <div class="form-group align-right">
                        <form method="post" action="/admin/strategies/{{ $strategy->id }}">
                           {{ csrf_field() }}
                           {{ method_field('DELETE') }}
                        </form>

                        <a href="/admin/strategies/{{ $strategy->id }}/duplicate">Dupliquer</a> - <span class="edit-strategy edit-link" data-id="{{ $strategy->id }}">Modifier</span> - <span class="remove-strategy remove-link">Supprimer</span>
                     </div>
                  </div>
               </section>
            @endforeach
         @else
            <section>
               <div class="col-12">
                  <div class="form-group">Cette société n'a aucune stratégie d'investissement.</div>
               </div>
            </section>
         @endif

         <div id="new-strategy" class="button small" data-company="{{ $company->id }}">Ajouter une stratégie</div>
      </div>
   @endif

   <div class="col-12 form-footer align-right">
      <form id="delete-company" method="post" action="/admin/companies/{{ $company->id }}">
         {{ csrf_field() }}
         {{ method_field('DELETE') }}

         <button type="button" class="red">Supprimer cette société</button>
      </form>
   </div>
@endsection
