<section>
   <div class="container">
      <div class="col-12">
         <h2>@lang('dashboard.match_overview.events.title')</h2>

         <div class="events">
            @if( $match->events->count() > 0 )
               @foreach( $match->events as $event )
                  <div class="event">
                     <div class="event-date">{{ $event->date }}</div>
                     <div class="event-description">@lang('dashboard.match_overview.events.' . $event->description, $event->initiator ? ['initiator' => $event->initiator] : [])</div>
                  </div>
               @endforeach
            @else
               @lang('dashboard.match_overview.events.empty')
            @endif
         </div>
      </div>
   </div>
</section>
