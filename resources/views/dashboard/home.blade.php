@php
$headers = [
        $resource['header'] => '#',
    ];
     $boxes = [
                [
                    'title' => __('dashboard.ADMINS'),
                    'icon'  => 'user-secret',
                    'color' => 'aqua',
                    'data'  => $statistics['admins'],
                    'route' => 'admin.admins'
                ],
                [
                    'title' => __('dashboard.USERS'),
                    'icon'  => 'users',
                    'color' => 'aqua',
                    'data'  => $statistics['users'],
                    'route' => 'admin.users'
                ],

 ];


@endphp
@extends('dashboard.layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
    @include('dashboard.components.header',$resource)
    <section class="content" >
        <div class="row">
            @foreach ($boxes as $box)
                <a href="{{ route($box['route'].'.index', App::getLocale()) }}">
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 26-->
                        <div class="card card-custom bg-info card-stretch gutter-b">
                            <!--begin::ody-->
                            <div class="card-body">
                            <span class="svg-icon svg-icon-2x svg-icon-danger">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                               <i class="fa fa-{{$box['icon']}}"></i>
                                <!--end::Svg Icon-->
                            </span>
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$box['data']}}</span>
                                <a class="font-weight-bold text-muted font-size-sm">{{$box['title']}}</a>
                            </div>
                            <a href="{{ route($box['route'].'.index', App::getLocale()) }}"></a>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 26-->
                    </div>
                </a>

            @endforeach
        </div>
    </section>
@endsection
