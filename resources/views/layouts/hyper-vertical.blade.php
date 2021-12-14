<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ __('Accelerator') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="icon" href="{!! asset('images/custom/blue-logo-transparent.png') !!}"/>

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

    @yield('analytics')

</head>

<body class="loading overflow-hidden" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <!-- LOGO -->
        <a href="https://ntpark.rs" class="logo text-center logo-light">
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
                <span class="h4" style="position: relative; top:3vh; left: 2vh">@yield('page-title')</span>
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
            <div class="position-relative overflow-auto p-2 pb-0" id="app" style="height: 90vh">

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

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<script src="/js/vue.js"></script>

<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>

<!-- third party js -->
<script src="/assets/js/vendor/Chart.bundle.min.js"></script>
<script src="/assets/js/vendor/apexcharts.min.js"></script>
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
<script src="/assets/js/vendor/dataTables.select.min.js"></script>
<script src="/assets/js/vendor/responsive.bootstrap4.min.js"></script>



{{--@yield('scripts')--}}

<script type="text/javascript">
    $(document).ready(function() {
       $('#newClient').on('click', function(evt) {
           var where = $('#newClient').attr('href');
           $.get(where, function(data) {
               var content = $(data).find('form').first();
               var title = $(data).find('h1').first().text();
               $('#dialogHost.modal .modal-dialog .modal-content .modal-body').html(content);
               $('#dialogHost.modal .modal-dialog .modal-content .modal-header .modal-title').text("Kreirajte novi profil");

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

       $('#newmentor').click(function() {
            let where = $(this).attr('href');
            $.get(where, function(data) {
                const content = $(data).find('form')[1];
                const title = $(data).find('h1').first().text();
                $('#dialogHost.modal .modal-dialog .modal-content .modal-body').html(content);
                $('#dialogHost.modal .modal-dialog .modal-content .modal-header .modal-title').text(title);

                $('#textBtn').click(function() {
                    $('#photo').trigger('click');
                })

                $('#photo').on('change', function (evt) {
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

                $('#buttonSubmit').click(function() {
                    let formData = new FormData($('form#myMentorForm')[0]);
                    formData.append('photo', $('#photo')[0].files[0]);
                        $.ajax({
                            url: '/mentors/create',
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            data: formData,
                            // headers: {
                            //     'X-CSRF-Token' : token
                            // },
                            success: function (data) {
                                // The file was uploaded successfully...
                                console.log(data);
                                $('.error-notification').hide();
                                // $('#button_spinner_send').attr('hidden', true);
                                // location.reload();
                            },
                            error: function (data) {
                                // there was an error.
                                let errorResponse = data.responseJSON;
                                $('.error-notification').hide();
                                for(let key in errorResponse.errors) {
                                        let message = errorResponse.errors[key];
                                        $('#' + key + 'Error').show().text(message);
                                }

                            }
                        });



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
