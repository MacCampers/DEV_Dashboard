<ul id="language-selector">
   @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
      <li data-locale="{{ $localeCode }}" {{ $localeCode === LaravelLocalization::getCurrentLocale() ? 'class=active' : '' }}>{{ strtoupper($localeCode) }}</a></li>
   @endforeach
</ul>
