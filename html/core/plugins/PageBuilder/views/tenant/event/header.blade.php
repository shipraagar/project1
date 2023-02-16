
<div class="sliderArea eventSlider heroImgBg hero-overly" {!! render_background_image_markup_by_attachment_id($data['bg_image']) !!}>
    <div class="slider-active">
        <!-- Single -->
        <div class="single-slider">
            <div class="container" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
                <div class="row justify-content-between align-items-end">
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="heroCaption heroPadding">
                            @php
                                $original_title = $data['title'];
                                $explode = explode(' ',$original_title);
                                $after_explode_title = $explode;

                                $first_two_words = array_slice($after_explode_title,0,2);
                                $number_three_word = array_slice($after_explode_title,2,1);
                                $last_four_words = array_slice($after_explode_title,-4,4);

                                $merge = array_merge($first_two_words,$number_three_word,$last_four_words);
                                $animation_word = array_diff($after_explode_title,$merge);

                                $implode_animation_word = implode(' ',$animation_word);
                            @endphp

                            <h1 class="tittle textEffect" data-animation="ladeInUp" data-delay="0.1s">{{ implode(' ',$first_two_words) }}
                                <span class="lineBrack"></span>
                                {{ implode(' ',$number_three_word) }}

                                <span class="textFlip tittleBgColor colorEffect2">
                                    @for($i = 0; $i < strlen($implode_animation_word); $i++)
                                      <span class="single" style="--i:{{ $i }}">{{ $implode_animation_word[$i] }}</span>
                                    @endfor
                                 </span>
                                <span class="lineBrack"></span>
                                {{ implode(' ',$last_four_words) }}
                            </h1>
                            <p class="pera" data-animation="ladeInUp" data-delay="0.3s">{!! $data['description'] !!}</p>

                            <div class="btn-wrapper d-flex align-items-center flex-wrap">
                                <a href="{{ $data['button_url'] }}" class="cmn-btn0 hero-btn mr-15 mb-15 " data-animation="ladeInLeft" data-delay="0.5s">{{ $data['button_text'] }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="hero-man d-none d-lg-block f-right running" >
                            {!! render_image_markup_by_attachment_id($data['right_image'],'','','ladeInUp','0.2s') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
