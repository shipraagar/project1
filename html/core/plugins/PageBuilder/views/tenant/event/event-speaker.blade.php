
<section class="teamArea sectionBg1 section-padding">
    <div class="container" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
        <div class="row justify-content-center">
            <div class="col-xxl-7 col-xl-7 col-lg-8 col-md-9 col-sm-10">
                <div class="section-tittle text-center mb-50">

                    @php
                        $original_title = $data['title'];
                        $explode_title = explode(' ',$original_title);

                        $title_after_expo = $explode_title;

                        $hightlited_word = end($explode_title);
                        array_pop($title_after_expo);

                    @endphp

                    <h2 class="tittle">
                        {{ implode(' ',$explode_title) }}
                        <span class="textFlip tittleBgOne wow ladeInLeft" data-wow-delay="0.0s">
                                @for($i = 0; $i<strlen($hightlited_word); $i++)
                                <span class="single" style="--i:{{$i}}">{{$hightlited_word[$i] ?? ''}}</span>
                            @endfor
                      </span>

                    </h2>

                </div>
            </div>
        </div>
        <div class="row">
            @foreach($data['repeater_data']['repeater_name_'.get_user_lang()] ?? [] as $key => $name)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                    <figure class="singleTeam tilt-effect mb-24">
                        <div class="team-img">
                            <a href="#!">
                                {!! render_image_markup_by_attachment_id($data['repeater_data']['repeater_image_'.get_user_lang()][$key]) ?? null !!}
                            </a>
                            <!-- Blog Social -->
                            <ul class="teamSocial">
                                <li class="single"><a href="{{$data['repeater_data']['repeater_facebook_url_'.get_user_lang()][$key] }}" class="social"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="single"><a href="{{$data['repeater_data']['repeater_twitter_url_'.get_user_lang()][$key] }}" class="social"><i class="fab fa-twitter"></i></a></li>
                                <li class="single"><a href="{{$data['repeater_data']['repeater_instagram_url_'.get_user_lang()][$key] }}" class="social"><i class="las fa-globe"></i></a></li>
                            </ul>
                        </div>
                        <figcaption class="teamCaption">
                            <h3><a href="#!" class="title">{{$name ?? ''}}</a></h3>
                            <p class="pera">{{ $data['repeater_data']['repeater_designation_'.get_user_lang()][$key] ?? '' }}</p>
                        </figcaption>
                    </figure>
                </div>
            @endforeach

        </div>
    </div>
</section>
