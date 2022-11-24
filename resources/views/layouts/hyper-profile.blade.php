<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TNLLNRK');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8" />
    <title>{{ __('Accelerator') }} - {{__('PROFILE') }} - @yield('client-name')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />


</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": false}'>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNLLNRK"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<!-- Begin page -->
<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content" id="app">
            <!-- Topbar Start -->
            <div class="navbar-custom bg-dark">
                <div class="topbar-left bg-dark">
                    <a href="{{ route('home') }}" class="topnav-logo">
                        <span class="topnav-logo-lg ml-4" style="position:fixed;top:10px">
                            <img src="/images/custom/white-logo-transparent-full.png" alt="" height="50">
                        </span>

                    </a>
                </div>
                    <ul class="topbar-right-menu list-unstyled float-right mb-0 bg-dark">
                        <li class="dropdown notification-list topbar-dropdown d-none d-lg-block">
                            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" id="topbar-languagedrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="/assets/images/flags/us.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">English</span> <i class="mdi mdi-chevron-down align-middle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu" aria-labelledby="topbar-languagedrop">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="/assets/images/flags/germany.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">German</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="/assets/images/flags/italy.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Italian</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="/assets/images/flags/spain.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Spanish</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="/assets/images/flags/russia.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Russian</span>
                                </a>

                            </div>
                        </li>

                        <li class="dropdown notification-list bg-dark">
                            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">

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
                                            <img src="/assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" /> </div>
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
                                            <img src="/assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
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

                        <li class="dropdown notification-list bg-dark">
                            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0 bg-dark" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                        <span class="account-user-avatar">
                                            <img src="@if(\Illuminate\Support\Facades\Auth::user()->photo == null) /assets/images/users/avatar-1.jpg @else {{ \Illuminate\Support\Facades\Auth::user()->photo }} @endif" alt="user-image" class="rounded-circle">
                                        </span>
                                <span>
                                            <span class="account-user-name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                                            <span class="account-position">{{ \Illuminate\Support\Facades\Auth::user()->position }}</span>
                                        </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown bg-dark" aria-labelledby="topbar-userdrop">
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
                                   onclick="event.preventDefault(); document.getElementById('logoutForm').submit()" >
                                    <i class="mdi mdi-logout mr-1"></i>
                                    <span>Logout</span>
                                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                </a>

                            </div>
                        </li>

                    </ul>
                    <a class="navbar-toggle"  data-toggle="collapse" data-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>

            <!-- end Topbar -->
            <div class="shadow-sm" style="position: fixed; top:70px; left:0px; right: 0px; height:50px; z-index: 1000; background-color:white">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-dashboard mr-1"></i>{{__('Actions')}} <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-dashboards">
                                        @yield('next-status')
                                        <a id="mymenu" href="http://www.yahoo.com" class="dropdown-item" data-toggle="modal" data-target="#dialogHost">{{ __('Cancel Request')}}</a>
                                        @yield('back-to-previous')
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>


            <!-- Start Content-->
            <div class="container-fluid" style="position: absolute; top:120px; left:0px; right: 0px; height:70px;">
                <div>
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @yield('breadcrumbs')
                            </ol>
                        </div>
                        @yield('page-title')
                    </div>
                </div>
            </div>
            <div style="position: absolute; top: 175px; left:0px; right: 0px; bottom: 65px; overflow: auto" class="container-fluid">

                <div class="row h-100 overflow-hidden " >
                    <div class="col-sm-3  h-100">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                                    <span class="d-none d-md-block">{{ strtoupper(__('Profile')) }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#team" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-face-agent d-md-none d-block"></i>
                                    <span class="d-none d-md-block">{{ strtoupper( __('Team')) }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content overflow-hidden shadow" style="height: 90%!important;" >
                            <div class="tab-pane show active h-100 overflow-hidden shadow" id="profile">
                                <div class="card h-100"  >
                                    <div class="card-body">
                                            @yield('profile-short-data')
                                            <ul class="social-list list-inline mt-3 mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                                            class="mdi mdi-facebook"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                                            class="mdi mdi-google"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                                            class="mdi mdi-twitter"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                                            class="mdi mdi-github-circle"></i></a>
                                                </li>
                                            </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane h-100" id="team">
                                <!-- Messages-->
                                <div class="card h-100" >
                                    <div class="card-header">
                                        <div class="dropdown float-right">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="{{ route('user.addforprofile', $model->getId()) }}" class="dropdown-item nav-link edituser" data-toggle="modal" data-target="#dialogHost" >{{ __('Add User') }}</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        @yield('users')
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-sm-6 h-100">
                        <div class="card shadow" style="height: 98%!important;"  >
{{--                            <div class="card-header bg-primary text-light">--}}
{{--                                {{ __('Application Form') }}--}}
{{--                            </div>--}}
                            <div class="card-body overflow-auto">
                                @yield('profile-data')
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 h-100">
                        <div class="card shadow" style="height: 98%!important;"  >
                            <div class="card-header bg-primary text-light">
                                {{ __('Activities') }}
                            </div>
                            <div class="card-body overflow-auto" style="height: 80%!important;">
                                <div class="timeline-alt pb-0" >
                                    @yield('activities')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    <!-- end row-->
            </div>
        </div>

            <!-- container -->

    </div>
    <!-- content -->

    <!-- Footer Start -->
    <footer class="footer pl-4 pr-4 bg-white" >
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

    </footer>
    <!-- end Footer -->

        <div id="dialogHost" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                <strong>Customize </strong> the overall color scheme, layout width, etc.
            </div>

            <!-- Settings -->
            <h5 class="mt-3">Color Scheme</h5>
            <hr class="mt-1" />

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light" id="light-mode-check"
                       checked />
                <label class="custom-control-label" for="light-mode-check">Light Mode</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark" id="dark-mode-check" />
                <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
            </div>

            <!-- Width -->
            <h5 class="mt-4">Width</h5>
            <hr class="mt-1"/>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="width" value="fluid" id="fluid-check" checked />
                <label class="custom-control-label" for="fluid-check">Fluid</label>
            </div>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="width" value="boxed" id="boxed-check" />
                <label class="custom-control-label" for="boxed-check">Boxed</label>
            </div>



            <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>

            <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/" class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase Now</a>
        </div> <!-- end padding-->

    </div>
</div>

<div class="rightbar-overlay"></div>
<!-- /Right-bar -->



<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
       $('#nextStatus').on('click', function(evt) {
           var where = $('#nextStatus').attr('href');
           $.get(where, function(data) {
               var content = $(data).find('form');
               var title = $(data).find('h1').first().text();
               $('.modal-body').html(content);
               $('.modal-title').text(title);
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
