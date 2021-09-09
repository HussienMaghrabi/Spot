@php
    use Illuminate\Pagination\Paginator;
        $headers = [
                $resource['header'] => '#'
            ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('styles')<link rel="stylesheet" href="{{ asset('storage/assets/admin/css/image.css') }}">@endsection
@section('content')
    <div class="card card-custom">

        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="box-title"><i class="fa fa-fw fa-{{$resource['icon']}}"> </i> {{__('dashboard.'.$resource['header'])}}</h3>
            </div>
            <div class="card-toolbar">
{{--                <form class="input-group input-group-sm"  action="{{route($resource['route'].'.search', ['lang' => App::getLocale()])}}" method="post">--}}
                    @csrf
                    <input type="text" name="text" class="form-control pull-right" placeholder="{{__('dashboard.Search')}}" style="height: 35px;width: 150px;">
                    <button type="submit" class="btn btn-default" title="Search"><i class="fa fa-search"></i></button>
                     <a  href="{{route($resource['route'].'.create', ['lang' => App::getLocale(),$value])}}" class="btn btn-default" title="New Item"><i class="fa fa-plus"></i></a>
                     <a href="#" class="btn btn-default delete_all disabled" data-toggle="modal" data-target="#danger_all" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>
{{--                </form>--}}
                @include('dashboard.components.dangerModalMulti')
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding" style="child-align: right">
            @if(count($data) == 0)
                <div class="col-xs-12">
                    <h4> {{ __('dashboard.No Data') }}</h4>
                    <p>{{ __('dashboard.Add Link') }}  <b><a href="{{route($resource['route'].'.create', [App::getLocale(),$value])}}">{{ __('dashboard.here') }}</a></b>.</p>
                </div>
            @else<br>
            {!! Form::open(['method'=>'DELETE', 'route'=> [$resource['route'].'.multiDelete', App::getLocale(),$value], 'class'=>'delete-form'])!!}
            <div class="row">
                @foreach($data as $item)
                    <div class="col-md-2 image-{{$item->id}}">
                        <div class="text-center" style="margin-top: 5px">
                            <input type="checkbox" class="sub_chk" name="checked[]" value="{{$item->id}}">
                        </div>
                        <div class="text-center" style="margin-top: 5px">
                            <span>{{$item->name}}</span>
                        </div>
                        <figure class="snip0013">
                            <img src="{{ $item->image }}" height="150px" width="150px" alt="sample32"/>
                            <div>
{{--                                <a href="{{ route($resource['route'].'.edit', [App::getLocale(), $item->id]) }}"><i class="fa fa-edit left-icon"></i></a>--}}
                                <a href="#"data-toggle="modal" data-target="#danger_{{$item->id}}"><i class="fa fa-trash right-icon"></i></a>
                            </div>
                        </figure>
                    </div>
                    @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id,'value' => $value, 'resource' => $resource['route']])
                @endforeach<br>
            </div>
            {!! Form::close()!!}
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center" style="margin-top: 2%;">
        {{$data->links(Paginator::useBootstrap())}}
    </div>


@endsection
