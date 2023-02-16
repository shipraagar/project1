@php
    $route_name ='landlord';
@endphp

@extends($route_name.'.admin.admin-master')

@section('title')
    {{__('User Details')}}
@endsection

@section('style')
    <style>
        .user_details ul li{
            list-style-type: none;
            margin-top: 15px;
        }
    </style>
    <x-datatable.css/>
    <x-summernote.css/>
@endsection

@section('content')

    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="d-flex justify-content-between">{{__('User Details : ') . $user->name ?? ''}}
                    <a href="{{route('landlord.admin.tenant')}}" class="btn btn-primary btn-sm my-2" >{{__('Go Back')}}</a>
                </h4>
            </div>
            <div class="card-body user_details">

                <x-error-msg/>
                <x-flash-msg/>

                <div class="row">
                    <div class="col-lg-3">
                        <ul>
                            <li><strong>{{__('Name : ')}}</strong> {{$user->name}}</li>
                            <li><strong>{{__('Email : ')}}</strong> {{$user->email}}</li>
                            <li><strong>{{__('Username : ')}}</strong> {{$user->username}}</li>
                            <li>
                                @php
                                    $markup = '';
                                    $li = '';
                                    $i = 0;
                                    foreach($user->tenant_details ?? [] as $tenant)
                                        {
                                            $li .= '<li class="mb-2">';
                                            $li .= '<span>'.++$i.'. </span>';
                                            $li .= '<a href="'.tenant_url_with_protocol(optional($tenant->domain)->domain).'">'.$tenant->id . '.'. getenv('CENTRAL_DOMAIN').'</a>';
                                            $li .= '</li>';
                                        }
                                    $markup = '<ul>'.$li.'</ul>';
                                @endphp

                                <strong>{{__('Subdomains : ')}}</strong>
                                <a href="#" data-bs-target="#all-site-domain" data-bs-toggle="modal" id="view-button" data-markup="{{$markup}}"><small>{{__('(Click to view all site)') }}</small></a>

                                <x-modal.markup :target="'all-site-domain'" :title="'User Site List'"/>
                            </li>
                            </span>
                            <li><strong>{{__('Mobile : ')}}</strong> {{$user->mobile}}</li>
                            <li><strong>{{__('Company : ')}}</strong> {{$user->company}}</li>
                            <li><strong>{{__('Address : ')}}</strong> {{$user->address}}</li>
                            <li><strong>{{__('City : ')}}</strong> {{$user->city}}</li>
                            <li><strong>{{__('State : ')}}</strong> {{$user->state}}</li>
                            <li><strong>{{__('Country : ')}}</strong> {{$user->country}}</li>
                        </ul>
                    </div>
                    <div class="col-lg-9">
                        <h3 class="title my-3">{{__('Package Information')}}</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <th>{{__('SL#')}}</th>
                                <th>{{__('Package Info')}}</th>
                                <th>{{__('Subscription Period')}}</th>
                                <th>{{__('Subdomain')}}</th>
                                <th>{{__('Renew Taken')}}</th>
                                <th>{{__('Action')}}</th>
                                </thead>

                                <tbody>

                                @foreach($user->tenant_details ?? [] as $key => $tenant)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>
                                            @php
                                                $colors = ['info','success','primary','dark','danger'];
                                            @endphp

                                            <span class="d-block mb-2"><span>{{__('Package Name:')}}</span>
                                                <span class="badge badge-{{$colors[$key % count($colors)]}}">
                                                    {{optional($tenant->payment_log)->package_name ?? __('Trial')}}
                                                </span>
                                            </span>

                                            <span class="d-block mb-2"><span>{{__('Package Type')}}</span> : {{ \App\Enums\PricePlanTypEnums::getText(optional(optional($tenant->payment_log)->package)->type) }}</span>
                                            <span class="d-block mb-2"><span>{{__('Package Price')}}</span> : {{amount_with_currency_symbol(optional(optional($tenant->payment_log)->package)->price)}}</span>
                                            <span class="d-block mb-2"><span>{{__('Order Status')}}</span> :

                                                @if(optional($tenant->payment_log)->status == 'trial')
                                                    <span class="text-danger">{{ __('Trial') }}</span>
                                                @elseif(optional($tenant->payment_log)->status == 'complete')
                                                    <span class="text-primary">{{ __('Active Subscription') }}</span>
                                                @else
                                                    <span class="text-primary">{{ __('Pending') }}</span>
                                                @endif


                                            </span>
                                        </td>

                                        <td>
                                            <span class="d-block mb-2"><span>{{__('Start Date:')}}</span> {{date('d-m-Y',strtotime($tenant->start_date))}}</span>
                                            <span class="d-block mb-2"><span>{{__('End Date:')}}</span> {{$tenant?->expire_date != null ? date('d-m-Y',strtotime($tenant->expire_date)) : __('Lifetime')}}</span>

                                            <span class="d-block mb-2">

                                                @php
                                                    if ($tenant->expire_date != null)
                                                    {
                                                        $status = get_price_plan_expire_status($tenant->expire_date);
                                                    }
                                                    else
                                                    {
                                                        $log = $tenant?->payment_log?->status;
                                                        $status = $log == 'trial' ? 'trial' : 'active';
                                                    }


                                                    $class = ['active' => 'text-success', 'expired' => 'text-danger', 'pending' => 'text-warning', 'trial' => 'text-info'];
                                                @endphp

                                                <span class="{{$class[$status]}} text-capitalize">

                                                        <span>{{__('Status:')}}</span>
                                                        @if($status != 'active' && $status != 'expired')
                                                        @if($status == 'trial')
                                                            {{$status}}
                                                        @else
                                                            {{__('Pending')}}
                                                        @endif
                                                    @else
                                                        {{$status}}
                                                    @endif
                                                </span>
                                            </span>

                                        </td>
                                        <td>
                                            @if(!empty($tenant->domain))
                                                <a href="{{tenant_url_with_protocol(optional($tenant->domain)->domain)}}" target="_blank">{{$tenant->id . '.'. getenv('CENTRAL_DOMAIN')}}</a>
                                            @else
                                                <a href="{{tenant_url_with_protocol(optional($tenant->domain)->domain)}}" target="_blank">{{$tenant->id . '.'. getenv('CENTRAL_DOMAIN')}}</a>
                                                <br>
                                                <small class="text-danger mt-2">{{__('Database and domain not generated yet')}}</small>

                                                    <br><br>

                                                    <form action="{{route('landlord.admin.failed.domain.generate')}}" method="post">
                                                        <input type="hidden" name="id" value="{{optional($tenant->issue)->id}}">
                                                        @csrf
                                                        <button type="submit"class="btn btn-info btn-sm">{{__('Generate domain & database')}}</button>
                                                    </form>
                                            @endif
                                        </td>
                                        <td>{{$tenant->renew_status ?? 0}}</td>
                                        <td>
                                            <x-delete-popover permissions="domain-delete" url="{{route(route_prefix().'admin.tenant.domain.delete', $tenant->id)}}"/>
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
    </div>


    <x-modal.markup :target="'account_manage_modal'" :title="'Change Tenant Account Status'">
        <form action="{{route('landlord.admin.tenant.account.status')}}" method="POST">
            @csrf
            <input type="hidden" name="payment_log_id" value="">
            <div class="form-group">
                <label for="change_account_status">{{__('Change Account Status')}}</label>
                <select class="form-control" name="account_status" id="change_account_status">
                    <option value="pending">Pending</option>
                    <option value="complete">Complete</option>
                    <option value="cancel">Cancel</option>
                </select>
            </div>

            <div class="form-group">
                <label for="change_account_status">{{__('Change Payment Status')}}</label>
                <select class="form-control" name="payment_status" id="change_payment_status">
                    <option value="pending">{{__("Pending")}}</option>
                    <option value="complete">{{__("Complete")}}</option>
                    <option value="cancel">{{__("Cancel")}}</option>
                </select>
            </div>

            <div class="form-group float-end">
                <button class="btn btn-success" type="submit">{{__('Update')}}</button>
            </div>
        </form>
    </x-modal.markup>
@endsection

@section('scripts')
    <x-datatable.js/>
    <x-summernote.js/>

    <script>
        $(function (){
            $(document).on('click', '#view-button', function (e){
                let list = $(this).data('markup');

                $('#all-site-domain').find('.modal-body').html('');
                $('#all-site-domain').find('.modal-body').append(list);
            });

            $(document).on('click', '.account_manage_button', function (e){
                let el = $(this);
                let id = el.data('id');
                let account = el.data('account');
                let payment = el.data('payment');

                let modal = $('#account_manage_modal').find('.modal-body');
                modal.find('input[name=payment_log_id]').val(id);

                modal.find('#change_account_status option[value='+account+']').prop('selected', true);
                modal.find('#change_payment_status option[value='+payment+']').prop('selected', true);
            });
        });
    </script>
@endsection

