
<section class="subscribeArea bottom-padding wow ladeInUp" data-wow-delay="0.0s">
    <div class="container" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
        <div class="row">
            <div class="col-xxl-12">
                <div class="subscribeCaption sectionBg1 text-center">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-lg-8 col-md-9 col-sm-11">
                            @php
                                $original_title = $data['title'];
                                $explode_title = explode(' ',$original_title);
                                $title_after_expo = $explode_title;

                                $hightlited_word = end($explode_title);
                                array_pop($title_after_expo);
                            @endphp

                            <h2 class="tittle">
                                {{ implode(' ',$title_after_expo) }}
                                <span class="textFlip tittleBgOne wow ladeInLeft" data-wow-delay="0.0s">
                                @for($i = 0; $i<strlen($hightlited_word); $i++)
                                        <span class="single" style="--i:{{$i}}">{{$hightlited_word[$i]}}</span>
                                @endfor
                          </span>
                            </h2>
                            <p class="pera wow ladeInUp" data-wow-delay="0.1s">{{ $data['description'] }}</p>
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <!-- Subscribe Form -->
                                    <form action="#" class="wow ladeInUp" data-wow-delay="0.2s">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="mail" name="email" class="email" placeholder="{{__($data['button_placeholder_text'])}}">
                                        <div class="form-message-show mt-2"></div>
                                        <button class="subscribe-btn newsletter-submit-btn" type="submit">{{$data['button_text']}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

