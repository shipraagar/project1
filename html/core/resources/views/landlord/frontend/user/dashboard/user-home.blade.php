@extends('landlord.frontend.user.dashboard.user-master')
@section('page-title')
    {{__('User Home')}}
@endsection

@section('title')
    {{__('User Home')}}
@endsection

@section('style')
    <style>
        .badge{
            font-size: 15px;
        }
    </style>
@endsection

@section('section')
    @php
        $auth_user = Auth::guard('web')->user();
    @endphp
    <div class="row g-4">
        <div class="col-md-12">
            @if($auth_user->domains->isNotEmpty())
                <div class="btn-wrapper mb-3 mt-2 d-flex justify-content-between" >
                    <a href="{{tenant_url_with_protocol($auth_user->subdomain) .'.'. getenv('CENTRAL_DOMAIN') ?? ''  }}"
                       class="btn btn-info mx-2" target="_blank">{{__('Go to your site')}}</a>
                    <a href="{{tenant_url_with_protocol($auth_user->subdomain).'.'. getenv('CENTRAL_DOMAIN') .'/admin' ?? '' }}"
                       class="btn btn-primary" target="_blank">{{__('Go to your admin panel')}}</a>
                </div>
            @else
                <div class="btn-wrapper mb-3 mt-2 float-right" >
                    @php
                        $price_page = get_page_slug(get_static_option('pricing_plan'));
                    @endphp
                    <a href="{{url($price_page)}}" class="btn btn-success mx-2">{{__('Create a website')}}</a>
                </div>
            @endif
        </div>

        <div class="col-xl-6 col-md-6 orders-child">
            <div class="single-orders">

                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> {{$package_orders ?? ''}} </h2>
                        <span class="order-para">{{__('Total Orders')}} </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 orders-child">
            <div class="single-orders">

                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> {{$support_tickets ?? ''}} </h2>
                        <span class="order-para">{{__('Support Tickets')}} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-5">
            <div class="subdomains mb-5">
                <h4 class="mb-3 text-uppercase text-center">{{__('Your Subdomains')}}</h4>
                <div class="payment">
                    <table class="table table-responsive table-bordered recent_payment_table">
                        <thead>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Site')}}</th>
                        <th>{{__('Admin Panel')}}</th>
                        </thead>
                        <tbody class="w-100">
                        @php
                            $user = Auth::guard('web')->user();
                        @endphp

                        @foreach($user->tenant_details ?? [] as $key => $data)
                            <tr>
                                <td>{{$key +1}}</td>
                                <td>
                                    <a class="badge rounded-pill bg-primary px-4" href="{{tenant_url_with_protocol(optional($data->domain)->domain)}}">{{__('Go to your Website')}}
                                        <br> <small class="mt-4">({{$data->domain?->domain}})</small>
                                    </a>
                                </td>
                                <td>
                                    <a class="badge rounded-pill bg-danger px-4" href="{{tenant_url_with_protocol(optional($data->domain)->domain).'/admin'}}">
                                        {{__('Go to your website admin panel')}}
                                        <br> <small class="mt-4">({{$data->domain?->domain}})</small>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h4 class="mb-3 text-uppercase text-center">{{__('Recent Orders')}}</h4>
            <div class="payment">
                <table class="table table-responsive table-bordered recent_payment_table">
                    <thead>
                    <th>{{__('ID')}}</th>
                    <th>{{__('Package Name')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('Expire Date')}}</th>
                    <th>{{__('Order Status')}}</th>
                   <th>{{__('Renew Taken')}}</th>


                    </thead>
                    <tbody class="w-100">
                    @foreach($recent_logs as $key=> $data)
                        <tr>
                            <td>{{$key +1}}</td>
                            <td>{{$data->package_name}}</td>
                            <td>{{ amount_with_currency_symbol($data->package_price) }}</td>
                            <td>{{date('d-m-Y', strtotime($data->start_date))}}</td>

                            <td>
                                @if(!empty($data->expire_date))
                                    {{ date('d-m-Y', strtotime($data->expire_date))  }}
                                @endif
                                @if(!empty($data->trial_expire_date) && $data->status == 'trial')
                                    {{date('d-m-Y', strtotime($data->trial_expire_date))}}
                                @endif
                            </td>

                            <td>{{$data->status}}</td>
                            <td>{{$data->renew_status}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection





