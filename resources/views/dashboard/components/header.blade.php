<section class="content-header">
    <h1>
        <small>
            {{ '.' }}
        </small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href=" {{ route('admin.home', App::getLocale()) }} ">
                <i class="fa fa-{{$resource['icon']}}"></i>
                {{__('dashboard.Home')}}
            </a>
        </li>

        @foreach ($headers as $item => $route)
            @if($loop->last)
                <li class="active">{{__('dashboard.' . $item)}}</li>
            @else
                <li>
                    <a href=" {{ route($route, App::getLocale()) }} ">
                        {{__('dashboard.' . $item)}}
                    </a>
                </li>
            @endif
        @endforeach

    </ol>
</section>
