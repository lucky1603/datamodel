<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ __('Accelerator') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <!-- Datatables css -->
    <link href="/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css" />


</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <!-- LOGO -->
        <a href="index.html" class="logo text-center logo-light">
            <span class="logo-lg left-top-logo">
                <img src="/images/custom/white-logo-transparent.png" alt="">
            </span>
            <span class="logo-sm">
                <img src="/images/custom/white-logo-transparent.png" alt="" height="16">
            </span>
        </a>

        <!-- LOGO -->
        <a href="index.html" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="/assets/images/logo-dark.png" alt="" height="16">
            </span>
            <span class="logo-sm">
                <img src="/assets/images/logo_sm_dark.png" alt="" height="16">
            </span>
        </a>


        <div class="h-100" id="left-side-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav">

                @yield('sidemenu')



            </ul>

            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page frame-padding">
        <div class="content" >
            <!-- Topbar Start -->
            <div class="navbar-custom frame-padding">
                @if(isset($model))
                <div style="display: inline; margin-top: 50px; padding: 10px; position: relative; top: 20px; left:20px; font-size: 25px">
                    {{ __('PROFILE') }} - {{ $model->getData()['name'] }} - <span class="text-info">{{ $model->getAttribute('profile_status')->getText() }}</span>
                </div>
                @endif
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <li class="dropdown notification-list d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-search noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>
{{--                    <li class="dropdown notification-list topbar-dropdown">--}}
{{--                        <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">--}}
{{--                            <img src="/assets/images/flags/us.jpg" alt="user-image" class="mr-0 mr-sm-1" height="12">--}}
{{--                            <span class="align-middle d-none d-sm-inline-block">English</span> <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu">--}}

{{--                            <!-- item-->--}}
{{--                            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                <img src="/assets/images/flags/germany.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">German</span>--}}
{{--                            </a>--}}

{{--                            <!-- item-->--}}
{{--                            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                <img src="/assets/images/flags/italy.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Italian</span>--}}
{{--                            </a>--}}

{{--                            <!-- item-->--}}
{{--                            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                <img src="/assets/images/flags/spain.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Spanish</span>--}}
{{--                            </a>--}}

{{--                            <!-- item-->--}}
{{--                            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                                <img src="/assets/images/flags/russia.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Russian</span>--}}
{{--                            </a>--}}

{{--                        </div>--}}
{{--                    </li>--}}

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-bell noti-icon"></i>
                            <span class="noti-icon-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                            <span class="float-right">
                                                <a href="javascript: void(0);" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>Notification
                                </h5>
                            </div>

                            <div style="max-height: 230px;" data-simplebar>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary">
                                        <i class="mdi mdi-comment-account-outline"></i>
                                    </div>
                                    <p class="notify-details">Caleb Flakelar commented on Admin
                                        <small class="text-muted">1 min ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-info">
                                        <i class="mdi mdi-account-plus"></i>
                                    </div>
                                    <p class="notify-details">New user registered.
                                        <small class="text-muted">5 hours ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon">
                                        <img src="assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                    <p class="notify-details">Cristina Pride</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Hi, How are you? What about our next meeting</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary">
                                        <i class="mdi mdi-comment-account-outline"></i>
                                    </div>
                                    <p class="notify-details">Caleb Flakelar commented on Admin
                                        <small class="text-muted">4 days ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon">
                                        <img src="assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                    <p class="notify-details">Karen Robinson</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Wow ! this admin looks good and awesome design</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-info">
                                        <i class="mdi mdi-heart"></i>
                                    </div>
                                    <p class="notify-details">Carlos Crouch liked
                                        <b>Admin</b>
                                        <small class="text-muted">13 days ago</small>
                                    </p>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                View All
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                           aria-expanded="false">
                                    <span class="account-user-avatar">
{{--                                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">--}}
                                        @if(Auth::user()->photo != null)
                                            <img src="{{ \Illuminate\Support\Facades\Auth::user()->photo }}" alt="user-image" class="rounded-circle">
                                        @else
                                            <img src="/images/custom/nophoto2.png" alt="user-image" class="rounded-circle">
                                        @endif

                                    </span>
                            <span>
                                        <span class="account-user-name">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                                        <span class="account-position">{{ \Illuminate\Support\Facades\Auth::user()->position }}</span>
                                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-edit mr-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-lifebuoy mr-1"></i>
                                <span>Support</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-lock-outline mr-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);"
                               class="dropdown-item notify-item"
                               onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">
                                <i class="mdi mdi-logout mr-1"></i>
                                <span>Logout</span>
                                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </a>

                        </div>
                    </li>

                </ul>
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                @yield('search')

            </div>
            <!-- end Topbar -->

            <!-- Start Content-->
            <div style="position: absolute; top: 70px; bottom: 70px; left: 270px; right: 0px; overflow: auto; padding: 20px" id="app">

                @yield('content')

            </div> <!-- container -->

            <div id="dialogHost" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                            <h4 class="modal-title" id="primary-header-modalLabel">Modal Heading</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="messageBox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                            <h4 class="modal-title" id="primary-header-modalLabel">Modal Heading</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="modal-message">Probna poruka</p>
                        </div>
                        <div class="modal-footer">
                            <div class="flex-fill">
                                <div class="flex-column">
                                    <button type="button" id="messageButtonOk" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                    <button type="button" id="messageButtonCancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-md-block">
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->


<!-- Right Sidebar -->
<div class="right-bar">

    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h5 class="m-0">Settings</h5>
    </div>

    <div class="rightbar-content h-100" data-simplebar>

        <div class="p-3">
            <div class="alert alert-warning" role="alert">
                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
            </div>

            <!-- Settings -->
            <h5 class="mt-3">Color Scheme</h5>
            <hr class="mt-1" />

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light"
                       id="light-mode-check" checked />
                <label class="custom-control-label" for="light-mode-check">Light Mode</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark"
                       id="dark-mode-check" />
                <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
            </div>

            <!-- Width -->
            <h5 class="mt-4">Width</h5>
            <hr class="mt-1" />
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="width" value="fluid" id="fluid-check" checked />
                <label class="custom-control-label" for="fluid-check">Fluid</label>
            </div>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="width" value="boxed" id="boxed-check" />
                <label class="custom-control-label" for="boxed-check">Boxed</label>
            </div>

            <!-- Left Sidebar-->
            <h5 class="mt-4">Left Sidebar</h5>
            <hr class="mt-1" />
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="theme" value="default" id="default-check"
                       checked />
                <label class="custom-control-label" for="default-check">Default</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="theme" value="light" id="light-check" />
                <label class="custom-control-label" for="light-check">Light</label>
            </div>

            <div class="custom-control custom-switch mb-3">
                <input type="radio" class="custom-control-input" name="theme" value="dark" id="dark-check" />
                <label class="custom-control-label" for="dark-check">Dark</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check"
                       checked />
                <label class="custom-control-label" for="fixed-check">Fixed</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="condensed"
                       id="condensed-check" />
                <label class="custom-control-label" for="condensed-check">Condensed</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="scrollable"
                       id="scrollable-check" />
                <label class="custom-control-label" for="scrollable-check">Scrollable</label>
            </div>

            <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>

            <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/"
               class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase Now</a>
        </div> <!-- end padding-->

    </div>
</div>

<div class="rightbar-overlay"></div>
<!-- /Right-bar -->

<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>

<!-- third party js -->
<script src="/assets/js/vendor/Chart.bundle.min.js"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="/assets/js/pages/demo.dashboard-projects.js"></script>
<!-- end demo js-->

<!-- plugin js -->
<script src="/assets/js/vendor/summernote-bs4.min.js"></script>
<!-- Summernote demo -->
<script src="/assets/js/pages/demo.summernote.js"></script>

<!-- plugin js -->
<script src="/assets/js/vendor/dropzone.min.js"></script>
<!-- init js -->
<script src="/assets/js/ui/component.fileupload.js"></script>

<!-- File uploader styler -->
<script type="text/javascript" src="/js/bootstrap-filestyle.min.js"> </script>

<!-- Datatables js -->
<script src="/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/assets/js/vendor/dataTables.responsive.min.js"></script>
<script src="/assets/js/vendor/responsive.bootstrap4.min.js"></script>

<script src="/js/vue.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
       $('#newClient').on('click', function(evt) {
           var where = $('#newClient').attr('href');
           $.get(where, function(data) {
               var content = $(data).find('form')[0];
               console.log(content);
               var title = $(data).find('h1').first().text();
               $('#dialogHost.modal .modal-dialog .modal-content .modal-body').html(content);
               $('#dialogHost.modal .modal-dialog .modal-content .modal-header .modal-title').text(title);

               if($('#is_company').prop('checked') == true) {
                   $('#id_number_group').show();
               } else {
                   $('#id_number_group').hide();
               }

               $('#is_company').on('change', function(event) {
                   if($(this).prop('checked') == true) {
                       $('#id_number_group').show();
                   } else {
                       $('#id_number_group').hide();
                   }
               });

               $('#cancel').on('click', function(evt) {
                   location.reload();
               });


           });
       });

        $('a.edituser').on('click', function(evt) {
            evt.preventDefault();
            var el = evt.currentTarget;
            console.log(el);
            $.get($(el).attr('href'), function(data) {
                let content = $(data).find('form');
                let title = $(data).find('h1').first().text();
                $('.modal-body').html(content);
                $('.modal-title').text(title);
                $('.modal-body').find('#photo').on('change', function (evt) {
                    let el = evt.currentTarget;
                    console.log(el);
                    console.log($(el)[0].files[0]);
                    var fileReader = new FileReader();
                    fileReader.onload = function () {
                        var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                        $('#photoPreview').attr('src', data);
                    };
                    fileReader.readAsDataURL($(el)[0].files[0]);
                });
            });
        });

    });
</script>

@yield('scripts')

</body>
</html>
