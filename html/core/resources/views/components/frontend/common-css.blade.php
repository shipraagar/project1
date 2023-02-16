
@php
    $themes = ['event','donation','job-find','support-ticketing','eCommerce','article-listing','agency','newspaper','construction','consultancy'];
    $default_theme = get_static_option('tenant_default_theme');
@endphp

@foreach($themes as $theme)
    @if($theme != $default_theme)
        <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/themes/css/'.$theme.'-main-style.css')}}">
   @endif
@endforeach
