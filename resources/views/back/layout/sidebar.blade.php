<div class="logo align-center">
   <a href="{{ env('APP_URL') }}" target="_blank"><img src="{{ asset('img/logo_v_white.png') }}" width="175" alt="Equiteasy" /></a>
</div>

<div class="login align-center">
   <p>Connecté(e) en tant que {{ Auth::guard('admin')->user()->getFullName() }}</p>
   <p class="logout"><a href="/admin/logout">déconnexion</a></p>
</div>

<ul>
   @if( Auth::guard('admin')->user()->role === 'cdd' )
      <li><a href="/admin/companies/create">Nouvelle société</a></li>
   @else
      <li class="{{ Request::is('admin/companies*') ? 'active' : '' }}"><a href="/admin/companies">Sociétés <span class="count">({{ App\Company::count() }})</span></a></li>
      <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a href="/admin/users">Contacts <span class="count">({{ App\User::count() }})</span></a></li>
      <li class="{{ Request::is('admin/strategies*') ? 'active' : '' }}"><a href="/admin/strategies">Stratégies <span class="count">({{ App\Strategy::count() }})</span></a></li>

      <li class="separator"></li>

      <li class="{{ Request::is('admin/projects*') ? 'active' : '' }}"><a href="/admin/projects">Projets <span class="count">({{ App\Project::count() }})</span></a></li>

      <li class="separator"></li>

      <li class="{{ Request::is('admin/invoices*') ? 'active' : '' }}"><a href="/admin/invoices">Factures</a></li>

      <li class="separator"></li>

      <li><a href="/admin/translations" target="_blank">Traductions</a></li>
   @endif
</ul>
