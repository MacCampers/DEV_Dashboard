@php
$sectionSizes = [
   'section_1' => 14,
   'section_8' => 6,
   'section_3' => 14,
   'section_4' => 11,
   'section_5' => 16,
   'section_7' => 8,
];
@endphp

<div class="faq-container">
   <div class="col-4 lg-12 col-summary">
      <div class="summary-container">
         <div id="faq-summary">
            <h3>@lang('fields.summary')</h3>
            <ol>
               @foreach( $sectionSizes as $section => $count )
                  <li data-section="faq-{{ $loop->index }}">{{ $loop->index + 1 }}. @lang('help.'. $section .'.title')</li>
               @endforeach
            </ol>
         </div>
      </div>
   </div>
   <div class="col-8 lg-12">
      @foreach( $sectionSizes as $section => $count )
         <section>
            <h3 id="faq-{{ $loop->index }}">{{ $loop->index + 1 }}. @lang('help.'. $section .'.title')</h3>

            <ol id="{{ $section }}">
               @for( $i=1; $i<=$count; $i++ )
                  <li class="item">
                     <div class="question">@lang('help.'. $section .'.question_'. $i)</div>
                     <div class="answer">@lang('help.'. $section .'.answer_'. $i)</div>
                  </li>
               @endfor
            </ol>
         </section>
      @endforeach
   </div>
</div>
