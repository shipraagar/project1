@extends(route_prefix().'admin.admin-master')
@section('title')
   {{__('My Payment Logs')}}
@endsection

@section('style')
    <x-datatable.css/>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-admin.header-wrapper>
                        <x-slot name="left">
                            <h4 class="card-title">{{__('Your Package Order Payment logs')}} {{__('(from main site)')}}</h4>
                        </x-slot>
                        <x-slot name="right" class="d-flex">
                            <x-link-with-popover url="{{route('landlord.homepage') .'#price_plan_section'}}" target="_blank">
                                {{__('Buy New Plan')}}
                            </x-link-with-popover>
                        </x-slot>

                        <x-error-msg/>
                        <x-flash-msg/>
                    </x-admin.header-wrapper>


                    <div class="table-wrap table-responsive">
                        <table class="table table-default table-striped table-bordered">
                            <thead class="text-white">
                            <tr>
                                <th scope="col">{{__('SL #')}}</th>
                                <th scope="col">{{__('Package Order Info')}}</th>
                                <th scope="col">{{__('Payment Status')}}</th>
                                <th scope="col">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($package_orders ?? [] as $key => $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>
                                        <div class="user-dahsboard-order-info-wrap">
                                            <h5 class="title">{{$data->package_name}}</h5>
                                            <div class="div">
                                                <small class="d-block"><strong>{{__('Order ID:')}}</strong> #{{$data->id}}</small>
                                                <small class="d-block"><strong >{{__('Domain:')}}</strong> <span class="text-primary">{{$data->tenant_id .'.'. env('CENTRAL_DOMAIN') }}</span></small>
                                                <small class="d-block"><strong>{{__('Package Price:')}}</strong> {{amount_with_currency_symbol($data->package_price)}}</small>
                                                <small class="d-block"><strong>{{__('Payment Gateway')}} : </strong> {{ $data->package_gateway ?? __('No Gateway') }}</small>
                                                <small class="d-block"><strong>{{__('Order Status:')}}</strong>
                                                    @if($data->status == 'pending')
                                                        <span class="alert alert-warning text-capitalize alert-sm alert-small customAlert2">{{__($data->status )}}</span>
                                                    @elseif($data->status == 'cancel')
                                                        <span class="alert alert-danger text-capitalize alert-sm alert-small customAlert2">{{__($data->status)}}</span>
                                                    @elseif($data->status == 'in_progress')
                                                        <span class="alert alert-info text-capitalize alert-sm alert-small customAlert2">{{str_replace('_',' ',$data->status)}}</span>
                                                    @else
                                                        <span class="alert alert-success text-capitalize alert-sm alert-small customAlert2">{{$data->status }}</span>
                                                    @endif
                                                </small>

                                                <small class="d-block"><strong>{{__('Order Date:')}}</strong> {{date_format($data->created_at,'D m Y')}}</small>
                                                <small class="d-block"><strong>{{__('Start Date:')}}</strong> {{$data->start_date ?? ''}}</small>
                                                <small class="d-block"><strong>{{__('Expire Date:')}}</strong>
                                                    @if(!empty($data->expire_date))
                                                        {{ date('d-m-Y', strtotime($data->expire_date))  }}
                                                    @endif
                                                    @if(!empty($data->trial_expire_date) && $data->status == 'trial')
                                                        {{date('d-m-Y', strtotime($data->trial_expire_date))}}
                                                    @endif
                                                </small>
                                                <small class="d-block"><strong>{{__('Renew Taken:')}}</strong> {{$data->renew_status}}</small>
                                                @if($data->payment_status == 'complete')
                                                    <form action="{{route(route_prefix().'my.package.invoice.generate')}}"  method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" id="invoice_generate_order_field" value="{{$data->id}}">
                                                        <button class="btn btn-success btn-xs btn-small margin-top-10" type="submit">{{__('Invoice')}}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="flexItems">
                                        @if($data->payment_status == 'pending' || $data->payment_status == null && $data->status != 'cancel')
                                            <span class="alert alert-warning text-capitalize alert-sm paymentBtn">{{$data->payment_status ?? __('Pending')}}</span>
                                            <a href="{{route('landlord.frontend.order.confirm',$data->package_id)}}" target="_blank" class="btn btn-success btn-sm mx-2">{{__('Pay Now')}}</a>
                                            <form action="{{route('tenant.admin.package.order.cancel')}}" method="post" class="">
                                                @csrf
                                                <input type="hidden" name="package_id" value="{{$data->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm my-2">{{__('Cancel')}}</button>
                                            </form>
                                        @else
                                            <span class="alert alert-success text-capitalize alert-sm" style="display: inline-block">{{$data->payment_status ?? __('Complete')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#renew_payment_form"
                                           class="btn btn-info btn-sm renew_btn"
                                           target="_blank"
                                           data-log_id = "{{$data->id}}"
                                           data-package_id = "{{$data->package_id}}"
                                        >{{__('Renew')}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="renew_payment_form" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Select Payment Gateway')}}</h5>
                    <button type="button" class="close btn btn-danger btn-sm" data-bs-dismiss="modal">X</button>
                </div>

                    <div class="modal-body">
                       <form action="{{route('tenant.admin.my.package.renew.process')}}" method="post" target="_blank">
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
    <x-datatable.js/>

    <script>
        $(document).on('click','.renew_btn',function(){
            $('.order_package_id').val($(this).data('package_id'));
            $('.order_log_id').val($(this).data('log_id'));
        });
    </script>

@endsection

