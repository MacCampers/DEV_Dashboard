@extends('back.layout.master')

@section('title', 'Projects > '. $project->code_name)

@section('js')
   <script type="text/javascript" src="{{ asset('/js/back/project.js') }}"></script>
@endsection

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Projets / {{ $project->code_name }}</h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif
   </div>

   <a class="button-icon button-topright" href="/admin/projects"><span class="icon-arrow-left"></span></a>

   <div class="col-12">
      <div class="form-group">
         <a href="/admin/projects/{{ $project->id }}/view/synthesis" class="button" target="_blank">Voir le projet</a>
      </div>

      <h2>Statut</h2>
      <section>
         <div class="col-12">
            @if( $project->status === 'pending' )
               <div class="form-group">
                  <p>Ce projet est en cours d'édition.</p>
               </div>
            @elseif( $project->status === 'awaiting_validation' )
               <div class="form-group">
                  <p>Ce projet est <strong>en attente de validation</strong>.</p>
               </div>

               <div class="form-group">
                  <a href="/admin/projects/{{ $project->id }}/run" class="button">Voir les matchs</a>
               </div>

               <div class="form-group">
                  <div id="validate-project" class="button blue">Valider</div>
                  <div id="decline-project" class="button red">Refuser</div>
               </div>
            @elseif( $project->status === 'confirmed' )
               <div class="form-group">
                  <p>Ce projet a été validé par Equiteasy.</p>
               </div>
            @elseif( $project->status === 'running' )
               <div class="form-group">
                  <p>Ce projet est en cours.</p>
               </div>
            @elseif( $project->status === 'canceled' )
               <div class="form-group">
                  <p>Ce projet a été annulé.</p>
               </div>
            @endif
         </div>
      </section>

      <h2>Licence</h2>
      <section>
         <div class="col-12">
            <div class="form-group">
               @if( $project->hasSignedLicence() )
                  <a href="/admin/documents/{{ $project->licence_id }}" class="button" download="{{ $project->licence->name }}">Télécharger le document</a>
               @else
                  <p>La licence pour ce projet n'a pas encore été signée.</p>
               @endif
            </div>
         </div>
      </section>
   </div>

   <div id="validate-project-popup" class="popup-container">
      <div class="popup">
         <div class="col-12">
            <h2>Valider le projet</h2>

            <span class="close-popup icon-close"></span>
         </div>

         <form method="post" action="/admin/projects/{{ $project->id }}/confirm">
            {{ csrf_field() }}

            <div class="col-12">
               <div class="form-group">
                  <strong>Attention</strong><br />Cette action est irréversible.
               </div>

               <input type="submit" class="blue" value="Accepter le projet" />
               <div class="button grey cancel">Annuler</div>
            </div>
         </form>
      </div>
   </div>

   <div id="decline-project-popup" class="popup-container">
      <div class="popup">
         <div class="col-12">
            <h2>Refuser le projet</h2>

            <span class="close-popup icon-close"></span>
         </div>

         <form method="post" action="/admin/projects/{{ $project->id }}/decline">
            {{ csrf_field() }}

            <div class="col-12">
               <div class="form-group">
                  <strong>Attention</strong><br />Cette action est irréversible.
               </div>

               <div class="form-group">
                  <label for="decline-comment">Commentaire</label>
                  <textarea id="decline-comment" name="comment"></textarea>
               </div>

               <input type="submit" class="red" value="Refuser le projet" />
               <div class="button grey cancel">Annuler</div>
            </div>
         </form>
      </div>
   </div>

   <div id="cancel-project-popup" class="popup-container">
      <div class="popup">
         <div class="col-12">
            <h2>Annuler le projet</h2>

            <span class="close-popup icon-close"></span>
         </div>

         <form method="post" action="/admin/projects/{{ $project->id }}/cancel">
            {{ csrf_field() }}

            <div class="col-12">
               <div class="form-group">
                  <strong>Attention</strong><br />Cette sentence est irrévocable.
               </div>

               <div class="form-group">
                  <img src="{{ asset('img/denis.jpg') }}" alt="Denis" />
               </div>

               <div class="form-group">
                  <label for="cancel-comment">Commentaire</label>
                  <textarea id="cancel-comment" name="comment"></textarea>
               </div>

               <input type="submit" class="red" value="Suspendre le projet" />
               <div class="button grey cancel">Annuler</div>
            </div>
         </form>
      </div>
   </div>

   @if( $project->status === 'running' || $project->status === 'confirmed' )
      <div class="col-12 form-footer align-right">
         <div id="cancel-project" class=" button red">Suspendre ce projet</div>
      </div>
   @endif

@endsection
