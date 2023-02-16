
<div class="testimonialarea section-padding2">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row">
            <div class="col-xxl-7 col-xl-7 col-lg-8 col-md-9 col-sm-10">
                <div class="section-tittle mb-50">
                    @php
                        $original_title = $data['title'];
                        $explode_title = explode(' ',$original_title);
                        $title_after_expo = $explode_title;

                        $hightlited_word = end($explode_title);
                        array_pop($title_after_expo);
                    @endphp

                    <h2 class="tittle">
                        {{ implode(' ',$title_after_expo)   }}
                        <span class="textFlip tittleBgOne wow ladeInLeft" data-wow-delay="0.0s">
                                @for($i = 0; $i<strlen($hightlited_word); $i++)
                                <span class="single" style="--i:{{$i}}">{{$hightlited_word[$i]}}</span>
                            @endfor
                      </span>

                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="global-slick-init slider-inner-margin arrowStyleThree" data-infinite="false" data-arrows="true" data-dots="false" data-slidesToShow="3" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="las fa-angle-left"></i></div>'
                     data-nextArrow='<div class="next-icon"><i class="las fa-angle-right"></i></div>' data-responsive='[{"breakpoint": 1800,"settings": {"slidesToShow": 3}},{"breakpoint": 1600,"settings": {"slidesToShow": 3}},{"breakpoint": 1400,"settings": {"slidesToShow": 3}},{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 991,"settings": {"slidesToShow": 2}},{"breakpoint": 768, "settings": {"slidesToShow": 2}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>

                    @foreach($data['testimonial'] as $data)
                        <div class="singleTestimonial">
                            <div class="testiPera">
                                <p class="pera">{{$data->getTranslation('description',get_user_lang())}}</p>
                            </div>
                            <!-- Client -->
                            <div class="testimonialClient">
                                <!-- Clients -->
                                <div class="clients">
                                    <div class="clientImg">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                    <div class="clientText">
                                        <span class="clientName">{{$data->getTranslation('name',get_user_lang())}}</span>
                                        <p class="clinetDisCrip">{{$data->getTranslation('designation',get_user_lang())}}</p>
                                    </div>
                                </div>
                                <!-- Client feedback -->
                                <div class="feedback">
                                    <ul class="rattingList">
                                        <li class="listItems"><i class="las fa-star icon"></i></li>
                                        <li class="listItems"><i class="las fa-star icon"></i></li>
                                        <li class="listItems"><i class="las fa-star icon"></i></li>
                                        <li class="listItems"><i class="las fa-star icon"></i></li>
                                        <li class="listItems"><i class="las fa-star icon"></i></li>
                                    </ul>
                                    <div class="dates">
                                        <span class="dateTime">{{date('d M Y',strtotime($data->created_at))}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
