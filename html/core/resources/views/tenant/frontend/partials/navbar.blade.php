@php
    $tenant_default_theme = get_static_option('tenant_default_theme');
    $landlord_default_theme_set = get_static_option_central('landlord_default_theme_set');
    $condition = $tenant_default_theme ?? $landlord_default_theme_set;
@endphp

@include('tenant.frontend.partials.pages-portion.navbars.navbar-'.$condition)
