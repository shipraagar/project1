@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Create Price Plan')}}
@endsection

@section('style')
    <style>
        .all-field-wrap .action-wrap {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #f2f2f2;
            height: 100%;
            width: 60px;
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .f_desc {
            height: 100px;
        }
    </style>
@endsection

@section('content')
    @php
        $lang_slug = request()->get('lang') ?? \App\Facades\GlobalLanguage::default_slug();
        $features = ['dashboard','admin','user','brand','custom_domain','testimonial','form_builder','own_order_manage','appearance_settings','general_settings',
        'language','page','blog','service','donation','job','event','support_ticket','knowledgebase','faq','gallery','video','portfolio','eCommerce','storage','advertisement'];
    @endphp

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <x-admin.header-wrapper>
                    <x-slot name="left">
                        <h4 class="card-title mb-5">{{__('Create Price Plan')}}</h4>
                    </x-slot>
                    <x-slot name="right" class="d-flex">
                        <form action="{{route(route_prefix().'admin.price.plan.create')}}" method="get">
                            <x-fields.select name="lang" title="{{__('Language')}}">
                                @foreach(\App\Facades\GlobalLanguage::all_languages() as $lang)
                                    <option value="{{$lang->slug}}"
                                            @if($lang->slug === $lang_slug) selected @endif>{{$lang->name}}</option>
                                @endforeach
                            </x-fields.select>
                        </form>
                        <p></p>
                        <x-link-with-popover url="{{route(route_prefix().'admin.price.plan')}}" extraclass="ml-3">
                            {{__('All Price Plan')}}
                        </x-link-with-popover>
                    </x-slot>
                </x-admin.header-wrapper>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route(route_prefix().'admin.price.plan.create')}}">
                    @csrf

                    <x-fields.input type="hidden" name="lang" value="{{$lang_slug}}"/>
                    <x-fields.input name="title" label="{{__('Title')}}"/>
                    <x-fields.input name="subtitle" label="{{__('Subtitle')}}"/>

                    @if(!tenant())
                        <div class="form-group landlord_price_plan_feature">
                            <h4>{{__('Select Features')}}</h4>
                            <div class="feature-section">
                                <ul>
                                    @foreach($features as $key => $feat)
                                        <li class="d-inline">
                                            <input type="checkbox" name="features[]"
                                                   id="{{$key}}" class="exampleCheck1" value="{{$feat}}"
                                                   data-feature="{{$feat}}">
                                            <label class="ml-1" for="{{$key}}">
                                                @if($feat != 'e_commerce')
                                                    {{__(str_replace('_', ' ', ucfirst($feat)))}}
                                                @else
                                                    {{__(str_replace('_', '-', ucfirst($feat)))}}
                                                @endif
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group ecommerce_data">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                                                type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{__('Product')}}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button"
                                                role="tab" aria-controls="profile-tab-pane" aria-selected="false">{{__('Inventory')}}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                aria-controls="contact-tab-pane" aria-selected="false">{{__('Campaigns')}}</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                                        <div class="extra my-3 product_section_parent">
                                            <x-fields.switcher name="ecommerce_permission[]" class="product_section_parent_switcher" dataValue="product" label="{{__('Enable/Disable Product Permission')}}"/>
                                        </div>

                                        <div class="product_section_child">
                                            <x-fields.input type="text" name="product_create_permission" label="{{__('Product Create Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="product_simple_search_permission" label="{{__('Enable/Disable Product Simple Search Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="product_advance_search_permission" label="{{__('Enable/Disable Product Advance Search Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="product_duplication_permission" label="{{__('Enable/Disable Product Duplication Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="product_bulk_delete_permission" label="{{__('Enable/Disable Product Bulk Delete Permission')}}"/>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                                        <div class="extra my-3 inventory_section_parent">
                                            <x-fields.switcher name="ecommerce_permission[]" class="inventory_section_parent_switcher" dataValue="inventory" label="{{__('Enable/Disable Inventory Permission')}}"/>
                                        </div>

                                        <div class="inventory_section_child">
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="inventory_update_product_permission" label="{{__('Enable/Disable Inventory Update Product Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="inventory_simple_search_permission" label="{{__('Enable/Disable Inventory Simple Search Permission')}}"/>
                                            <x-fields.switcher name="ecommerce_permission[]" dataValue="inventory_advance_search_permission" label="{{__('Enable/Disable Inventory Advance Search Permission')}}"/>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

                                        <div class="extra my-3 campaign_section_parent">
                                            <x-fields.switcher name="ecommerce_permission[]" class="campaign_section_parent_switcher" dataValue="campaign" label="{{__('Enable/Disable Campaign Permission')}}"/>
                                        </div>

                                        <div class="campaign_section_child">
                                            <x-fields.input type="text" name="campaign_create_permission" label="{{__('Campaign Create Permission')}}"/>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group blog_permission_box"></div>
                        <div class="form-group product_permission_box"></div>

                        <div class="form-group page_permission_box"></div>
                        <div class="form-group service_permission_box"></div>
                        <div class="form-group donation_permission_box"></div>
                        <div class="form-group job_permission_box"></div>
                        <div class="form-group event_permission_box"></div>
                        <div class="form-group knowledgebase_permission_box"></div>
                        <div class="form-group portfolio_permission_box"></div>
                        <div class="form-group storage_permission_box"></div>




                        <x-fields.select name="type" class="package_type" title="{{__('Type')}}">
                            <option value="">{{__('Select')}}</option>
                            <option value="0">{{__('Monthly')}}</option>
                            <option value="1">{{__('Yearly')}}</option>
                            <option value="2">{{__('Lifetime')}}</option>
                        </x-fields.select>

                        <div class="d-flex justify-content-start">
                            <x-fields.switcher name="has_trial" label="{{__('Free Trial')}}"/>

                            <div class="form-group trial_date_box mx-4">
                                <label for="">{{__('Trial Days')}}</label>
                                <input type="number" class="form-control" name="trial_days" placeholder="Days..">
                            </div>
                        </div>
                    @endif

                    <div class="zero_price_container">
                        <x-fields.switcher name="zero_price" label="{{__('Zero Price')}}"/>
                    </div>

                    <div class="price_container">
                        <x-fields.input type="number" name="price" label="{{__('Price')}}"/>
                    </div>

                    <x-fields.select name="status" title="{{__('Status')}}">
                        <option value="1">{{__('Publish')}}</option>
                        <option value="0">{{__('Draft')}}</option>
                    </x-fields.select>

                    @if(!tenant())
                        <div class="iconbox-repeater-wrapper">
                            <div class="all-field-wrap">
                                <div class="form-group">
                                    <label for="faq">{{__('Faq Title')}}</label>
                                    <input type="text" name="faq[title][]" class="form-control"
                                           placeholder="{{__('faq title')}}">
                                </div>
                                <div class="form-group">
                                    <label for="faq_desc">{{__('Faq Description')}}</label>
                                    <textarea name="faq[description][]" class="form-control f_desc"
                                              placeholder="{{__('faq description')}}"></textarea>
                                </div>
                                <div class="action-wrap">
                                    <span class="add"><i class="las la-plus"></i></span>
                                    <span class="remove"><i class="las la-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-gradient-primary me-2 mt-5">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        //Date Picker
        flatpickr('.date', {
            enableTime: false,
            dateFormat: "d-m-Y",
            minDate: "today"
        });


        $(document).on('change', 'input[name=zero_price]', function (e){
            let el = $(this);
            if(el.prop('checked') == true){
                $('.price_container').fadeOut(500);
                $('.price_container').find('input[name="price"]').val('0');
             }else{
                $('.price_container').find('input[name="price"]').val('');
                $('.price_container').fadeIn(500);
            }
        });


        $(document).on('change', 'select[name="lang"]', function (e) {
            $(this).closest('form').trigger('submit');
            $('input[name="lang"]').val($(this).val());
        });

        $('.trial_date_box').hide();
        $(document).on('change', 'input[name=has_trial]', function (e){
            $('.trial_date_box').toggle(500);
        });

        $(document).on('change', '.exampleCheck1', function (e) {
            let feature = $('.exampleCheck1').data('feature');
            let el = $(this).val();

            if (el == 'page') {
                var page = `<label for="">{{__('Page Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="page_permission_feature" value="">`;

                if (el == 'page' && this.checked) {
                    $('.page_permission_box').append(page).hide();
                    $('.page_permission_box').slideDown();
                } else {
                    $('.page_permission_box').slideUp().html('');
                }
            }


            if (el == 'blog') {
                var blog = `<label for="">{{__('Blog Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="blog_permission_feature" value="">`;

                if (el == 'blog' && this.checked) {
                    $('.blog_permission_box').append(blog).hide();
                    $('.blog_permission_box').slideDown();

                } else {
                    $('.blog_permission_box').slideUp().html('');
                }

            }


            if (el == 'service') {
                var service = `<label for="">{{__('Service Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="service_permission_feature"
                                   value="">`;

                if (el == 'service' && this.checked) {
                    $('.service_permission_box').append(service).hide();
                    $('.service_permission_box').slideDown();
                } else {
                    $('.service_permission_box').slideUp().html('');
                }
            }

            if (el == 'donation') {
                var donation = `<label for="">{{__('Donation Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="donation_permission_feature"
                                   value="">`;

                if (el == 'donation' && this.checked) {
                    $('.donation_permission_box').append(donation).hide();
                    $('.donation_permission_box').slideDown();
                } else {
                    $('.donation_permission_box').slideUp().html('');
                }
            }

            if (el == 'job') {
                var job = `<label for="">{{__('Job Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="job_permission_feature"
                                   value="">`;

                if (el == 'job' && this.checked) {
                    $('.job_permission_box').append(job).hide();
                    $('.job_permission_box').slideDown();
                } else {
                    $('.job_permission_box').slideUp().html('');
                }
            }

            if (el == 'event') {
                var event = `<label for="">{{__('Event Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="event_permission_feature"
                                   value="">`;

                if (el == 'event' && this.checked) {
                    $('.event_permission_box').append(event).hide();
                    $('.event_permission_box').slideDown();
                } else {
                    $('.event_permission_box').slideUp().html('');
                }
            }

            if (el == 'knowledgebase') {
                var knowledgebase = `<label for="">{{__('Knowledgebase Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="knowledgebase_permission_feature"
                                   value="">`;

                if (el == 'knowledgebase' && this.checked) {
                    $('.knowledgebase_permission_box').append(knowledgebase).hide();
                    $('.knowledgebase_permission_box').slideDown();
                } else {
                    $('.knowledgebase_permission_box').slideUp().html('');
                }
            }


            if (el == 'portfolio') {
                var portfolio = `<label for="">{{__('Portfolio Create Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="portfolio_permission_feature"value="">`;

                if (el == 'portfolio' && this.checked) {
                    $('.portfolio_permission_box').append(portfolio).hide();
                    $('.portfolio_permission_box').slideDown();
                } else {
                    $('.portfolio_permission_box').slideUp().html('');
                }
            }

            if (el == 'storage') {
                var storage = `<label for="">{{__('Storage Manage Permission')}}</label>
                            <input type="number" min="1" class="form-control" name="storage_permission_feature"value="">
                             <small class="text-primary">Storage will count as per (MB)</small>
                            `;

                if (el == 'storage' && this.checked) {
                    $('.storage_permission_box').append(storage).hide();
                    $('.storage_permission_box').slideDown();
                } else {
                    $('.storage_permission_box').slideUp().html('');
                }
            }


            if (el == 'eCommerce') {

                if (el == 'eCommerce' && this.checked) {
                    $('.ecommerce_data').removeClass('d-none');

                } else {
                    $('.ecommerce_data').addClass('d-none');

                }
            }




        });


    </script>
    <x-repeater/>


    <script>

            $('.ecommerce_data').addClass('d-none');



            $('.product_section_child').hide();
        $(document).on('change','.product_section_parent_switcher',function(){
            $('.product_section_child').toggle(500);
        });



       $('.inventory_section_child').hide();
        $(document).on('change','.inventory_section_parent_switcher',function(){
            $('.inventory_section_child').toggle(500);
        });



        $('.campaign_section_child').hide();
        $(document).on('change','.campaign_section_parent_switcher',function(){
            $('.campaign_section_child').toggle(500);
        });

    </script>
@endsection
