@extends('landlord.frontend.user.dashboard.user-master')
@section('title')
   {{__('Payment Logs')}}
@endsection

@section('page-title')
    {{__('Payment Logs')}}
@endsection

@section('section')
    @if(count($package_orders) > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">{{__('Package Order Info')}}</th>
                    <th scope="col">{{__('Payment Status')}}</th>
                    <th scope="col">{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($package_orders as $data)
                    <tr>
                        <td>
                            <div class="user-dahsboard-order-info-wrap">
                                <h5 class="title">{{$data->package_name}}</h5>
                                <div class="div">
                                    <small class="d-block"><strong>{{__('Order ID')}} : </strong> #{{$data->id}}</small>
                                    <small class="d-block"><strong>{{__('Package Price')}} : </strong> {{amount_with_currency_symbol($data->package_price)}}</small>
                                    <small class="d-block"><strong>{{__('Payment Gateway')}} : </strong> {{ $data->package_gateway }}</small>

                                    <small class="d-block mb-2"><strong>{{__('Domain')}} : <span class="text-primary">{{$data->tenant_id .'.'. env('CENTRAL_DOMAIN') }}</span></strong>
                                    <small class="d-block"><strong>{{__('Order Status')}} : </strong>
                                        @if($data->status == 'pending')
                                            <span class="alert alert-warning text-capitalize alert-sm alert-small">{{__($data->status )}}</span>
                                        @elseif($data->status == 'cancel')
                                            <span class="alert alert-danger text-capitalize alert-sm alert-small">{{__($data->status)}}</span>
                                        @elseif($data->status == 'in_progress')
                                            <span class="alert alert-info text-capitalize alert-sm alert-small">{{str_replace('_',' ',$data->status)}}</span>
                                        @else
                                            <span class="alert alert-success text-capitalize alert-sm alert-small">{{$data->status }}</span>
                                        @endif
                                    </small>

                                    <small class="d-block"><strong>{{__('Start Date:')}}</strong> {{date('d-m-Y',strtotime($data->start_date))}}</small>
                                    @if($data->status != 'trial')
                                      <small class="d-block"><strong>{{__('Expire Date:')}}</strong> {{date('d-m-Y',strtotime($data->expire_date)) ?? 'lifetime'}}</small>
                                    @endif
                                    @if($data->status == 'trial')
                                        <small class="d-block"><strong>{{__('Trial Expire Date:')}}</strong> {{date('d-m-Y',strtotime($data->trial_expire_date))}}</small>
                                    @endif
                                    <small class="d-block"><strong>{{__('Renew Taken :')}}</strong> {{ $data->renew_status ?? 0 }}</small>

                                    @if($data->payment_status == 'complete' && $data->status != 'trial')
                                        <form action="{{route(route_prefix().'frontend.package.invoice.generate')}}"  method="post">
                                            @csrf
                                            <input type="hidden" name="id" id="invoice_generate_order_field" value="{{$data->id}}">
                                            <button class="btn btn-secondary btn-xs btn-small margin-top-10" type="submit">{{__('Invoice')}}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="user-dahsboard-status-info-wrap">
                            @if($data->payment_status != 'complete' && $data->status != 'cancel')

                                <span class="alert alert-warning text-capitalize alert-sm">{{$data->payment_status}}</span>
                                <a href="{{route('landlord.frontend.plan.order',$data->package_id) . '?log_id='.$data->id.''}}" class="btn btn-success btn-sm">{{__('Pay Now')}}</a>

                                @if($data->status != 'trial' )
                                <form action="{{route(route_prefix().'user.dashboard.package.order.cancel')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$data->id}}">
                                    <button type="submit" class="btn btn-danger btn-sm margin-top-10">{{__('Cancel')}}</button>
                                </form>
                                 @endif
                            @else
                                <span class="alert alert-success text-capitalize alert-sm d-inline-block">{{$data->payment_status}}</span>
                            @endif
                        </td>

                        <td>
                            @if($data->status != 'trial' )
                                <a href="" data-bs-toggle="modal" data-bs-target="#renew_payment_form"
                                   class="btn btn-info btn-sm renew_btn"
                                   target="_blank"
                                   data-log_id = "{{$data->id}}"
                                   data-package_id = "{{$data->package_id}}"
                                >{{__('Renew Now')}}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="blog-pagination">
            {{ $package_orders->links() }}
        </div>
    @else
        <div class="alert alert-warning">{{__('No Order Found')}}</div>
    @endif

    <div class="modal fade" id="renew_payment_form" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Select Payment Gateway')}}</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-bs-dismiss="modal">X</button>
                </div>

                <div class="modal-body">
                    <form action="{{route('landlord.user.package.renew.process')}}" method="post" target="_blank">
                        @csrf

                        <input type="hidden" name="package_id" class="order_package_id">
                        <input type="hidden" name="log_id" class="order_log_id">

                        <select name="payment_gateway" class="form-control">
                            @foreach(\App\Models\PaymentGateway::all() as $gateway)
                                @break($gateway->name == 'manual_payment')
                                <option value="{{$gateway->name}}">{{ str_replace('_', ' ', ucfirst($gateway->name)) }}</option>
                            @endforeach
                        </select>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm renew_modal">{{__('Go To Payment')}}</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('.close-bars, .body-overlay').on('click', function() {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').removeClass('active');
        });
        $('.sidebar-icon').on('click', function() {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').addClass('active');
        });

        $(document).on('click','.renew_btn',function(){
            $('.order_package_id').val($(this).data('package_id'));
            $('.order_log_id').val($(this).data('log_id'));
        });
    </script>
@endsection
