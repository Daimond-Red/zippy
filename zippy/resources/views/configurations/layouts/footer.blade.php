
</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright © {!! config('app.name') !!} {!! date('Y') !!}</small>
        </div>
    </div>
</footer>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
{{ HTML::script('media/front/push_asset/vendor/jquery/jquery.min.js') }}
{{ HTML::script('media/front/push_asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}
<!-- Core plugin JavaScript-->
{{ HTML::script('media/front/push_asset/vendor/jquery-easing/jquery.easing.min.js') }}
<!-- Page level plugin JavaScript-->
{{--{{ HTML::script('media/front/push_asset/vendor/chart.js/Chart.min.js') }}--}}
{{ HTML::script('media/front/push_asset/vendor/datatables/jquery.dataTables.js') }}
{{ HTML::script('media/front/push_asset/vendor/datatables/dataTables.bootstrap4.js') }}
<!-- Custom scripts for all pages-->
{{ HTML::script('media/front/push_asset/js/sb-admin.min.js') }}
<!-- Custom scripts for this page-->
{{ HTML::script('media/front/push_asset/js/sb-admin-datatables.min.js') }}

{{ HTML::script('media/front/global/plugins/bootstrap-toastr/toastr.min.js') }}
{{ HTML::script('media/front/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.20/jquery.form-validator.min.js"></script>
{{--{{ HTML::script('media/front/push_asset/js/sb-admin-charts.min.js') }}--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
@yield('script')

<script>

    function showErrorMsg( msg ) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.error(msg, "Errors");
    }

    function showSuccessMsg() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.success(msg, "Success");
    }

    function showPageLoader() {
        $.blockUI();
    }

    function removePageLoader() {
        $.unblockUI();
    }

    $(document).ready(function(){

        $.validate();

    });

</script>

</div>
</body>

</html>
