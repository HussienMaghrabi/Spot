<!DOCTYPE html>
<html lang="en">
    <head><base href="">
        <meta charset="utf-8" />
        <title>{{ __('dashboard.APP_Name') }} - @yield('title')</title>
        <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        @include('dashboard.includes.styles')
        @yield('styles')
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

        @include('dashboard.includes.navbar')

        <div style="overflow-x: hidden; position: fixed; z-index: 1; float: left">
            @include('dashboard.includes.sidemenu')
        </div>
        <div style="margin-left: 15%;"  class="content-wrapper" >
            @yield('content')
        </div>



        <!-- Content Wrapper. Contains page content -->


        <!-- /.content-wrapper -->
        <div style=" position:absolute; bottom:0; margin-left: 15%; margin-bottom: 10px; width:84%; float: right">
            @include('dashboard.includes.footer')
        </div>



    <!-- ./wrapper -->


    @include('dashboard.includes.scripts')
        @yield('scripts')
        @include('flashy::message')
    </body>
</html>
