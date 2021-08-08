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
        <div style="overflow:hidden; ">



            <div style="float:left;">
                @include('dashboard.includes.sidemenu')
            </div>
                <div class="content-wrapper" >
                    @yield('content')
                </div>

        </div>


        <!-- Content Wrapper. Contains page content -->


        <!-- /.content-wrapper -->
        @include('dashboard.includes.footer')



    <!-- ./wrapper -->


    @include('dashboard.includes.scripts')
        @yield('scripts')
        @include('flashy::message')
    </body>
</html>
