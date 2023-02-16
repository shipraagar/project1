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
<div class="exploreTemplates" data-padding-top="{{$data['padding_top']}}" data-padding-bottom="{{$data['padding_bottom']}}">
    <div class="container">
        <div class="row align-items-center mb-40">
            <div class="col-md-8 col-sm-6">
                <div class="section-tittle mb-0">
                {!! $final_title !!}
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="btn-wrapper mb-20 f-right">
                    <a href="{{$data['right_text_url']}}" target="_blank" class="cmn-btn2">{{$data['right_text']}}
                        <i class="las la-long-arrow-alt-right icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Left -->
            @foreach($data['themes'] as $item)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="singleTemplates mb-24  wow fadeInUp" data-wow-delay="0.0s">
                            <div class="templateImg Effect">
                                @php
                                    $image_url_con = $item->is_available == 1 ? 'href='.$item->url.' target="_blank"' : '';
                                @endphp
                                <a {{$image_url_con}}>
                                    {!! render_image_markup_by_attachment_id($item->image,'lazy') !!}
                                </a>
                            </div>
                            <div class="templateDetails">
                                <div class="cap">
                                    <h4><a {{$image_url_con}} class="templateTittle">{{$item->getTranslation('title',$current_lang)}}</a></h4>
                                    <p class="templateCap">{{$item->getTranslation('description',$current_lang)}}</p>
                                </div>

                                 @if($item->is_available == 1)
                                    <div class="btn-wrapper mb-20">
                                        <a href="{{ $item->url}}" target="_blank" class="cmn-btn cmn-btns btn__livePreview" >{{$data['bottom_text']}}</a>
                                    </div>
                                   @else
                                    <div class="btn-wrapper mb-20">
                                        <a href="#!" class="cmn-btn cmn-btns coming_soon__btn" >{{__('Not Available')}}</a>
                                    </div>
                                  @endif

                            </div>
                        </div>
                    </div>
             @endforeach
        </div>
    </div>
</div>
