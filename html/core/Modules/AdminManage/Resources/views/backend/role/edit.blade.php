@extends('backend.admin-master')
@section('site-title')
    {{__('Edit Role')}}
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30 data-permission-list" data-permission-roles="{{ json_encode($rolePermissions) }}">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Role')}}</h4>
                            <div class="btn-wrapper">
                                <a href="{{route('admin.all.admin.role')}}" class="btn btn-info">{{__('All Roles')}}</a>
                            </div>
                        </div>
                        <x-msg.error/>
                        <x-msg.success/>
                        <form action="{{route('admin.user.role.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$role->id}}">
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control"  value="{{$role->name}}" name="name" placeholder="{{__('Enter name')}}">
                            </div>
                            <button type="button" class="btn btn-xs mb-4 btn-outline-dark checked_all">{{__('Check All')}}</button>
                            <div class="row checkbox-wrapper">
                                @foreach($permissions as $key => $permission_value)
                                    <h5 class="d-flex gap-4">
                                        <div>{{ ucwords($key) }}</div>
                                    </h5>
                                    <br>
                                    @foreach($permission_value as $permission)
                                        <div class="col-lg-2 col-md-3">
                                            <div class="form-group d-flex gap-2">
                                                <label>
                                                    <strong>{{ucfirst(str_replace('-',' ',$permission->name))}}</strong>
                                                </label>

                                                <div class="vendor-coupon-switch">
                                                    <input class="custom-switch permisssion-switch-{{$permission->id}}" type="checkbox" id="permisssion-switch-{{$permission->id}}" name="permission[]"  value="{{$permission->id}}" />
                                                    <label class="switch-label permisssion-switch-{{$permission->id}}" for="permisssion-switch-{{$permission->id}}"></label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <br>
                                    <br>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
           "use strict";

           $(document).on('click','.checked_all',function (){
              var allCheckbox =  $('.checkbox-wrapper input[type="checkbox"]');
              $.each(allCheckbox,function (index,value){
                  if ($(this).is(':checked')){
                      $(this).prop('checked',false);
                  }else{
                      $(this).prop('checked',true);
                  }
              });
           });
        });

        active_roles();

        function active_roles(){
            let bulk_permission_ids = JSON.parse($("div.data-permission-list").attr("data-permission-roles"));
            bulk_permission_ids = Object.values(bulk_permission_ids);

            for(let i = 0;i < bulk_permission_ids.length;i++){
                $("label.permisssion-switch-" + bulk_permission_ids[i]).trigger('click');
            }
        }

        $(document).on("change", ".bulk-permission-input" ,function (){
            let bulk_permission_ids = JSON.parse($(this).attr("data-bulk-permission-ids"));

            for(let i = 0;i < bulk_permission_ids.length;i++){
                $("label.permisssion-switch-" + bulk_permission_ids[i]).trigger('click');
            }
        });
    </script>
@endsection
