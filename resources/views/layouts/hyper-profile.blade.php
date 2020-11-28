<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ __('Accelerator') }} - {{__('CLIENT PROFILE') }} - @yield('client-name')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="/assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />

</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
<!-- Begin page -->
<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            <div class="navbar-custom topnav-navbar topnav-navbar-dark">
                <div class="container-fluid">

                    <!-- LOGO -->
                    <a href="" class="topnav-logo">
                                <span class="topnav-logo-lg">
                                    <img src="/assets/images/logo-light.png" alt="" height="16">
                                </span>
                        <span class="topnav-logo-sm">
                                    <img src="/assets/images/logo_sm_dark.png" alt="" height="16">
                                </span>
                    </a>

                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
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

                        <li class="dropdown notification-list">
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

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                        <span class="account-user-avatar">
                                            <img src="@if(\Illuminate\Support\Facades\Auth::user()->photo == null) /assets/images/users/avatar-1.jpg @else {{ \Illuminate\Support\Facades\Auth::user()->photo }} @endif" alt="user-image" class="rounded-circle">
                                        </span>
                                <span>
                                            <span class="account-user-name">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                                            <span class="account-position">{{ \Illuminate\Support\Facades\Auth::user()->position }}</span>
                                        </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
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
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout mr-1"></i>
                                    <span>Logout</span>
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
            </div>
            <!-- end Topbar -->

            <div class="topnav shadow-sm">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-dashboard mr-1"></i>Dashboards <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-dashboards">
                                        <a href="dashboard-analytics.html" class="dropdown-item">Analytics</a>
                                        <a href="dashboard-crm.html" class="dropdown-item">CRM</a>
                                        <a href="index.html" class="dropdown-item">Ecommerce</a>
                                        <a href="dashboard-projects.html" class="dropdown-item">Projects</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-apps mr-1"></i>Apps <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                        <a href="apps-calendar.html" class="dropdown-item">Calendar</a>
                                        <a href="apps-chat.html" class="dropdown-item">Chat</a>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ecommerce <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                                <a href="apps-ecommerce-products.html" class="dropdown-item">Products</a>
                                                <a href="apps-ecommerce-products-details.html" class="dropdown-item">Products Details</a>
                                                <a href="apps-ecommerce-orders.html" class="dropdown-item">Orders</a>
                                                <a href="apps-ecommerce-orders-details.html" class="dropdown-item">Order Details</a>
                                                <a href="apps-ecommerce-customers.html" class="dropdown-item">Customers</a>
                                                <a href="apps-ecommerce-shopping-cart.html" class="dropdown-item">Shopping Cart</a>
                                                <a href="apps-ecommerce-checkout.html" class="dropdown-item">Checkout</a>
                                                <a href="apps-ecommerce-sellers.html" class="dropdown-item">Sellers</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Email <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-email">
                                                <a href="apps-email-inbox.html" class="dropdown-item">Inbox</a>
                                                <a href="apps-email-read.html" class="dropdown-item">Read Email</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-project" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Projects <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-project">
                                                <a href="apps-projects-list.html" class="dropdown-item">List</a>
                                                <a href="apps-projects-details.html" class="dropdown-item">Details</a>
                                                <a href="apps-projects-gantt.html" class="dropdown-item">Gantt</a>
                                                <a href="apps-projects-add.html" class="dropdown-item">Create Project</a>
                                            </div>
                                        </div>
                                        <a href="apps-social-feed.html" class="dropdown-item">Social Feed</a>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-tasks" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tasks <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-tasks">
                                                <a href="apps-tasks.html" class="dropdown-item">List</a>
                                                <a href="apps-tasks-details.html" class="dropdown-item">Details</a>
                                                <a href="apps-kanban.html" class="dropdown-item">Kanban Board</a>
                                            </div>
                                        </div>
                                        <a href="apps-file-manager.html" class="dropdown-item">File Manager</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-copy-alt mr-1"></i>Pages <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Authenitication <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                                <a href="pages-login.html" class="dropdown-item">Login</a>
                                                <a href="pages-login-2.html" class="dropdown-item">Login 2</a>
                                                <a href="pages-register.html" class="dropdown-item">Register</a>
                                                <a href="pages-register-2.html" class="dropdown-item">Register 2</a>
                                                <a href="pages-logout.html" class="dropdown-item">Logout</a>
                                                <a href="pages-logout-2.html" class="dropdown-item">Logout 2</a>
                                                <a href="pages-recoverpw.html" class="dropdown-item">Recover Password</a>
                                                <a href="pages-recoverpw-2.html" class="dropdown-item">Recover Password 2</a>
                                                <a href="pages-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                                <a href="pages-lock-screen-2.html" class="dropdown-item">Lock Screen 2</a>
                                                <a href="pages-confirm-mail.html" class="dropdown-item">Confirm Mail</a>
                                                <a href="pages-confirm-mail-2.html" class="dropdown-item">Confirm Mail 2</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-error" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Error <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-error">
                                                <a href="pages-404.html" class="dropdown-item">Error 404</a>
                                                <a href="pages-404-alt.html" class="dropdown-item">Error 404-alt</a>
                                                <a href="pages-500.html" class="dropdown-item">Error 500</a>
                                            </div>
                                        </div>
                                        <a href="pages-starter.html" class="dropdown-item">Starter Page</a>
                                        <a href="pages-preloader.html" class="dropdown-item">With Preloader</a>
                                        <a href="pages-profile.html" class="dropdown-item">Profile</a>
                                        <a href="pages-profile-2.html" class="dropdown-item">Profile 2</a>
                                        <a href="pages-invoice.html" class="dropdown-item">Invoice</a>
                                        <a href="pages-faq.html" class="dropdown-item">FAQ</a>
                                        <a href="pages-pricing.html" class="dropdown-item">Pricing</a>
                                        <a href="pages-maintenance.html" class="dropdown-item">Maintenance</a>
                                        <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                        <a href="landing.html" class="dropdown-item">Landing</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-package mr-1"></i>Components <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-components">
                                        <a href="widgets.html" class="dropdown-item">Widgets</a>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Base UI 1 <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-ui-kit">
                                                <a href="ui-accordions.html" class="dropdown-item">Accordions</a>
                                                <a href="ui-alerts.html" class="dropdown-item">Alerts</a>
                                                <a href="ui-avatars.html" class="dropdown-item">Avatars</a>
                                                <a href="ui-badges.html" class="dropdown-item">Badges</a>
                                                <a href="ui-breadcrumb.html" class="dropdown-item">Breadcrumb</a>
                                                <a href="ui-buttons.html" class="dropdown-item">Buttons</a>
                                                <a href="ui-cards.html" class="dropdown-item">Cards</a>
                                                <a href="ui-carousel.html" class="dropdown-item">Carousel</a>
                                                <a href="ui-dropdowns.html" class="dropdown-item">Dropdowns</a>
                                                <a href="ui-embed-video.html" class="dropdown-item">Embed Video</a>
                                                <a href="ui-grid.html" class="dropdown-item">Grid</a>
                                                <a href="ui-list-group.html" class="dropdown-item">List Group</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Base UI 2 <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-ui-kit2">
                                                <a href="ui-media-object.html" class="dropdown-item">Media Object</a>
                                                <a href="ui-modals.html" class="dropdown-item">Modals</a>
                                                <a href="ui-notifications.html" class="dropdown-item">Notifications</a>
                                                <a href="ui-pagination.html" class="dropdown-item">Pagination</a>
                                                <a href="ui-popovers.html" class="dropdown-item">Popovers</a>
                                                <a href="ui-progress.html" class="dropdown-item">Progress</a>
                                                <a href="ui-ribbons.html" class="dropdown-item">Ribbons</a>
                                                <a href="ui-spinners.html" class="dropdown-item">Spinners</a>
                                                <a href="ui-tabs.html" class="dropdown-item">Tabs</a>
                                                <a href="ui-tooltips.html" class="dropdown-item">Tooltips</a>
                                                <a href="ui-typography.html" class="dropdown-item">Typography</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-extended-ui" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Extended UI <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-extended-ui">
                                                <a href="extended-dragula.html" class="dropdown-item">Dragula</a>
                                                <a href="extended-range-slider.html" class="dropdown-item">Range Slider</a>
                                                <a href="extended-ratings.html" class="dropdown-item">Ratings</a>
                                                <a href="extended-scrollbar.html" class="dropdown-item">Scrollbar</a>
                                                <a href="extended-scrollspy.html" class="dropdown-item">Scrollspy</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Charts <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-apex-charts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Apex Charts <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-apex-charts">
                                                        <a href="charts-apex-area.html" class="dropdown-item">Area</a>
                                                        <a href="charts-apex-bar.html" class="dropdown-item">Bar</a>
                                                        <a href="charts-apex-bubble.html" class="dropdown-item">Bubble</a>
                                                        <a href="charts-apex-candlestick.html" class="dropdown-item">Candlestick</a>
                                                        <a href="charts-apex-column.html" class="dropdown-item">Column</a>
                                                        <a href="charts-apex-heatmap.html" class="dropdown-item">Heatmap</a>
                                                        <a href="charts-apex-line.html" class="dropdown-item">Line</a>
                                                        <a href="charts-apex-mixed.html" class="dropdown-item">Mixed</a>
                                                        <a href="charts-apex-pie.html" class="dropdown-item">Pie</a>
                                                        <a href="charts-apex-radar.html" class="dropdown-item">Radar</a>
                                                        <a href="charts-apex-radialbar.html" class="dropdown-item">RadialBar</a>
                                                        <a href="charts-apex-scatter.html" class="dropdown-item">Scatter</a>
                                                        <a href="charts-apex-sparklines.html" class="dropdown-item">Sparklines</a>
                                                    </div>
                                                </div>
                                                <a href="charts-chartjs.html" class="dropdown-item">Chartjs</a>
                                                <a href="charts-brite.html" class="dropdown-item">Britecharts</a>
                                                <a href="charts-sparkline.html" class="dropdown-item">Sparklines</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-forms" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Forms <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-forms">
                                                <a href="form-elements.html" class="dropdown-item">Basic Elements</a>
                                                <a href="form-advanced.html" class="dropdown-item">Form Advanced</a>
                                                <a href="form-validation.html" class="dropdown-item">Validation</a>
                                                <a href="form-wizard.html" class="dropdown-item">Wizard</a>
                                                <a href="form-fileuploads.html" class="dropdown-item">File Uploads</a>
                                                <a href="form-editors.html" class="dropdown-item">Editors</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-tables" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tables <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-tables">
                                                <a href="tables-basic.html" class="dropdown-item">Basic Tables</a>
                                                <a href="tables-datatable.html" class="dropdown-item">Data Tables</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Icons <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-icons">1
                                                <a href="icons-dripicons.html" class="dropdown-item">Dripicons</a>
                                                <a href="icons-mdi.html" class="dropdown-item">Material Design</a>
                                                <a href="icons-unicons.html" class="dropdown-item">Unicons</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-maps" role="button" data-toggle="dropdown" aria-expanded="false">
                                                Maps <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-maps">
                                                <a href="maps-google.html" class="dropdown-item">Google Maps</a>
                                                <a href="maps-vector.html" class="dropdown-item">Vector Maps</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="uil-window mr-1"></i>Layouts <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                        <a href="layouts-vertical.html" class="dropdown-item">Vertical</a>
                                        <a href="layouts-detached.html" class="dropdown-item">Detached</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>


            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                    <li class="breadcrumb-item active"></li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ __('CLIENT PROFILE') }} - {{ $model->getData()['name'] }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="card text-center">
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
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <!-- Messages-->
                        <div class="card">
                            <div class="card-header">
                                <div class="dropdown float-right">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>
                                <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                            </div>
                            <div class="card-body">
                                @yield('users')
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->

                    </div> <!-- end col-->

                    <div class="col-xl-8 col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                    <li class="nav-item">
                                        <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                            About
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                            Timeline
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                            Settings
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" >
                                    <div class="tab-pane" id="aboutme">


                                        @yield('profile-data')

                                        <h5 class="text-uppercase mt-4"><i class="mdi mdi-briefcase mr-1"></i>
                                            Experience</h5>
                                        <div class="timeline-alt pb-0">
                                            <div class="timeline-item">
                                                <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <h5 class="mt-0 mb-1">Lead designer / Developer</h5>
                                                    <p class="font-14">websitename.com <span class="ml-2 font-12">Year: 2015 - 18</span></p>
                                                    <p class="text-muted mt-2 mb-0 pb-3">Everyone realizes why a new common language
                                                        would be desirable: one could refuse to pay expensive translators.
                                                        To achieve this, it would be necessary to have uniform grammar,
                                                        pronunciation and more common words.</p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <h5 class="mt-0 mb-1">Senior Graphic Designer</h5>
                                                    <p class="font-14">Software Inc. <span class="ml-2 font-12">Year: 2012 - 15</span></p>
                                                    <p class="text-muted mt-2 mb-0 pb-3">If several languages coalesce, the grammar
                                                        of the resulting language is more simple and regular than that of
                                                        the individual languages. The new common language will be more
                                                        simple and regular than the existing European languages.</p>

                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <h5 class="mt-0 mb-1">Graphic Designer</h5>
                                                    <p class="font-14">Coderthemes Design LLP <span class="ml-2 font-12">Year: 2010 - 12</span></p>
                                                    <p class="text-muted mt-2 mb-0 pb-2">The European languages are members of
                                                        the same family. Their separate existence is a myth. For science
                                                        music sport etc, Europe uses the same vocabulary. The languages
                                                        only differ in their grammar their pronunciation.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- end timeline -->

                                        <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                            Projects</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-nowrap mb-0">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Clients</th>
                                                    <th>Project Name</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><img src="/assets/images/users/avatar-2.jpg" alt="table-user" class="mr-2 rounded-circle" height="24"> Halette Boivin</td>
                                                    <td>App design and development</td>
                                                    <td>01/01/2015</td>
                                                    <td>10/15/2018</td>
                                                    <td><span class="badge badge-info-lighten">Work in Progress</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td><img src="/assets/images/users/avatar-3.jpg" alt="table-user" class="mr-2 rounded-circle" height="24"> Durandana Jolicoeur</td>
                                                    <td>Coffee detail page - Main Page</td>
                                                    <td>21/07/2016</td>
                                                    <td>12/05/2018</td>
                                                    <td><span class="badge badge-danger-lighten">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td><img src="/assets/images/users/avatar-4.jpg" alt="table-user" class="mr-2 rounded-circle" height="24"> Lucas Sabourin</td>
                                                    <td>Poster illustation design</td>
                                                    <td>18/03/2018</td>
                                                    <td>28/09/2018</td>
                                                    <td><span class="badge badge-success-lighten">Done</span></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td><img src="/assets/images/users/avatar-6.jpg" alt="table-user" class="mr-2 rounded-circle" height="24"> Donatien Brunelle</td>
                                                    <td>Drinking bottle graphics</td>
                                                    <td>02/10/2017</td>
                                                    <td>07/05/2018</td>
                                                    <td><span class="badge badge-info-lighten">Work in Progress</span></td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td><img src="/assets/images/users/avatar-5.jpg" alt="table-user" class="mr-2 rounded-circle" height="24"> Karel Auberjo</td>
                                                    <td>Landing page design - Home</td>
                                                    <td>17/01/2017</td>
                                                    <td>25/05/2021</td>
                                                    <td><span class="badge badge-warning-lighten">Coming soon</span></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div> <!-- end tab-pane -->
                                    <!-- end about me section content -->

                                    <div class="tab-pane show active" id="timeline">

                                        <!-- comment box -->
                                        <div class="border rounded mt-2 mb-3">
                                            <form action="#" class="comment-area-box">
                                                <textarea rows="3" class="form-control border-0 resize-none" placeholder="Write something...."></textarea>
                                                <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-account-circle"></i></a>
                                                        <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-map-marker"></i></a>
                                                        <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-camera"></i></a>
                                                        <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-emoticon-outline"></i></a>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-dark waves-effect">Post</button>
                                                </div>
                                            </form>
                                        </div> <!-- end .border-->
                                        <!-- end comment box -->

                                        <!-- Story Box-->
                                        <div class="border border-light rounded p-2 mb-3">
                                            <div class="media">
                                                <img class="mr-2 rounded-circle" src="/assets/images/users/avatar-3.jpg"
                                                     alt="Generic placeholder image" height="32">
                                                <div class="media-body">
                                                    <h5 class="m-0">Jeremy Tomlinson</h5>
                                                    <p class="text-muted"><small>about 2 minuts ago</small></p>
                                                </div>
                                            </div>
                                            <p>Story based around the idea of time lapse, animation to post soon!</p>

                                            <img src="/assets/images/small/small-1.jpg" alt="post-img" class="rounded mr-1"
                                                 height="60" />
                                            <img src="/assets/images/small/small-2.jpg" alt="post-img" class="rounded mr-1"
                                                 height="60" />
                                            <img src="/assets/images/small/small-3.jpg" alt="post-img" class="rounded"
                                                 height="60" />

                                            <div class="mt-2">
                                                <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                        class="mdi mdi-reply"></i> Reply</a>
                                                <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                        class="mdi mdi-heart-outline"></i> Like</a>
                                                <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                        class="mdi mdi-share-variant"></i> Share</a>
                                            </div>
                                        </div>

                                        <!-- Story Box-->
                                        <div class="border border-light rounded p-2 mb-3">
                                            <div class="media">
                                                <img class="mr-2 rounded-circle" src="/assets/images/users/avatar-4.jpg"
                                                     alt="Generic placeholder image" height="32">
                                                <div class="media-body">
                                                    <h5 class="m-0">Thelma Fridley</h5>
                                                    <p class="text-muted"><small>about 1 hour ago</small></p>
                                                </div>
                                            </div>
                                            <div class="font-16 text-center font-italic text-dark">
                                                <i class="mdi mdi-format-quote-open font-20"></i> Cras sit amet nibh libero, in
                                                gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras
                                                purus odio, vestibulum in vulputate at, tempus viverra turpis. Duis
                                                sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper
                                                porta. Mauris massa.
                                            </div>

                                            <div class="mx-n2 p-2 mt-3 bg-light">
                                                <div class="media">
                                                    <img class="mr-2 rounded-circle" src="/assets/images/users/avatar-3.jpg"
                                                         alt="Generic placeholder image" height="32">
                                                    <div class="media-body">
                                                        <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted">3 hours ago</small></h5>
                                                        Nice work, makes me think of The Money Pit.

                                                        <br/>
                                                        <a href="javascript: void(0);" class="text-muted font-13 d-inline-block mt-2"><i
                                                                class="mdi mdi-reply"></i> Reply</a>

                                                        <div class="media mt-3">
                                                            <a class="pr-2" href="#">
                                                                <img src="/assets/images/users/avatar-4.jpg" class="rounded-circle"
                                                                     alt="Generic placeholder image" height="32">
                                                            </a>
                                                            <div class="media-body">
                                                                <h5 class="mt-0">Thelma Fridley <small class="text-muted">5 hours ago</small></h5>
                                                                i'm in the middle of a timelapse animation myself! (Very different though.) Awesome stuff.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="media mt-2">
                                                    <a class="pr-2" href="#">
                                                        <img src="/assets/images/users/avatar-1.jpg" class="rounded-circle"
                                                             alt="Generic placeholder image" height="32">
                                                    </a>
                                                    <div class="media-body">
                                                        <input type="text" id="simpleinput" class="form-control border-0 form-control-sm" placeholder="Add comment">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <a href="javascript: void(0);" class="btn btn-sm btn-link text-danger"><i
                                                        class="mdi mdi-heart"></i> Like (28)</a>
                                                <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                        class="mdi mdi-share-variant"></i> Share</a>
                                            </div>
                                        </div>

                                        <!-- Story Box-->
                                        <div class="border border-light p-2 mb-3">
                                            <div class="media">
                                                <img class="mr-2 rounded-circle" src="/assets/images/users/avatar-6.jpg"
                                                     alt="Generic placeholder image" height="32">
                                                <div class="media-body">
                                                    <h5 class="m-0">Martin Williamson</h5>
                                                    <p class="text-muted"><small>15 hours ago</small></p>
                                                </div>
                                            </div>
                                            <p>The parallax is a little odd but O.o that house build is awesome!!</p>

                                            <iframe src='https://player.vimeo.com/video/87993762' height='300' class="img-fluid border-0"></iframe>
                                        </div>

                                        <div class="text-center">
                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                                        </div>

                                    </div>
                                    <!-- end timeline content-->

                                    <div class="tab-pane" id="settings">
                                        <form>
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="userbio">Bio</label>
                                                        <textarea class="form-control" id="userbio" rows="4" placeholder="Write something..."></textarea>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Email Address</label>
                                                        <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                                        <span class="form-text text-muted"><small>If you want to change email please <a href="javascript: void(0);">click</a> here.</small></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userpassword">Password</label>
                                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                                        <span class="form-text text-muted"><small>If you want to change password please <a href="javascript: void(0);">click</a> here.</small></span>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building mr-1"></i> Company Info</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyname">Company Name</label>
                                                        <input type="text" class="form-control" id="companyname" placeholder="Enter company name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cwebsite">Website</label>
                                                        <input type="text" class="form-control" id="cwebsite" placeholder="Enter website url">
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth mr-1"></i> Social</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-fb">Facebook</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-fb" placeholder="Url">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-tw">Twitter</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-tw" placeholder="Username">
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-insta">Instagram</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-insta" placeholder="Url">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-lin">Linkedin</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-lin" placeholder="Url">
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-sky">Skype</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-sky" placeholder="@username">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="social-gh">Github</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="mdi mdi-github-circle"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="social-gh" placeholder="Username">
                                                        </div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end settings content-->

                                </div> <!-- end tab-content -->
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

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

</body>
</html>
