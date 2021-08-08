@php

    $items = [
          [
            'route' => 'admin.home',
            'icon'  => 'database',
            'title' => __('dashboard.DASHBOARD')
          ],
          [
            'route' => 'admin.users.index',
            'icon'  => 'users',
            'title' => __('dashboard.USERS')
          ],
];
@endphp

<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500" style="width: 265px;height: 520px;">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            @foreach ($items as $item)
                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="{{ $item['route'] == NULL ? '#' : route($item['route'], App::getLocale()) }}" class="menu-link menu-toggle">
                        <i class="fa fa-{{$item['icon']}}" style="margin: 10px;" >
                            <span></span>
                        </i>
                        <span class="menu-text">{{ $item['title'] }} </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
