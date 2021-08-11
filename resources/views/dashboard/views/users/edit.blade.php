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

        {{ Form::model($item, array('method' => 'PATCH', 'route' => [$resource['route'] . '.update', App::getLocale(), $item->id], 'class' => 'form-horizontal', 'files' => true)) }}
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


