<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="PIXINVENT">
    <title>Ecommerce</title>
    @include('layouts.includes.head-scripts')
    @include('layouts.includes.styles')
    <!-- END: Custom CSS-->
    @vite('resources/js/app.js')


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">


    <!-- BEGIN: Header-->
    @include('layouts.includes.navbar')

    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @include('layouts.includes.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Data list view starts -->
                @yield('content')
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->



    <!-- BEGIN: Footer-->
    @include('layouts.includes.footer')
    <!-- END: Footer-->

    @include('layouts.includes.scripts')

    @stack('scripts')
</body>
<!-- END: Body-->

</html>
