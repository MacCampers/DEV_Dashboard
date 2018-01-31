<ul class="list">
   @foreach( $loiRequirements as $requirement )
      @php $intersection = $requirement->children->intersect($selectedRequirements); @endphp

      @if( $selectedRequirements->contains($requirement->id) || $intersection->count() > 0 )
         <li>
            <strong>{{ $requirement->name }}</strong>

            @if( $selectedRequirements->contains($requirement->id) )
               <ul>
                  @foreach( $requirement->children as $child )
                     <li>{{ $child->name }}</li>
                  @endforeach
               </ul>
            @elseif( $intersection->count() > 0 )
               <ul>
                  @foreach( $intersection as $child )
                     <li>{{ $child->name }}</li>
                  @endforeach
               </ul>
            @endif
         </li>
      @endif
   @endforeach
</ul>
