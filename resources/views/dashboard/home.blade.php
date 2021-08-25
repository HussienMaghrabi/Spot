@php
$headers = [
        $resource['header'] => '#',
    ];
 if ( Auth::guard('admin')->user()->super == 1){
      $boxes = [
          [
              'title' => __('dashboard.ADMINS'),
              'icon'  => 'user-secret',
              'data'  => $statistics['admins'],
              'route' => 'admin.admins'
          ],
          [
             'title' => __('dashboard.USERS'),
             'icon'  => 'users',
             'data'  => $statistics['users'],
             'route' => 'admin.users'
          ],
          [
             'title' => __('dashboard.VIP_USERS'),
             'icon'  => 'user-circle',
             'data'  => $statistics['vip_users'],
             'route' => 'admin.vip-users'
          ],
          [
             'title' => __('dashboard.BANS'),
             'icon'  => 'ban',
             'data'  => $statistics['bans'],
             'route' => 'admin.bans'
          ],
          [
             'title' => __('dashboard.SUSPENDS'),
             'icon'  => 'times',
             'data'  => $statistics['suspends'],
             'route' => 'admin.suspends'
          ],
          [
             'title' => __('dashboard.ROOMS'),
             'icon'  => 'desktop',
             'data'  => $statistics['rooms'],
             'route' => 'admin.rooms'
          ],
          [
             'title' => __('dashboard.ITEMS'),
             'icon'  => 'bookmark',
             'data'  => $statistics['items'],
             'route' => 'admin.items'
          ],
      ];
 }else{
      $boxes = [
          [
             'title' => __('dashboard.USERS'),
             'icon'  => 'users',
             'data'  => $statistics['users'],
             'route' => 'admin.users'
          ],
          [
             'title' => __('dashboard.VIP_USERS'),
             'icon'  => 'user-circle',
             'data'  => $statistics['vip_users'],
             'route' => 'admin.vip-users'
          ],
          [
             'title' => __('dashboard.BANS'),
             'icon'  => 'ban',
             'data'  => $statistics['bans'],
             'route' => 'admin.bans'
          ],
          [
             'title' => __('dashboard.SUSPENDS'),
             'icon'  => 'times',
             'data'  => $statistics['suspends'],
             'route' => 'admin.suspends'
          ],
          [
             'title' => __('dashboard.ROOMS'),
             'icon'  => 'desktop',
             'data'  => $statistics['rooms'],
             'route' => 'admin.rooms'
          ],
          [
             'title' => __('dashboard.ITEMS'),
             'icon'  => 'bookmark',
             'data'  => $statistics['items'],
             'route' => 'admin.items'
          ],
      ];
 }



@endphp
@extends('dashboard.layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
    <section class="content" >
                <div class="row">
                    @foreach ($boxes as $box)
                        <div class="col-lg-3 col-xs-6" >
                            <a href="{{ route($box['route'].'.index', App::getLocale()) }}">
                                <div class="card card-custom  gutter-b" >
                                    <div class="card-body d-flex flex-column ">

                                            <div class="icon svg-icon svg-icon-3 svg-icon-info" style="width:50px;height:24px;">

                                                <i class="d-flex fa fa-{{$box['icon']}} "></i>
                                            </div>
                                            <div class="inner">
                                                <div class="d-flex text-dark font-weight-bolder font-size-h2 mt-3">{{$box['data']}}</div>
                                                <p class="d-flex text-dark-50 font-weight-bold">{{$box['title']}}</p>
                                            </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
    </section>
@endsection

