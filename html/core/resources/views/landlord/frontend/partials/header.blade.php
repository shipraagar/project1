<!DOCTYPE html>
<html dir="{{ \App\Facades\GlobalLanguage::user_lang_dir() }}" lang="{{ \App\Facades\GlobalLanguage::user_lang_slug() }}">
<head>
    {!! get_static_option('site_third_party_tracking_code_just_after_head') !!}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    {!! render_favicon_by_id(get_static_option('site_favicon')) !!}

    <title>
        @if(!request()->routeIs('landlord.homepage'))
            @yield('title')
            -
            {{filter_static_option_value('site_'.\App\Facades\GlobalLanguage::user_lang_slug().'_title',$global_static_field_data)}}
        @else
            {{filter_static_option_value('site_'.\App\Facades\GlobalLanguage::user_lang_slug().'_title',$global_static_field_data)}}
            @if(!empty(filter_static_option_value('site_'.\App\Facades\GlobalLanguage::user_lang_slug().'_tag_line',$global_static_field_data)))
                - {{filter_static_option_value('site_'.\App\Facades\GlobalLanguage::user_lang_slug().'_tag_line',$global_static_field_data)}}
            @endif
        @endif
    </title>

    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/plugin.css')}}">

    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/custom-dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/main-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/common/css/helpers.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/developer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/dynamic-style.css')}}">

    @if(\App\Facades\GlobalLanguage::user_lang_dir() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/landlord/frontend/css/rtl.css')}}">
    @endif



    @include('landlord.frontend.partials.font-manage')
    @include('landlord.frontend.partials.color-font-variable')

    @yield('style')

    @yield('seo_data')
    {!! get_static_option('site_third_party_tracking_code') !!}
</head>
<body>
{!! get_static_option('site_third_party_tracking_code_just_after_body') !!}
@include('landlord.frontend.partials.navbar')

