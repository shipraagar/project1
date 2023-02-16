@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('All Themes')}}
@endsection

@section('style')
    <x-datatable.css/>
@endsection

@section('content')
    @php
        $lang_slug = request()->get('lang') ?? \App\Facades\GlobalLanguage::default_slug();
    @endphp
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <x-admin.header-wrapper>
                        <x-slot name="left">
                            <h4 class="card-title mb-5">{{__('All Themes')}}</h4>
                            <div class="right mb-4">
                               <span> {{__('Note')}} :</span>
                                <smal class="text-primary ">{{__('By default every theme button is showing (Inactive) so that means if you click on (Inactive) it will be hide or inactive from frontend, At the same way when
                                      it will show active that means this is inactive you can active by clicking it.')}}</smal>
                            </div>
                        </x-slot>
                        <x-slot name="right" class="d-flex mt-4">
                            <form action="" method="get">
                                <x-fields.select name="lang" title="{{__('Language')}}">
                                    @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                                        <option value="{{$lang->slug}}"
                                                @if($lang->slug === $lang_slug) selected @endif>{{$lang->name}}</option>
                                    @endforeach
                                </x-fields.select>
                            </form>
                            <p></p>
                        </x-slot>
                    </x-admin.header-wrapper>
                </div>

                <div class="row">
                    @foreach($all_themes as $theme)
                        @php
                             $status = $theme->status == 1 ? 'inactive' : 'active';
                             $testimonial_img = get_attachment_image_by_id($theme->image,null,true);
                            $img_url = $testimonial_img['img_url'];
                        @endphp
                        <div class="col-xl-3">
                            <div class="themePreview">
                                <a href="javascript:void(0)" id="theme-preview" data-bs-target="#theme-modal"
                                   data-bs-toggle="modal"
                                   data-id="{{$theme->id}}"
                                   data-title="{{$theme->getTranslation('title',$lang_slug)}}"
                                   data-description="{{$theme->getTranslation('description',$lang_slug)}}"
                                   data-imageid="{{$theme->image}}"
                                   data-image="{{$img_url}}"
                                   data-button_text="{{$status}}"
                                   class="theme-preview"
                                >
                                    <div class="bg" {!! render_background_image_markup_by_attachment_id($theme->image) !!}></div>
                                </a>

                                <div class="themeInfo themeInfo_{{$theme->id}}" data-id="{{$theme->id}}">
                                    <h3 class="themeName text-center"></h3>
                                </div>

                                <div class="themeLink">
                                    <h3 class="themeName"> {{$theme->getTranslation('title',$lang_slug)}}</h3>
                                    <a href="javascript:void(0)"
                                       class="active-btn text-capitalize theme_status_update_button"
                                       data-id="{{$theme->id}}"
                                       data-status="{{$status}}"
                                    >{{$status}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-modal.theme-modal :target="'theme-modal'" :title="'Theme'"/>
@endsection
@section('scripts')
    <x-datatable.js/>
    <script>
        $(document).ready(function ($) {
            "use strict";

            $('.themeInfo').hide();
            $('.modal-success-msg').hide()

            $(document).on('change', 'select[name="lang"]', function (e) {
                $(this).closest('form').trigger('submit');
                $('input[name="lang"]').val($(this).val());
            });


            $(document).on('click', '#theme-preview', function (e) {
                let el = $(this);
                let id = el.data('id');
                let title = el.data('title');
                let description = el.data('description');
                let button_text = el.attr('data-button_text');
                let image = el.data('image');

                let modal = $('#theme-modal');
                modal.attr("data-selected", id);
                modal.find('.modal-body img').attr('src', image);
                modal.find('.modal-body h2').text(title);
                modal.find('.modal-body p').text(description);
                modal.find('.modal-body a').text(button_text);
                modal.find('.modal-body a').attr('data-id', id);
                modal.find('.modal-body a').attr('data-status', button_text);
            });
        });

        $(document).on('click', '.theme_status_update_button', function (e) {
            e.preventDefault();
            let el = $(this);
            let id = el.attr('data-id');
            let status = el.attr('data-status');

            let button = $('.theme_status_update_button[data-id=' + id + ']');
            let theme_preview_button = $('.theme-preview[data-id=' + id + ']');

            $.ajax({
                'type': 'POST',
                'url': '{{route('landlord.admin.theme.status.update')}}',
                'data': {
                    '_token': '{{csrf_token()}}',
                    'id': id
                },
                beforeSend: function () {
                    if (status == 'active') {
                        button.text('Inactivating..');
                    } else {
                        button.text('Activating..');
                    }
                },
                success: function (data) {
                    var success = $('.themeInfo_'+id+'');
                    var modal = $('#theme-modal');

                    if (data.status == true) {
                        button.text('Inactive');
                        button.attr('data-status','inactive');
                        theme_preview_button.attr('data-button_text','inactive');

                        success.find('h3').text('The theme is active successfully');
                        success.slideDown(20);

                        modal.find('.themeName').text('The theme is inactive successfully');
                        $('.modal-success-msg').slideDown(20)
                    } else {
                        button.text('Active');
                        button.attr('data-status','active');
                        theme_preview_button.attr('data-button_text','active');

                        success.find('h3').text('The theme is inactive successfully');
                        success.slideDown(20);

                        modal.find('.themeName').text('The theme is inactive successfully');
                        $('.modal-success-msg').slideDown(20)
                    }

                    setTimeout(function (){
                        success.slideUp()
                        $('.modal-success-msg').slideUp()
                    }, 5000);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection
