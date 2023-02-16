@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Seo Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">{{__('Seo Identity')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>

                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.general.seo.settings')}}">
                    @csrf
                    <x-lang-tab>
                        @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                            @php
                                $slug = $lang->slug;
                            @endphp
                        <x-slot :name=" $slug">
                            <x-fields.input type="text" value="{{get_static_option('site_'.$lang->slug.'_meta_title')}}" name="site_{{ $lang->slug}}_meta_title" label="{{__('Site Meta Author')}}"/>
                            <x-fields.textarea  value="{{get_static_option('site_'.$lang->slug.'_meta_tags')}}" name="site_{{ $lang->slug}}_meta_tags" label="{{__('Site Meta Tags')}}" info="{{__('separate tags by comma (,)')}}"/>
                            <x-fields.textarea  value="{{get_static_option('site_'.$lang->slug.'_meta_keywords')}}" name="site_{{ $lang->slug}}_meta_keywords" label="{{__('Site Meta Keywords')}}" info="{{__('separate tags by comma (,)')}}"/>
                            <x-fields.textarea value="{{get_static_option('site_'.$lang->slug.'_meta_description')}}" name="site_{{ $lang->slug}}_meta_description" label="{{__('Site Meta Description')}}"/>
                            <h4 class="mb-3">{{__('OG Meta Info')}}</h4>
                            <x-fields.input type="text" value="{{get_static_option('site_'.$lang->slug.'_og_meta_title')}}" name="site_{{ $lang->slug}}_og_meta_title" label="{{__('Og Meta Title')}}"/>
                            <x-fields.textarea  value="{{get_static_option('site_'.$lang->slug.'_og_meta_description')}}" name="site_{{ $lang->slug}}_og_meta_description" label="{{__('Og Meta Description')}}"/>
                            <x-fields.media-upload name="site_{{$lang->slug}}_og_meta_image" title="{{__('Site Og Image')}}" id="{{get_static_option('site_'.$lang->slug.'_og_meta_image')}}"/>
                        </x-slot>
                        @endforeach
                    </x-lang-tab>
                    <button type="submit" class="btn btn-gradient-primary me-2">{{__('Save Changes')}}</button>
                </form>

            </div>
        </div>
    </div>
    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>
@endsection
