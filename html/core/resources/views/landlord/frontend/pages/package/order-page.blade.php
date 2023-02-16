@extends('landlord.frontend.frontend-page-master')
@section('title')
    {{$order_details->getTranslation('title',get_user_lang())}}
@endsection

@section('page-title')
    {{__('Order For')}} {{' : '.$order_details->getTranslation('title',get_user_lang())}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{global_asset('assets/common/css/toastr.css')}}">

    <style>
        .packageArea #contact_form_btn{
            display: none;
        }

        .packageWrapper .other_if_not_login{
            margin: 20px;

        }

        .packageWrapper .other_if_not_login p{
            text-align: center;
        }

        .theme_container{
            display: none;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            background-color: var(--main-color-one);
            color: #fff;
        }
    </style>
@endsection

@section('content')
    @php
        $user_lang = get_user_lang();
    @endphp

    {{--==================================== NEW ==================================--}}
    <div class="packageArea section-padding">
        <div class="container">
            <div class="row g-4">

                @if(!auth()->guard('web')->check())
                    <div class="col-xl-8 col-lg-7 col-md-6">
                        <div class="packageWrapper">
                            <h2 class="text-center mb-4">{{__('Order Information')}}</h2>
                            <div class="login-form">
                                <form action="" method="post" enctype="multipart/form-data" class="contact-page-form style-01" id="login_form_order_page">
                                    @csrf
                                    <div class="alert alert-warning alert-block text-center">
                                        <strong >{{ __('You must login or create an account to order your package!') }}</strong>
                                    </div>
                                    <div class="error-wrap"></div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="input-form input-form2">
                                            <input type="text" name="username" class="form-control" placeholder="{{__('Username')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="input-form input-form2">
                                            <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="btn-wrapper text-center">
                                            <button href="#" class="cmn-btn1 w-100" id="login_btn">{{__('Login')}}</button>
                                        </div>
                                    </div>

                                    <div class="other_if_not_login">
                                        <p class="sinUp mb-20"><span>{{__('Don’t have an account ?')}} </span>
                                            <a href="{{route('landlord.user.register')}}" class="singApp">{{__('Sign Up')}}</a></p>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                @else

                    @php
                        $user = Auth::guard('web')->user();
                       $payment_old_data = \App\Models\PaymentLogs::where(['user_id'=> $user->id, 'payment_status'=> 'complete'])->first() ?? [];
                    @endphp
                    <div class="col-xl-8 col-lg-7 col-md-6">
                        <div class="row ">
                            <div class="packageWrapper">
                                <div class="col-lg-12">
                                    <div class="section-tittle section-tittle2 mb-30">
                                        {!! get_modified_title(get_static_option('order_page_'.$user_lang.'_form_title')) !!}
                                        @if(!empty($payment_old_data))
                                            @if($payment_old_data->count() == 1)
                                                <div class="alert alert-primary">
                                                    <h5 class="mb-4 text-center">
                                                        <small class="">{{__('You have already purchased a subscription plan, if you purchase this package than it will be replaced with extended validity!!')}}</small>
                                                    </h5>
                                                </div>
                                            @else
                                                <div class="alert alert-primary">
                                                    <h5 class="mb-4 text-center">
                                                        <small class="text-primary">{{__('You have already purchased multiple subscription plan, if you purchase this package than it will be replaced with extended validity!!')}}</small>
                                                    </h5>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <x-flash-msg/>
                                <x-error-msg/>

                                <form action="{{ route('landlord.frontend.order.payment.form') }}" method="post" enctype="multipart/form-data" class="contact-page-form style-01 order_page_form">
                                    @csrf
                                    @php
                                        $custom_fields = unserialize($order_details->custom_fields);

                                        $payment_gateway = !empty($custom_fields['selected_payment_gateway']) ? $custom_fields['selected_payment_gateway'] : '';
                                        $auth_check = auth()->guard('web')->check();
                                        $auth_user = auth()->guard('web')->user();

                                        $name = $auth_check ? $auth_user->name : '';
                                        $email = $auth_check ? $auth_user->email : '';

                                        $log_id_from_tenant_admin_for_renew =  request()->get('log_id');
                                        $subdomain_if_renew_from_tenant_admin = isset($log_id_from_tenant_admin_for_renew) ? \App\Models\PaymentLogs::find($log_id_from_tenant_admin_for_renew)?->tenant_id : '';
                                        $gateway_from_tenant_of_renew = request()->get('gateway') ?? '';
                                    @endphp
                                    <input type="hidden" name="payment_gateway" value="{{ isset($gateway_from_tenant_of_renew) ? $gateway_from_tenant_of_renew : '' }}" class="payment_gateway_passing_clicking_name">
                                    <input type="hidden" name="package_id" value="{{$order_details->id}}">
                                    <input type="hidden" name="log_id_from_tenant_admin" value="{{$log_id_from_tenant_admin_for_renew}}">
                                    <input type="hidden" name="gateway_from_renew_tenant" value="{{$gateway_from_tenant_of_renew}}">


                                    <div class="col-lg-12 col-md-12">
                                        <div class="input-form input-form2">
                                            <input type="text" name="name" value="{{$name}}" placeholder="Enter your name">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="input-form input-form2">
                                            <input type="email" name="email" value="{{$email}}" placeholder="Enter your email address">
                                        </div>
                                    </div>



                                    <div class="col-lg-12 col-md-12">
                                        <label for="subdomain" class="infoTitle">{{__('Add new subdomain')}}</label>
                                        <select class="subdomain mb-4" id="subdomain" name="subdomain">
                                            <option value="" selected disabled>{{__('Select a subdomain')}}</option>
                                            @foreach($auth_user->tenant_details ?? [] as $tenant)
                                                @continue(empty(optional($tenant->domain)->domain));
                                                <option value="{{ !empty($subdomain_if_renew_from_tenant_admin) ? $subdomain_if_renew_from_tenant_admin : $tenant->id}}">{{optional($tenant->domain)->domain}}</option>
                                            @endforeach
                                            <option value="custom_domain__dd">{{__('Add new subdomain')}}</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-md-12 mb-4">
                                        <div class="custom_subdomain_wrapper">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control custom_subdomain" id="custom-subdomain" value="{{$subdomain_if_renew_from_tenant_admin ?? ''}}" placeholder="{{__('Subdomain')}}"  aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2">.{{ env('CENTRAL_DOMAIN') }}</span>
                                            </div>

                                            <div id="subdomain-wrap"></div>
                                        </div>
                                    </div>

                                    <div class="row theme_container">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <h5>{{__('Select Theme')}}</h5>
                                                <div class="row g-2 theme-row mt-3 row-cols-1 row-cols-xxl-5 row-cols-md-3 row-cols-sm-2">
                                                    @foreach($themes as $theme)

                                                        @php
                                                            $check_theme_permission = $order_details->plan_features?->pluck('feature_name')->toArray();
                                                            if($theme->is_available == 0 || ($theme->theme_code == 'eCommerce' && !in_array("eCommerce", $check_theme_permission))){
                                                                continue ;
                                                            }

                                                            $default_admin_set = get_static_option_central('landlord_default_theme_set');
                                                            $selected_condition_if_default = $theme->theme_code == $default_admin_set ? 'selected_theme' : '';
                                                            $selected_condition_normal = $loop->first ? 'selected_theme' : '';
                                                            $final_condition =  $selected_condition_if_default ?? $selected_condition_normal
                                                        @endphp

                                                        <input type="hidden" name="theme_slug" class="theme_slug">
                                                        <div class="col position-relative">
                                                            <div class="theme-wrapper {{ $final_condition }}" data-theme="{{$theme->slug}}" data-theme_code="{{$theme->theme_code}}">
                                                                {!! render_image_markup_by_attachment_id($theme->image) !!}
                                                                @if($theme->slug == $default_admin_set)
                                                                    <h4 class="selected_text"><i class="las la-check-circle"></i></h4>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 mt-4">
                                        @if($order_details->price != 0)
                                             {!! render_payment_gateway_for_form() !!}
                                        @endif
                                    </div>
                                    @php
                                        $data = \App\Models\PaymentGateway::where('name','manual_payment')->first();
                                    @endphp

                                    @if($data->status == 1)
                                        <div class="form-group manual_payment_transaction_field  @if( get_static_option('site_default_payment_gateway') === 'manual_payment') d-block @else d-none @endif ">
                                            <div class="label mb-2">{{__('Attach your bank Document')}}</div>
                                            <input class="form-control btn btn-primary btn-sm mb-3 py-3 p-3" type="file" name="manual_payment_attachment"><br>
                                            <p class="help-info my-3">{!! get_manual_payment_description() !!}</p>
                                        </div>
                                    @endif

                                    <div class="col-sm-12">
                                        <div class="btn-wrapper text-center">
                                            <button type="submit" class="cmn-btn1 w-100">{{__('Order Package')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-xl-4 col-lg-5 col-md-6">
                    <div class="packageDetails">
                        <div class="text-center mb-40">
                            <span class="infoTitle">{{$order_details->getTranslation('title',$user_lang)}}</span>
                            <span class="pricing">{{amount_with_currency_symbol($order_details->price)}}</span>
                        </div>
                        <ul>
                            {!! get_all_main_feature_create_permission($order_details) !!}
                            @foreach($order_details->plan_features as $key=> $item)
                                <li class="single"><img src="{{asset('assets/landlord/frontend/img/icon/check.svg')}}" class="icon" alt="image">
                                      {{__(str_replace('_', ' ',ucfirst($item->feature_name))) ?? ''}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{global_asset('assets/common/js/toastr.min.js')}}"></script>
        <x-unique-domain-checker :name="'custom_subdomain'"/>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function ($) {

                $(document).on('click', '#order_pkg_btn', function () {
                    var name = $("#order_name").val()
                    var email = $("#order_email").val()
                    sessionStorage.pkg_user_name = name;
                    sessionStorage.pkg_user_email = email;
                })

                $(document).on('click', '#login_btn', function (e) {
                    e.preventDefault();
                    var formContainer = $('#login_form_order_page');
                    var el = $(this);
                    var username = formContainer.find('input[name="username"]').val();
                    var password = formContainer.find('input[name="password"]').val();
                    var remember = formContainer.find('input[name="remember"]').val();

                    el.text('{{__("Please Wait")}}');

                    $.ajax({
                        type: 'post',
                        url: "{{route('landlord.user.ajax.login')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            username: username,
                            password: password,
                            remember: remember,
                        },
                        success: function (data) {
                            if (data.status == 'invalid') {
                                el.text('{{__("Login")}}')
                                formContainer.find('.error-wrap').html('<div class="alert alert-danger">' + data.msg + '</div>');
                            } else {
                                formContainer.find('.error-wrap').html('');
                                el.text('{{__("Login Success.. Redirecting ..")}}');
                                location.reload();
                            }
                        },
                        error: function (data) {
                            var response = data.responseJSON.errors
                            formContainer.find('.error-wrap').html('<ul class="alert alert-danger"></ul>');
                            $.each(response, function (value, index) {
                                formContainer.find('.error-wrap ul').append('<li>' + index + '</li>');
                            });
                            el.text('{{__("Login")}}');
                        }
                    });
                });

                var defaulGateway = $('#site_global_payment_gateway').val();
                $('.payment-gateway-list ul li[data-gateway="' + defaulGateway + '"]').addClass('selected');

                $(document).on('click', '.payment-gateway-list > li', function (e) {
                    e.preventDefault();
                    let gateway = $(this).data('gateway');
                    $('#slected_gateway_from_helper').val(gateway)

                    if (gateway === 'manual_payment') {
                        $('.manual_payment_transaction_field').removeClass('d-none');
                    } else {
                        $('.manual_payment_transaction_field').addClass('d-none');
                    }

                    $(this).addClass('selected').siblings().removeClass('selected');
                    $('.payment-gateway-list').find(('input')).val($(this).data('gateway'));
                    $('.payment_gateway_passing_clicking_name').val(gateway);
                });

                $(document).on('change', '#guest_logout', function (e) {
                    e.preventDefault();
                    var infoTab = $('#nav-profile-tab');
                    var nextBtn = $('.next-step-button');
                    if ($(this).is(':checked')) {
                        $('.login-form').hide();
                        infoTab.attr('disabled', false).removeClass('disabled');
                        nextBtn.show();
                    } else {
                        $('.login-form').show();
                        infoTab.attr('disabled', true).addClass('disabled');
                        nextBtn.hide();
                    }
                });

                $(document).on('click', '.next-step-button', function (e) {
                    var infoTab = $('#nav-profile-tab');
                    infoTab.attr('disabled', false).removeClass('disabled').addClass('active').siblings().removeClass('active');
                    $('#nav-profile').addClass('show active').siblings().removeClass('show active');
                });

                let custom_subdomain_wrapper = $('.custom_subdomain_wrapper');
                custom_subdomain_wrapper.hide();
                $(document).on('change', '#subdomain', function (e){
                    let el = $(this);
                    let subdomain_type = el.val();
                    let theme_container = $('.theme_container');

                    console.log(el.val());
                    if(subdomain_type == 'custom_domain__dd')
                    {
                        theme_container.fadeIn(500);
                        custom_subdomain_wrapper.slideDown();
                        custom_subdomain_wrapper.find('#custom-subdomain').attr('name', 'custom_subdomain');

                    } else {
                        custom_subdomain_wrapper.slideUp();
                        custom_subdomain_wrapper.removeAttr('#custom-subdomain').attr('name', 'custom_subdomain');
                        theme_container.fadeOut(500);
                        theme_container.find('input[name="theme_slug"]').val('');
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        $(document).on('click', '.theme-wrapper', function (e){
            let el = $(this);
            let theme_slug = el.data('theme');

            $('.theme_slug').val(theme_slug)

            $('.theme-wrapper').removeClass('selected_theme');
            el.addClass('selected_theme');

            let text = '<h4 class="selected_text"><i class="las la-check-circle"></i></h4>';
            $('.selected_text').remove();
            el.append(text);

            $('input#theme-slug').val(theme_slug);
            $('p.modal_theme').find('span').text(theme_name);
        });


        let from_tenant_admin_log_id = '{{ request()->get('log_id') }}';
        let from_tenant_admin_gateway = '{{ request()->get('gateway') }}';
        if(from_tenant_admin_log_id != '' && from_tenant_admin_gateway != ''){
              $('.order_page_form').trigger('submit');
        }

    </script>
@endsection
