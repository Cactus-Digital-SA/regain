<!DOCTYPE html>
@php
$menuFixed = '';
$navbarType = 'layout-navbar-fixed';
$isFront = 'Front';
$contentLayout = (isset($container) ? (($container === 'container-xxl') ? "layout-compact" : "layout-wide") : "");
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}" class="{{ $configData['style'] }}-style {{($contentLayout ?? '')}} {{ ($navbarType ?? '') }} {{ ($menuFixed ?? '') }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}" dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="{{ $configData['layout'] . '-menu-' . $configData['themeOpt'] . '-' . $configData['styleOpt'] }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title') |
    {{ config('appVariables.templateName') ? config('appVariables.templateName') : 'TemplateName' }}</title>
  <meta name="description" content="{{ config('appVariables.templateDescription') ? config('appVariables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('appVariables.templateKeyword') ? config('appVariables.templateKeyword') : '' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="{{ config('appVariables.productPage') ? config('appVariables.productPage') : '' }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  @include('frontend/layouts/sections/stylesFront')
  @include('frontend/layouts/sections/scriptsIncludesFront')
</head>

<body>
<div class="container-xxl">
  <!-- Layout Content -->
  @yield('layoutContent')
</div>
  <!--/ Layout Content -->
  @include('frontend/layouts/sections/scriptsFront')
</body>

</html>
