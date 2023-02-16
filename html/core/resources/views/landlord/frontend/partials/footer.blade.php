<footer>
    <div class="footerWrapper sectionBg2">
        <div class="footer-area footer-padding" >
            <div class="container">
                <div class="row justify-content-between">
                    {!! render_frontend_sidebar('footer',['column' => true]) !!}
                </div>
            </div>
        </div>
        <!-- footer-bottom area -->
        <div class="footer-bottom-area">
            <div class="footer-border">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-center">
                                <p class="pera wow fadeInUp" data-wow-delay="0.4s">
                                    {!! get_footer_copyright_text(\App\Facades\GlobalLanguage::default_slug()) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@if(get_static_option('mouse_cursor_effect_status'))
<div class="mouseCursor cursorOuter"></div>
<div class="mouseCursor cursorInner"></div>
<div class="progressParent">
    <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
@endif

<script src="{{global_asset('assets/common/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('assets/landlord/frontend/js/popper.min.js')}}"></script>
<script src="{{asset('assets/landlord/frontend/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/landlord/common/js/axios.min.js')}}"></script>
<script src="{{asset('assets/landlord/frontend/js/plugin.js')}}"></script>
<script src="{{asset('assets/landlord/frontend/js/main.js')}}"></script>
<script src="{{asset('assets/landlord/frontend/js/dynamic-script.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<x-custom-js.lang-change-landlord/>
<x-custom-js.landlord-newsletter-store/>
@yield('scripts')
</body>
</html>
