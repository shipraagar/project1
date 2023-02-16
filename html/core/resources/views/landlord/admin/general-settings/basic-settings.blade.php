@extends(route_prefix().'admin.admin-master')
@section('title') {{__('Basic Settings')}} @endsection
@section('style')
    <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">{{__('Basic Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.general.basic.settings')}}">
                    @csrf
                    <x-lang-tab>
                        @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                        @php $slug = $lang->slug; @endphp
                        <x-slot :name="$slug">
                            <x-fields.input type="text" value="{{get_static_option('site_'.$lang->slug.'_title')}}" name="site_{{ $lang->slug}}_title" label="{{__('Site Title')}}"/>
                            <x-fields.input type="text" value="{{get_static_option('site_'.$lang->slug.'_tag_line')}}" name="site_{{ $lang->slug}}_tag_line" label="{{__('Site Tag Line')}}"/>
                            <x-fields.textarea type="text" value="{{get_static_option('site_'.$lang->slug.'_footer_copyright_text')}}" name="site_{{ $lang->slug}}_footer_copyright_text" label="{{__('Footer Copyright Text')}}" info="{{__('{copy} Will replace by & and {year} will be replaced by current year.')}}"/>
                        </x-slot>
                        @endforeach
                    </x-lang-tab>

                    <div class="form-group">
                        @php
                            $list = DateTimeZone::listIdentifiers();
                        @endphp
                        <label for="timezone">{{__('Select Timezone')}}</label>
                        <select class="form-control" name="timezone" id="timezone">
                            @foreach($list as $zone)
                                <option value="{{$zone}}" {{$zone == get_static_option('timezone') ? 'selected' : ''}}>{{$zone}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted"></small>
                    </div>

                    <x-fields.switcher value="{{get_static_option('dark_mode_for_admin_panel')}}" name="dark_mode_for_admin_panel" label="{{__('Enable/Disable Dark Mode For Admin Panel')}}"/>
                    @if(!tenant())
                         <x-fields.switcher value="{{get_static_option('mouse_cursor_effect_status')}}" name="mouse_cursor_effect_status" label="{{__('Enable/Disable Mouse Cursor Effect')}}"/>
                    @endif
                    <x-fields.switcher value="{{get_static_option('maintenance_mode')}}" name="maintenance_mode" label="{{__('Enable/Disable Maintenance Mode')}}"/>
                    <x-fields.switcher value="{{get_static_option('site_force_ssl_redirection')}}" name="site_force_ssl_redirection" label="{{__('Enable/Disable Site SSL Redirection')}}"/>
                    <x-fields.switcher value="{{get_static_option('user_email_verify_status')}}" name="user_email_verify_status" label="{{__('Disable/Enable User Email Verify')}}" info="{{__('if you keep it no, it will allow user to register without being ask for email verify.')}}"/>

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
