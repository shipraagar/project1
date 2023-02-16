@include('tenant.frontend.partials.header')

@php
    $user_lang = get_user_lang();
    $over_lay_condition =  '';
    $agency_and_newspaper_class_condition = get_static_option('tenant_default_theme') == 'agency'
    || get_static_option('tenant_default_theme') == 'newspaper' || get_static_option('tenant_default_theme') == 'construction'
     || get_static_option('tenant_default_theme') == 'consultancy' ? 'agency_and_newspaper_class_condition' : '';

    switch (get_static_option('tenant_default_theme')){
        case 'donation':
            $over_lay_condition = '';
            break;

         case 'event':
            $over_lay_condition = 'hero-overly';
            break;

         case 'job-find':
            $over_lay_condition = 'sectionBg2';
            break;
    }

@endphp

<div class=" @if((in_array(request()->route()->getName(),['tenant.frontend.homepage','tenant.dynamic.page']) && !empty($page_post) && $page_post->breadcrumb == 0 ))
     d-none
@endif
">

 @if(get_static_option('tenant_default_theme') != 'eCommerce')
     @if(get_static_option('tenant_default_theme') != 'article-listing')

        <section class="sliderAreaInner {{$over_lay_condition}}" data-background="{{global_asset('assets/tenant/frontend/themes/img/hero/'.get_static_option('tenant_default_theme').'-heroBg2.jpg')}}">
            <div class="heroPadding2 {{$agency_and_newspaper_class_condition}}">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-9 col-md-10">
                            <div class="innerHeroContent text-center">
                                <h2 class="tittle wow fadeInUp" data-wow-delay="0.0s">
                                    @if(Route::currentRouteName() === 'tenant.dynamic.page')
                                        {{$page_post->getTranslation('title',$user_lang)}}
                                    @else
                                        @yield('page-title')
                                    @endif
                                </h2>
                                <nav aria-label="breadcrumb">
                                    <ul class="breadcrumb wow fadeInUp" data-wow-delay="0.2s">
                                        <li class="breadcrumb-item"><a href="{{route('tenant.frontend.homepage')}}">{{__('Home')}}</a></li>
                                        @if(Route::currentRouteName() === 'tenant.dynamic.page')
                                            <li class="breadcrumb-item"><a href="#">{{ $page_post->getTranslation('title',$user_lang) ?? '' }}</a></li>
                                        @else
                                            <li class="breadcrumb-item">@yield('page-title')</li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    @endif

    @if(get_static_option('tenant_default_theme') == 'article-listing' )
        <section class="sliderAreaInner sectionBg1">
            <div class="heroPadding2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="innerHeroContent text-center">
                                <h2 class="tittle wow fadeInUp" data-wow-delay="0s">@yield('page-title')</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

        @if(get_static_option('tenant_default_theme') == 'eCommerce')
            <div class="sliderAreaInner sectionBg1">
                <div class="heroPadding2">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-md-8 col-sm-10">
                                <div class="innerHeroContent">
                                    <!-- Bread Crumb S t a r t -->
                                    <nav aria-label="breadcrumb ">
                                        <ul class="breadcrumb wow fadeInLeft" data-wow-delay="0.0s">
                                            <li class="breadcrumb-item"><a href="eCommerce-index.html">{{__('Home')}}</a></li>
                                            @if(Route::currentRouteName() === 'tenant.dynamic.page')
                                                <li class="breadcrumb-item">
                                                    <a href="#">{{ $page_post->getTranslation('title',$user_lang) ?? '' }}</a>
                                                </li>
                                            @else
                                                <li class="breadcrumb-item">@yield('page-title')</li>
                                            @endif
                                        </ul>
                                    </nav>
                                    <!-- /END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

</div>


@yield('content')
@include('tenant.frontend.partials.footer')
