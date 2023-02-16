@extends(route_prefix().'admin.admin-master')

@section('title')
    {{__('Theme Settings')}}
@endsection

@section('style')
    <x-media-upload.css/>
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <x-error-msg/>
                <x-flash-msg/>
                <h4 class="card-title mb-5">{{__('Theme Settings')}}</h4>
                    @php
                        $themes = ['event','donation','job-find','support-ticketing','article-listing','eCommerce','agency','newspaper','construction','consultancy'];
                    @endphp

                <form action="{{ route('tenant.admin.theme') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="tenant_default_theme" value="{{ get_static_option('tenant_default_theme') }}" name="tenant_default_theme">
                        </div>
                        <div class="row">

                            @foreach($themes as $theme)
                                <div class="col-lg-4">
                                    <div class=" mb-4 img-select img-select-theme @if(get_static_option('tenant_default_theme') == $theme ) selected @endif">
                                        <div class="img-wrap">
                                            <img src="{{global_asset('assets/tenant/frontend/img/gallery/'.$theme.'.jpg')}}" data-theme="{{$theme}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="btn-default mt-5">
                        <button class="btn btn-primary">{{__('Update Default')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <x-media-upload.markup/>
@endsection
@section('scripts')
    <x-media-upload.js/>

    <script>
        $(document).ready(function(){
            var imgSelect2 = $('.img-select-theme');
            var theme_name = $('#tenant_default_theme').val();
            imgSelect2.removeClass('selected');
            $('img[data-theme="'+theme_name+'"]').parent().parent().addClass('selected');
            $(document).on('click','.img-select-theme img',function (e) {
                e.preventDefault();
                imgSelect2.removeClass('selected');
                $(this).parent().parent().addClass('selected').siblings();
                $('#tenant_default_theme').val($(this).data('theme'));
            })

        });
    </script>
@endsection
