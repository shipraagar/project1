@php
    $current_lang = \App\Facades\GlobalLanguage::user_lang_slug();

    if (str_contains($data['title'], '{h}') && str_contains($data['title'], '{/h}'))
    {
        $text = explode('{h}',$data['title']);

        $highlighted_word = explode('{/h}', $text[1])[0];

        $highlighted_text = '<span class="color">'. $highlighted_word .'</span>';
        $final_title = '<h2 class="tittle wow fadeInUp" data-wow-delay="0.0s">'.str_replace('{h}'.$highlighted_word.'{/h}', $highlighted_text, $data['title']).'</h2>';
    } else {
        $final_title = '<h2 class="tittle wow fadeInUp" data-wow-delay="0.0s">'. $data['title'] .'</h2>';
    }
@endphp

<section class="categoriesArea section-bg section-padding" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                <div class="section-tittle text-center mb-60">
                   {!! $final_title !!}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($data['repeater_data']['repeater_title_'.$current_lang] ?? [] as $key => $r_title)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="singleCat mb-24 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="cat-icon">
                            {!! render_image_markup_by_attachment_id($data['repeater_data']['repeater_image_'.$current_lang][$key] ?? '') !!}
                        </div>
                        <div class="cat-cap">
                            <h5><a href="{{$data['repeater_data']['repeater_title_url_'.$current_lang][$key] ?? ''}}" class="tittle">{{$r_title ?? ''}}</a></h5>
                            <p class="pera">{{$data['repeater_data']['repeater_subtitle_'.$current_lang][$key] ?? ''}}</p>
                        </div>
                    </div>
                </div>
             @endforeach
        </div>
    </div>
</section>
