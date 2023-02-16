@include('landlord.frontend.partials.header')
<section class="sliderAreaInner sectionBg1 @if((in_array(request()->route()->getName(),['landlord.homepage','landlord.dynamic.page']) && $page_post->breadcrumb == 0 ))
     d-none
@endif">
    <div class="heroPadding2">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="innerHeroContent text-center">
                        <h2 class="tittle wow pulse" data-wow-delay=".5s">@yield('page-title')</h2>
                        <!-- Bread Crumb S t a r t -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('landlord.homepage')}}">{{__('Home')}}</a></li>
                                <li class="breadcrumb-item"><a href="">@yield('page-title')</a></li>
                            </ol>
                        </nav>
                        <!-- /END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shape -->
    <div class="shapeHero wow fadeInLeft" data-wow-delay="1s">
        <img src="{{asset('assets/landlord/frontend/img/hero/innerShape1.png')}}" alt="image" class="bouncingAnimation">
    </div>
    <div class="shapeHero2 wow fadeInRight" data-wow-delay="1s">
        <img src="{{asset('assets/landlord/frontend/img/hero/innerShape2.png')}}" alt="image" class="bouncingAnimation">
    </div>
</section>

@yield('content')
@include('landlord.frontend.partials.footer')
