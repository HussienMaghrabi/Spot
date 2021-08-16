<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        @if(App::getLocale() == 'ar')
                            <strong>
                                <span class="text-dark-75"> حقوق الملكية &copy; {{\Carbon\Carbon::now()->year}}</span>
                                <a href="https://glitchfix.net/" target="_blank" class="text-dark-75 text-hover-primary">Glitch fix</a>
                            </strong>
                            .جميع الحقوق محفوظة
                        @else
                            All rights reserved.
                            <strong>
                                <a href="https://glitchfix.net/" target="_blank" class="text-dark-75 text-hover-primary">Glitch fix</a>
                                <span class="text-dark-75"> Copyright &copy; {{\Carbon\Carbon::now()->year}}</span>
                            </strong>
                        @endif

                    </div>
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark">
                        <a href="https://glitchfix.net/about/" target="_blank" class="nav-link pl-0 pr-5 text-dark-75 text-hover-primary">{{__('dashboard.About')}}</a>

                        <a href="https://glitchfix.net/contact/" target="_blank" class="nav-link pl-0 pr-0 text-dark-75 text-hover-primary" style="margin-right: 12px;">{{__('dashboard.Contact')}}</a>
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>



