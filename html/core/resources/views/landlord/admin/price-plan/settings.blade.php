@extends('landlord.admin.admin-master')
@section('title')
    {{__('Price Plan Settings')}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{global_asset('assets/common/css/select2.min.css')}}">
    <x-media-upload.css/>
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <x-error-msg/>
                <x-flash-msg/>
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title my-2">{{__("Price Plan Settings")}}</h4>
                        <form action="{{route('landlord.admin.price.plan.settings')}}" method="POST" enctype="multipart/form-data">
                          @csrf
                            @php
                                $fileds = [1 =>'One Day', 2 => 'Two Day', 3 => 'Three Day', 4 => 'Four Day', 5 => 'Five Day', 6 => 'Six Day', 7=> 'Seven Day'];
                            @endphp
                               <div class="form-group  mt-3">
                                   <label for="site_logo">{{__('Select How many days earlier expiration mail alert will be send')}}</label>
                                   <select name="package_expire_notify_mail_days[]" class="form-control expiration_dates" multiple="multiple">

                                       @foreach($fileds as $key => $field)
                                           @php
                                               $package_expire_notify_mail_days = get_static_option('package_expire_notify_mail_days');
                                               $decoded = json_decode($package_expire_notify_mail_days) ?? [];
                                           @endphp
                                         <option value="{{$key}}"
                                         @foreach($decoded as  $day)
                                                {{$day == $key ? 'selected' : ''}}
                                          @endforeach
                                         >{{__($field)}}</option>
                                       @endforeach
                                   </select>
                               </div>

                            <x-fields.input name="how_many_times_can_user_take_free_or_zero_package" value="{{get_static_option('how_many_times_can_user_take_free_or_zero_package')}}" label="{{__('How many times user can take free packages')}}"/>


                            <div class="form-group">
                                @php
                                  //  $themes = \App\Models\Themes::where(['status'=> 1, 'is_available' => 1])->get();
                                     $themes = ['event','donation','job-find','support-ticketing','article-listing','eCommerce','agency','newspaper'];
                                    $languages = \App\Models\Language::where('status', 1)->get();
                                @endphp
                                <label for="default-theme">{{__('Default Theme Set')}}</label>
                                <select name="landlord_default_theme_set" id="default-theme" class="form-control">
                                    @foreach($themes as $theme)
                                        <option value="{{$theme}}" {{get_static_option('landlord_default_theme_set') == $theme ? 'selected' : ''}}>{{ ucfirst($theme) }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="default-theme">{{__('Default Language Set')}}</label>
                                <select name="landlord_default_language_set" class="form-control">
                                    @foreach($languages as $lang)
                                        @break(!in_array($lang->slug,['en_GB','ar']))
                                        <option value="{{$lang->slug}}" {{get_static_option_central('landlord_default_language_set') == $lang->slug ? 'selected' : ''}}>{{$lang->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-primary">{{__('English and Arabic language is currently available to set')}}</small>
                            </div>

                            <x-fields.input name="landlord_default_tenant_admin_username_set" value="{{get_static_option_central('landlord_default_tenant_admin_username_set')}}" label="{{__('Default Admin Username Set')}}"/>
                            <x-fields.input name="landlord_default_tenant_admin_password_set" value="{{get_static_option_central('landlord_default_tenant_admin_password_set')}}" label="{{__('Default Admin Password Set')}}"/>


                            <div class="form-group">
                                <label for="">{{__('Default Logo Set')}}</label><br>
                                <input type="file" name="landlord_default_tenant_admin_logo_set" class="btn btn-info btn-sm" ><br>
                            </div>

                            <div class="old-logo mt-3">
                                <label for="" class="mb-3">{{__('Current Logo')}}  </label><br>
                                <img src="{{url('assets/tenant/seeder-demo-assets/ecommerce-logo1671430181.png')}}" alt="" style="height: 60px;">
                            </div>

                            <button type="submit" id="update" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-media-upload.markup/>
@endsection

@section('scripts')
    <x-media-upload.js/>
    <script src="{{global_asset('assets/common/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.expiration_dates').select2();
        });
    </script>
@endsection
