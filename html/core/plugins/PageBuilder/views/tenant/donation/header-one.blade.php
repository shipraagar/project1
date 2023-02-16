
<div class="sliderArea heroImgBg" {!! render_background_image_markup_by_attachment_id($data['bg_image']) !!}>
    <div class="slider-active">
        <div class="single-slider heroPadding d-flex align-items-center">
            <div class="container" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 ">
                        <div class="heroCaption">
                            @php
                                $original_title = $data['title'];
                                $exploded = explode(' ',$original_title);
                                $exploed_data = $exploded;
                                $last_two_words = array_slice($exploded,-2,2) ?? '';
                                $first_words = array_diff($exploed_data,$last_two_words) ?? '';
                            @endphp

                            <h1 class="tittle" data-animation="fadeInUp" data-delay="0.1s">
                                {{ implode(' ', $first_words) }}
                                <span class="lineBrack"></span>
                                <span class="tittleColor slideEffect"> {{ implode(' ',$last_two_words) }}</span>
                            </h1>
                            <p class="pera" data-animation="fadeInUp" data-delay="0.3s">{{$data['description']}}</p>

                            <div class="btn-wrapper d-flex align-items-center flex-wrap">
                                <a href="{{$data['button_url']}}" class="cmn-btn2 hero-btn mr-15 mb-15 " data-animation="fadeInLeft" data-delay="0.4s">{{$data['button_text']}} <i class="fas fa-heart icon ZoomTwo"></i></a>
                                <a href="{{$data['button_right_url']}}" class="offerDate" .
                                   data-animation="fadeInRight" data-delay="0.4s">{{$data['button_right_text']}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="hero-man d-none d-lg-block f-right" >

                            {!! render_image_markup_by_attachment_id($data['right_image'],'tilt-effect maskImg','','','fadeInRight','0.2s') !!}
                            <!-- Shape 01-->
                            <div class=" shapeHero shapeHero1" data-animation="fadeInLeft" data-delay="0.8s">
                                <img src="{{global_asset('assets/tenant/frontend/themes/img/hero/donation-heroShape1.png')}}" alt="images" class="bouncingAnimation">
                            </div>
                            <!-- Shape 02-->
                            <div class=" shapeHero shapeHero2" data-animation="fadeInLeft" data-delay="0.8s">
                                <img src="{{global_asset('assets/tenant/frontend/themes/img/hero/donation-heroShape2.png')}}" alt="images" class="bouncingAnimation ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shape 03-->
    <div class="shapeHero shapeHero3 " data-animation="fadeInDown" data-delay="0.7s">
        <img src="{{global_asset('assets/tenant/frontend/themes/img/hero/donation-heroShpe3.png')}}" alt="" class="running">
    </div>
</div>
