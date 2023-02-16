@extends('tenant.admin.admin-master')
@section('title') {{__('Main Page')}} @endsection

@section('content')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">

      @if(!empty($current_package))
            <div class="main">
                <div class="alert border-left border-primary text-white text-center bg-gradient-info">
                    <strong>{{__('Current Package :')}} </strong> {{$current_package->package_name}}
                    <span class="badge badge-warning text-dark">
                        {{ \App\Enums\PricePlanTypEnums::getText(optional($current_package->package)->type ) }}
                    </span>

                    @if(optional(tenant()->payment_log)->status == 'trial')
                        @php
                            $days = get_trial_days_left(tenant());
                        @endphp

                        <strong class="text-capitalize"> ( {{optional(tenant()->user?->payment_single_log)->status}} : {{$days ?? ''}} {{__('Days Left')}})</strong>
                    @else
                        <strong> ( {{__('Expire Date :')}} {{$current_package->expire_date ?? ''}})</strong>
                    @endif

                    <a class="btn btn-dark btn-sm pull-right" href="{{route('landlord.homepage') .'#price_plan_section'}}" target="_blank">{{__('Buy a Plan')}}</a>
                </div>

            </div>
      @endif
          <div class="card-body">
              <h4 class="card-title mb-5">{{__('Dashboard content')}}</h4>
                <div class="row">
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Page')}}<i class="las la-user-shield mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_page}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Admins')}}<i class="las la-user-shield mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_admin}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Users')}}<i class="las la-user-shield mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_user}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Blogs')}}<i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$all_blogs}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Services')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_services}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-primary card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Language')}}<i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_language}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-warning card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Brand')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_brand}}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Products')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_product}}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Campaign')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_campaign}}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Event')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_event}}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-primary card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Job')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_job}}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-warning card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{global_asset('assets/landlord/admin/images/circle.png')}}" class="card-img-absolute" alt="circle-image">
                                <h4 class="font-weight-normal mb-3">{{__('Total Article')}} <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$total_article}}</h2>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
