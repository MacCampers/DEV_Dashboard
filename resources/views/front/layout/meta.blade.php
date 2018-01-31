<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<meta name="description" content="@yield('description', trans('common.meta_description'))" />
<meta name="keywords" content="" />

<meta property="og:title" content="BenoitTabry | @yield('title')" />
<meta property="og:url" content="{{ Request::url() }}" />

<title>Equiteasy | @yield('title')</title>
