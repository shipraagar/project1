@extends('tenant.frontend.user.dashboard.user-master')
@section('page-title')
 {{__('User Dashboard')}}
@endsection

@section('title')
    {{__('User Dashboard')}}
@endsection


@section('section')
    <div class="row">
        <div class="col-xl-6 col-md-6 orders-child">
            <div class="single-orders">
                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> {{$total_donation ?? ''}} </h2>
                        <span class="order-para">{{__('Total Donation')}} </span>
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
                        <h2 class="order-titles"> {{$total_product ?? ''}} </h2>
                        <span class="order-para">{{__('Total Product')}} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 orders-child mt-4">
            <div class="single-orders">

                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> {{ $total_event}} </h2>
                        <span class="order-para">{{__('Total Events')}} </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 orders-child mt-4">
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

        <div class="col-xl-6 col-md-6 orders-child mt-4">
            <div class="single-orders">

                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> {{$job_applications ?? ''}} </h2>
                        <span class="order-para">{{__('Applied Jobs')}} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-5">
            <h4 class="mb-3 text-uppercase text-center">{{__('Recent Product Orders')}}</h4>
                <div class="payment">
                    <table class="table table-responsive table-bordered recent_payment_table">
                        <thead>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Product Name')}}</th>
                        <th>{{__('Qty')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Date')}}</th>
                        </thead>
                        <tbody class="w-100">
                        @foreach($recent_logs as $key=> $data)
                            <tr>
                                <td>{{$key +1}}</td>
                                <td>{{$data->package_name}}</td>
                                <td>{{$data->package_name}}</td>
                                <td>{{ amount_with_currency_symbol($data->package_price) }}</td>
                                <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
          </div>
        </div>
@endsection





