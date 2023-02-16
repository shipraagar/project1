@extends(route_prefix().'admin.admin-master')
@section('title') {{__('All Theme List')}} @endsection

@section('style')
    <x-media-upload.css/>
    <x-datatable.css/>
@endsection

@section('content')
    @php
        $lang_slug = request()->get('lang') ?? \App\Facades\GlobalLanguage::default_slug();
    @endphp
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <x-admin.header-wrapper>
                    <x-slot name="left">
                        <h4 class="card-title mb-5">{{__('All Theme List')}}</h4>
                    </x-slot>
                    <x-slot name="right" class="d-flex">
                        <form action="" method="get">
                            <x-fields.select name="lang" title="{{__('Language')}}">
                                @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                                    <option value="{{$lang->slug}}" @if($lang->slug === $lang_slug) selected @endif>{{$lang->name}}</option>
                                @endforeach
                            </x-fields.select>
                        </form>
                    </x-slot>
                </x-admin.header-wrapper>
                <x-error-msg/>
                <x-flash-msg/>

                    <x-datatable.table>
                        <x-slot name="th">
                            <th>{{__('ID')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>
                                {{__('Status')}}<br><br>
                                <small class="text-white">{{__('( Status active or inactive will )')}}</small><br>
                                <small class="text-white">{{__(' define show or hide any theme )')}}</small><br>
                            </th>
                            <th>
                                {{__('Is Available')}}
                                <br><br>
                                <small class="text-white">{{__('( Available yes will show direct ')}}</small><br>
                                <small class="text-white">{{__(' theme image and Available no ')}}</small><br>
                                <small class="text-white">{{__('will be shown as coming soon..! )')}}</small>
                            </th>
                            <th>{{__('image')}}</th>
                            <th>{{__('Action')}}</th>
                        </x-slot>
                        <x-slot name="tr">
                            @foreach($all_themes as $data)
                                <tr>
                                    <td>{{ $data->id  }}</td>
                                    <td>
                                        {{ $data->getTranslation('title',$lang_slug)}}
                                    </td>

                                    <td class="text-center">
                                        <x-status-span :status="$data->status"/>
                                    </td>
                                    <td class="text-center">
                                        @if($data->is_available == 1)
                                            <span class="alert alert-sm alert-info" >{{__('Yes')}}</span>
                                        @else
                                            <span class="alert alert-sm alert-danger" >{{__('No')}}</span>
                                         @endif
                                    </td>
                                    <td>
                                        @php
                                            $testimonial_img = get_attachment_image_by_id($data->image,null,true);
                                        @endphp
                                        {!! render_attachment_preview_for_admin($data->image ?? '') !!}
                                        @php  $img_url = $testimonial_img['img_url']; @endphp
                                    </td>
                                    <td class="text-center">
                                        <a href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#testimonial_item_edit_modal"
                                           class="btn btn-primary btn-xs mb-3 mr-1 edit_theme_button"
                                           data-bs-placement="top"
                                           title="{{__('Edit')}}"
                                           data-id="{{$data->id}}"
                                           data-action="{{route('landlord.admin.theme.update')}}"
                                           data-title="{{$data->getTranslation('title',$lang_slug)}}"
                                           data-slug="{{$data->slug}}"
                                           data-description="{{$data->getTranslation('description',$lang_slug)}}"
                                           data-status="{{$data->status}}"
                                           data-url="{{$data->url}}"
                                           data-is_premium="{{$data->is_available}}"
                                           data-imageid="{{$data->image}}"
                                           data-image="{{$img_url}}"
                                        >
                                            <i class="las la-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-datatable.table>
            </div>
        </div>
    </div>

        <div class="modal fade" id="testimonial_item_edit_modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{__('Edit Theme Item')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" id="testimonial_edit_modal_form" method="post"
                          enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="lang" value="{{$lang_slug}}">
                            <input type="hidden" name="id" class="theme_id" value="">
                            <x-fields.input name="title" label="{{__('Title')}}" class="edit_title" />
                            <x-fields.input name="url" label="{{__('URL')}}" class="edit_url" />
                            <x-fields.textarea name="description" label="{{__('Description')}}" class="edit_description" />

                            <x-fields.select name="status" title="{{__('Status')}}" class="edit_status">
                                <option value="1">{{__('Active')}}</option>
                                <option value="0">{{__('Inactive')}}</option>
                            </x-fields.select>

                            <x-fields.select name="is_available" title="{{__('Is Available')}}" class="edit_is_premium">
                                <option value="" disabled selected>{{__('Select Availability')}}</option>
                                <option value="1">{{__('Yes')}}</option>
                                <option value="0">{{__('No')}}</option>
                            </x-fields.select>

                            <x-fields.media-upload name="image" title="{{__('Image')}}" dimentions="{{__('636x477 px image recommended')}}" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
    <x-datatable.js/>
    <script>
        $(document).ready(function($){
            "use strict";

            <x-bulk-action-js :url="route( route_prefix().'admin.testimonial.bulk.action')" />
            $(document).on('change','select[name="lang"]',function (e){
                $(this).closest('form').trigger('submit');
                $('input[name="lang"]').val($(this).val());
            });

            $(document).on('click', '.edit_theme_button', function () {
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var slug = el.data('slug');
                var url = el.data('url');
                var description = el.data('description');
                var action = el.data('action');
                var image = el.data('image');
                var imageid = el.data('imageid');

                var form = $('#testimonial_edit_modal_form');
                form.attr('action', action);
                form.find('.theme_id').val(id);
                form.find('.edit_title').val(title);
                form.find('.edit_slug').val(slug);
                form.find('.edit_url').val(url);
                form.find('.edit_description').val(description);
                form.find('.edit_status option[value="' + el.data('status') + '"]').attr('selected', true);
                form.find('.edit_is_premium option[value="' + el.data('is_premium') + '"]').attr('selected', true);

                if (imageid != '') {
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered">' +
                        '<img class="avatar user-thumb" src="' + image + '" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
            });

        });
    </script>
@endsection
