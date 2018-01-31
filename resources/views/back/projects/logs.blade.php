@extends('back.layout.master')

@section('title', 'Projects > '. $project->code_name)

@section('js')
   <script type="text/javascript">
      $(function() {
         var visible = false;

         $('#show-next-results').on('click', function() {
            visible = !visible;

            $('#match-results li:not(.visible)').slideToggle(400);

            if( visible ) {
               $(this).html('Masquer les résultats non pris en compte');
            } else {
               $(this).html('Afficher les résultats non pris en compte');
            }
         });
      });
   </script>
@endsection

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Projets / {{ $project->code_name }}</h1>
      </div>
   </div>

   <a class="button-icon button-topright" href="/admin/projects/{{ $project->id }}/edit"><span class="icon-arrow-left"></span></a>

   <div class="col-12">
      <section id="match-results">
         <div class="col-12">
            <div class="form-group">
               @if( $strategies->count() > 0 )
                  <h3 class="align-center"><strong>{{ $strategies->count() }}</strong> stratégies matchées</h3>

                  <ul>
                     @php $score40 = 0; @endphp

                     @foreach( $strategies as $strategy )
                        <li{!! $strategy->score >= $score40 ? ' class="visible"' : '' !!}><span class="position">#{{ ($loop->index+1) }}</span> {{ $strategy->full_name }} <strong>({{ $strategy->score }})</strong></li>

                        @if( $loop->index+1 === 40 )
                           @php $score40 = $strategy->score; @endphp
                        @endif
                     @endforeach
                  </ul>

                  @if( $strategy->score < $score40 )
                     <div id="show-next-results">Afficher les résultats non pris en compte</div>
                  @endif
               @else
                  <p>Aucune correspondance</p>
               @endif
            </div>
         </div>
      </div>
   </div>

   <div id="logs" class="row">
      <div class="col-12">
         {!! $logs !!}
      </div>
   </div>
@endsection
