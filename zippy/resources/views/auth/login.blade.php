<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Login Page
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/app/media/img//logos/fab_icon_zippy.png') }}"/>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{asset('assets/app/media/img/logos/zippy_admin_background.png')}});">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img src="{{asset('assets/app/media/img//logos/logo.png')}}" style="width: 55%">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Sign In To Admin
                        </h3>
                    </div>
                    <form class="m-login__form m-form" method="POST" action="{{ route('login') }}" >
                        {{ csrf_field() }}
                        <div class="form-group m-form__group">
                            <input id="email" type="email" class="form-control m-input" placeholder="Email" name="email" value="{{ old('email') }}" autofocus autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input id="password" placeholder="Password" type="password" class="form-control m-input m-login__form-input--last" name="password" required>
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--focus">
                                    <input type="checkbox" name="remember">
                                    Remember me
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->

<script>
    $('#m_login_signin_submit').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        var form = $(this).closest('form');

        form.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            }
        });

        if (!form.valid()) {
            return;
        }

        btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

        form.submit();
    });

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

    @endif
</script>
<!--begin::Page Snippets -->
{{--<script src="{{asset('assets/snippets/pages/user/login.js')}}" type="text/javascript"></script>--}}
<!--end::Page Snippets -->

</body>
<!-- end::Body -->
</html>
