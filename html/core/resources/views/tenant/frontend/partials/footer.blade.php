
<div class="modal product-quick-view-bg-color" id="product_quick_view" tabindex="-1" role="dialog" aria-labelledby="productModal"
     aria-hidden="true">
</div>



@include('tenant.frontend.partials.widget-area')

<div class="mouseCursor cursorOuter"></div>
<div class="mouseCursor cursorInner"></div>
<div class="progressParent">
    <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<script src="{{global_asset('assets/common/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/popper.min.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/bootstrap.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/plugin.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/main.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/loopcounter.js')}}"></script>
<script src="{{global_asset('assets/common/js/toastr.min.js')}}"></script>
<script src="{{global_asset('assets/landlord/common/js/sweetalert2.js')}}"></script>
<script src="{{global_asset('assets/common/js/star-rating.min.js')}}"></script>
<script src="{{global_asset('assets/common/js/md5.js')}}"></script>
<script src="{{global_asset('assets/common/js/jquery.syotimer.min.js')}}"></script>

<script src="{{global_asset('assets/tenant/frontend/themes/js/viewport.jquery.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/odometer.js')}}"></script>

<script src="{{global_asset('assets/common/js/nouislider-8.5.1.min.js')}}"></script>
<script src="{{global_asset('assets/common/js/CustomLoader.js')}}"></script>
<script src="{{global_asset('assets/common/js/CustomSweetAlertTwo.js')}}"></script>
<script src="{{global_asset('assets/common/js/SohanCustom.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/newspaper-main.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/construction-main.js')}}"></script>
<script src="{{global_asset('assets/tenant/frontend/themes/js/consultancy-main.js')}}"></script>

@if(!empty(tenant()->id))
    <script src="{{global_asset('assets/tenant/frontend/themes/js/dynamic-scripts/'.tenant()->id.'-script.js')}}"></script>
@endif

    <x-custom-js.newsletter-store/>
    <x-custom-js.tenant-newsletter-store/>
    <x-custom-js.query-submit/>
    <x-custom-js.contact-form-store/>
    <x-custom-js.lang-change/>
    <x-custom-js.advertisement/>


 {{--Module Js--}}
    <x-blog::frontend.custom-js.category-show/>
    <x-service::frontend.custom-js.category-show/>
    @include('product::frontend.js.general')
    @include('product::frontend.js.quick-view-js')
{{--Module Js--}}

@yield('scripts')
@yield('footer-scripts')

<script>

/*
========================================
  agency  counter Odometer
========================================
*/

    $(".single_counter__count").each(function() {
        $(this).isInViewport(function(status) {
            if (status === "entered") {
                for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
                    var el = document.querySelectorAll('.odometer')[i];
                    el.innerHTML = el.getAttribute("data-odometer-final");
                }
            }
        });
    });

    $(document).ready(function () {


       loopcounter('flash-countdown');
        dynamicLoopCounter('.campaign-countdown');

        function dynamicLoopCounter(className){
            // todo:: first we need to get length of this class
            if($(className).length > 1){
                // todo:: we need to create a unique class for each item
                let commonClass = "countDownTimer-"
                let loopIndex = 0;
                $(className).each(function (){
                    loopIndex++;
                    let countDownClass = commonClass + loopIndex;
                    $(this).addClass(countDownClass);

                    loopcounter(countDownClass);
                })

                return "countdown is running";
            }

            // todo:: now remove dot from class name if exist
            className = className.replace(".","");
            loopcounter(className);
        }

        $('.contactArea #check').addClass('form-checkbox');
        $('.contactArea #check').removeClass('form-control');
    });
</script>
</body>
</html>
