
@if(!empty(get_static_option('landlord_frontend_topbar_show_hide')))
<div class="header-top plr">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between flex-wrap align-items-center">
                    <div class="header-info-left">
                        <ul class="listing">
                            <li class="listItem"><i class="las la-phone icon"></i>{{get_static_option('topbar_phone')}}</li>
                            <li class="listItem"><i class="las la-envelope-open icon"></i>{{get_static_option('topbar_email')}}</li>
                        </ul>
                    </div>
                    <div class="header-info-right">
                        @if(!empty(get_static_option('landlord_frontend_language_show_hide')))
                            <x-language-change/>
                        @endif

                        <ul class="header-cart">
                            <li class="listItem"><a href="{{get_static_option('topbar_facessbook_url')}}" class="social"><i class="lab la-facebook-f icon"></i></a></li>
                            <li class="listItem"> <a href="{{get_static_option('topbar_instagram_url')}}" class="social"><i class="lab la-instagram icon"></i></a></li>
                            <li class="listItem"> <a href="{{get_static_option('topbar_linkedin_url')}}" class="social"><i class="lab la-linkedin-in icon"></i></a></li>
                            <li class="listItem"> <a href="{{get_static_option('topbar_twitter_url')}}" class="social"><i class="lab la-twitter icon"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
