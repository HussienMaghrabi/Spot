@php
    $headers = [
            $resource['header'] => $resource['route'].'.index',
            $resource['action'] => '#',
    ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('content')
    <div class="card card-custom gutter-b example example-compact" style="margin-right: 15px;">
        @if($iid == 'name')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.name', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'special_id')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.special_id', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'coins')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.coins', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'gender')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.gender', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'recharge_no_level')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.recharge_no_level', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'recharge_with_level')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.recharge_with_level', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'reduce_coins')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.reduce_coins', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'reduce_diamond')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.reduce_diamond', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @elseif($iid == 'image')
            {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.image', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
        @endif

        <div class="card-body">
            @include('dashboard.views.' .$resource['view']. '.form')
        </div>
        <div class="card-footer">

            <button type="submit" class="btn btn-primary mr-2">{{__('dashboard.Update')}}</button>
            <a href="{{route($resource['route'].'.index', App::getLocale())}}" class="btn btn-secondary" style="margin-left:10px">{{__('dashboard.Cancel')}}</a>
        </div>
        {!!Form::close()!!}


    </div>
@endsection


