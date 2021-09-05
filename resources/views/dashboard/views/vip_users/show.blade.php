@php
    $headers = [
            $resource['header'] => '#'
        ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('content')
    <div class="card card-custom">
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">
                <thead>
                    <tr>
                        <th>
                            <strong class="d-flex">{{  __('dashboard.Name') }}</strong>
                        </th>
                        <td  class="d-flex">{{ $data->name }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/name' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    @if( Auth::guard('admin')->user()->super == 1)
                        <tr>
                            <th>
                                <strong class="d-flex">{{   __('dashboard.Special') }}</strong>
                            </th>
                            <td class="d-flex">{{ $data->special_id }}</td>
                            <td>
                                @if( Auth::guard('admin')->user()->super == 1)
                                <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/special_id' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                                @else
                                    <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <strong class="d-flex">{{   __('dashboard.Coins') }}</strong>
                            </th>
                            <td class="d-flex">{{ $data->coins }}</td>
                            <td>
                                @if( Auth::guard('admin')->user()->super == 1)
                                <a href="#" data-toggle="modal" data-target="#check-modal" title="Edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                                @include('dashboard.components.checkVipUserModal', [ 'id' => $data->id, 'resource' => $resource['route']])
                                @else
                                    <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <strong class="d-flex">{{   __('dashboard.Gems') }}</strong>
                            </th>
                            <td class="d-flex">{{ $data->gems }}</td>
                            <td>
                                @if( Auth::guard('admin')->user()->super == 1)
                                    <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/reduce_diamond' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                                @else
                                    <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <strong class="d-flex">{{   __('dashboard.Freeze') }}</strong>
                            </th>
                            @if($data->freeze_gems == 1)
                                <td class="d-flex">{{ __('dashboard.Freeze') }}</td>
                            @else
                                <td class="d-flex">{{ __('dashboard.notFreeze') }}</td>
                            @endif
                            <td>
                                <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/freeze' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Gender') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->gender }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/gender' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Image') }}</strong>
                        </th>
                        <td class="d-flex">
                            @if($data->profile_pic == NULL)
                                <i class="fa fa-fw fa-image"> </i>
                            @else
                                <a href="#" data-toggle="modal" data-target="#img_modal_{{$data->id}}" title="Photo">
                                    <i class="fa fa-fw fa-image text-primary"> </i>
                                </a>
                                @include('dashboard.components.imageModal', ['id' => $data->id,'img' => $data->getImageAttribute($data->profile_pic)])
                            @endif
                        </td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/image' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.vip_role') }}</strong>
                        </th>
                        @if($data->vip_role == NULL)
                            <td class="d-flex">{{ __('dashboard.No Data') }}</td>
                        @else
                            <td class="d-flex">{{ $data->vip->name }}</td>
                        @endif
                        <td>
                            @if( Auth::guard('admin')->user()->super == 1)
                                <a href="{{ url(App::getLocale().'/dashboard/vip-users/'.$data->id.'/edit/vip_role' ) }}" title="Add"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                            @else
                                <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                            @endif
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
