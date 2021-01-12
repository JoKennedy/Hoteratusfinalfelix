<!-- BEGIN VENDOR JS-->
<script src="{{asset('js/vendors.min.js')}}"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
@yield('vendor-script')
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="{{asset('js/plugins.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/custom/custom-script.js')}}"></script>
@if ($configData['isCustomizer']=== true)
<script src="{{asset('js/scripts/customizer.js')}}"></script>
@endif
<script>
   $( document ).ready(function() {
        $(".loader").hide();
    });
    $( "#formSubmit" ).on("submit",function(  ) {
        $(".loader").show();

        ///event.preventDefault();
    });
</script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
@yield('page-script')
