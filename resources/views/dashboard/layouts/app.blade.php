<!DOCTYPE html>
@if(App::getLocale() == 'ar')
<html lang="ar" dir="rtl">
@else
<html lang="ar">
@endif
    <head><base href="">
        <meta charset="utf-8" />
        <title>{{ __('dashboard.APP_Name') }} - @yield('title')</title>
        <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        @include('dashboard.includes.styles')
        @yield('styles')
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                @include('dashboard.includes.sidemenu')
                @if(App::getLocale() == 'ar')
                    <div class="d-flex flex-column flex-row-fluid wrapper " id="kt_wrapper" style="padding-right: 265px; padding-left: 0px;">
                @else
                    <div class="d-flex flex-column flex-row-fluid wrapper " id="kt_wrapper">
                @endif
                    @include('dashboard.includes.navbar')
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="d-flex flex-column-fluid">
                            <div class="container">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    @include('dashboard.includes.footer')
                </div>
            </div>
        </div>


        <!-- Content Wrapper. Contains page content -->


        <!-- /.content-wrapper -->




    <!-- ./wrapper -->


        @include('dashboard.includes.scripts')
        @yield('scripts')
        @include('flashy::message')
    </body>
</html>
