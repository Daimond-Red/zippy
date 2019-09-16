</div>
</div>
</div>
<!-- end:: Body -->

<!-- begin::Quick Sidebar -->
<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
    <div class="m-quick-sidebar__content m--hide">
				<span id="m_quick_sidebar_close" class="m-quick-sidebar__close">
					<i class="la la-close"></i>
				</span>
        <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger" role="tab" style="border:none">
                    Search...
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active m-scrollable" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
                <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
                    <div class="m-messenger__messages">
                        @yield('sidebarSearch')
                    </div>
                    <div class="m-messenger__seperator"></div>
                    <div class="m-messenger__form">
                        <div class="m-messenger__form-tools">
                            <button class="btn btn-primary sidebarSearchSubmit" type="button">
                                Search
                            </button>
                            <button class="btn btn-secondary sidebarSearchClear" data-dismiss="modal" type="button">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::Quick Sidebar -->
<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<div aria-labelledby="dataModel" class="modal fade" id="dataModel" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModelTitle"></h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
						<span aria-hidden="true">
							×
						</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Close
                </button>
                <button class="btn btn-primary dataModelSubmit" type="button">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>


<div aria-labelledby="dataModel" class="modal fade" id="dataModelGlobalSearch" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        {{-- {!! HTML::vtext('q', null, ['label' => 'Search...', 'id' => 'globalSearchField']) !!} --}}

                        <div class="input-group mb-3">
                          <div class="input-group-prepend" style="width: 38px;
                                                            line-height: 34px;
                                                            border: 1px solid #ebedf2;
                                                            border-right: none;
                                                            text-align: center;">
                            <span class="input-group-text" id="inputGroup-sizing-default">+91</span>
                          </div>
                          <input type="text" id="globalSearchField" class="form-control" placeholder="Search mobile..." aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                </div>
                <hr>
                <div id="globalSearchList">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin::Footer -->
<footer class="m-grid__item		m-footer ">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                <span class="m-footer__copyright">
                    {{date('Y')}} &copy;  Zipkart Logistics Pvt. Ltd. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer>
<!-- end::Footer -->
</div>
<!-- end:: Page -->


<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->		    <!-- begin::Quick Nav -->

<!-- begin::Quick Nav -->
<!--begin::Base Scripts -->
<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
<!--end::Page Snippets -->

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.20/jquery.form-validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.js"></script>
<script src="{{ asset('assets/js/js.cookie.js') }}"></script>

<script>

    function showErrorMsg(msg) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.error(msg, "Errors");
    }

    function showSuccessMsg(msg) {

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.success(msg, "Success");

    }

    function pageLoader() {
        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'primary',
            message: 'Processing...'
        });
    }

    function removePageLoader() {
        mApp.unblockPage();
    }

    function changeTableContent(data) {
        var $response=$(data);
        //query the jq object for the values
        var dataToday = $response.find('.m-portlet__body').html();
        $('.m-portlet__body').html(dataToday);
        removePageLoader();
    }

    function initFancyBox() {
        $(".light-image").fancybox();
    }

    initFancyBox();

    function init() {

        $('.datepicker').datetimepicker({
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            format: 'dd-mm-yyyy',
            startDate : new Date()
        });

        initFancyBox();

        $('.editor').summernote({
            height: 70
        });

        // pagination
        $('body').on('click', '.ajax-collection .pagination a', function (e) {

            e.preventDefault();
            var url = $(this).attr('href');
            var table = $(this).closest('.ajax-collection');
            //pageLoader();
            $.get(url, function(data){

                //create jquery object from the response html
                var $response=$(data);
                //query the jq object for the values
                var dataToday = $response.find('.ajax-collection').html();
                $(table).html(dataToday);
                initFancyBox();
                $('[data-toggle="tooltip"]').tooltip();
                //removePageLoader();

            });

        });
        // ./ pagination
        // select 2
        $('.select2-select').select2();
        // ./ select

        // select 2 ajax
        $('.select2-ajaxselect').select2({
            width: "off",
            ajax: {
                url: $('.select2-ajaxselect').data('url'),
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, page) {
                    return {
                        results: data.items
                    };
                },
                cache: true
            }
        });
        // ./ select 2 ajax

        $.validate();

    }


    $(document).ready(function () {

        init();
        // data model script

        $('[data-toggle="tooltip"]').tooltip();
        
        $('body').on('click', '.dataModel', function () {
            var url = $(this).data('href');
            var title = $(this).data('title');

            mApp.blockPage({
                overlayColor: '#000000',
                type: 'loader',
                state: 'primary',
                message: 'Processing...'
            });

            $.get(url, function(res){
                $('#dataModelTitle').text(title);
                $('#dataModel .modal-body').html(res);
                $('.editor').summernote({
                    height: 70
                });

                mApp.unblockPage();

                $('#dataModel').modal('show');
                initFancyBox();
                init();

            });
        });

        $('body').on('click', '.dataModelSubmit', function () {

            var s = $(this).parent().parent().find('form').submit();

            // var btn = $(this);
            // btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
            //
            // mApp.blockPage({
            //     overlayColor: '#000000',
            //     type: 'loader',
            //     state: 'primary',
            //     message: 'Processing...'
            // });



        });

        // ./ data model script

        @if (count($errors) > 0)
            var msg = '';
            @foreach ($errors->all() as $error)
            msg += '{{ $error }} <br />';
            @endforeach

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "1500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.error(msg, "Errors");

        @endif

        @if(\Session::has('success'))
            var msg1 = '{{ \Session::get('success') }}';
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "1500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success(msg1, "Success");
        @endif

        $('body').on('click', '.delete', function (e) {

            var that = this;
            e.preventDefault();

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(function(result) {
                if (result.value) {
                    window.location.href = $(that).closest('a').attr('href');
                }
            });

        });

        $('body').on('click', '.confirmModel', function (e) {

            var that = this;
            e.preventDefault();

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, confirm!",
                closeOnConfirm: false
            }).then(function(result) {
                if (result.value) {
                    window.location.href = $(that).closest('a').attr('href');
                }
            });

        });

        $('body').on('click', '.pagination  a.page-link', function (e) {

            e.preventDefault();
            var url = $(this).attr('href');
            pageLoader();
            $.get(url, function(data){

                // history.pushState(null, null, url);
                //create jquery object from the response html
                var $response=$(data);
                //query the jq object for the values
                var dataToday = $response.find('.m-portlet__body').html();
                $('.m-portlet__body').html(dataToday);
                removePageLoader();
                initFancyBox();

            });

        });


        // search
        $('body').on('click', '.sidebarSearchSubmit', function (e) {

            var url = $('#search-form').attr('href');

            pageLoader();
            $.get(url, $('#search-form').serialize(), function(data){
                changeTableContent(data);
                initFancyBox();
            });

        });

        $('body').on('click', '.sidebarSearchClear', function (e) {

            var url = $('#search-form').attr('href');
            pageLoader();
            $.get(url, {}, function(data){
                changeTableContent(data);
                $('#m_quick_sidebar_toggle').click();
                $('#search-form').resetForm();
                initFancyBox();
            });

        });

        $('body').on('submit', '#search-form', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            pageLoader();
            $.get(url, $('#search-form').serialize(), function(data){
                changeTableContent(data);
                initFancyBox();
            });
        });

        // ./ search

        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        $.validate();

        $('body').on('click', '#globalSearch', function(e){
            e.preventDefault();
            $('#dataModelGlobalSearch').modal('show');
        });

        $('body').on('input', '#globalSearchField', function(e){
            e.preventDefault();
            
            var url = '{{ route('admin.globalSearch') }}' + '?q=' + $(this).val();

            $.get(url, function(data){
                $('#globalSearchList').html(data);
                initFancyBox();
                $('[data-toggle="tooltip"]').tooltip();
            });

        });

        

    });

</script>

@yield('script')

</body>
<!-- end::Body -->
</html>