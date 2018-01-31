<section>
   <h2>@lang('dashboard.document.history')</h2>

   @php $acceptedAttr = $type . '_accepted'; @endphp
   @foreach( $offers as $offer )
      <div class="offer">
         <p class="document">
            @if( $offer->declined )
               <span class="status icon-delete"></span>
            @elseif( $match->$acceptedAttr && $match->$type->id === $offer->document_id )
               <span class="status icon-check"></span>
            @else
               <span class="status icon-dot"></span>
            @endif

            <strong>@lang('common.datetime', ['date' => date('d/m/Y', strtotime($offer->document->created_at)), 'time' => date('H:i', strtotime($offer->document->created_at))])</strong><br />
            <a href="{{ route('serve_document', ['id' => $offer->document->id]) }}" target="_blank">@lang('buttons.download_file')</a>
         </p>
         @if( $offer->owner_comment )
            <div class="comment">
               <div class="title">@lang('fields.comment')</div>
               <p>{!! nl2br($offer->owner_comment) !!}</p>
            </div>
         @endif
      </div>
   @endforeach
</section>
