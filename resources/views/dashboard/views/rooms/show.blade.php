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
                            <a href="{{ url(App::getLocale().'/dashboard/rooms/'.$data->id.'/edit/name' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Description') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->desc }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.room_owner') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->user->name }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.pinned') }}</strong>
                        </th>
                        @if($data->pinned == 1)
                            <td class="d-flex">{{ __('dashboard.pinned') }}</td>
                        @else
                            <td class="d-flex">{{ __('dashboard.unpinned') }}</td>
                        @endif
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/rooms/'.$data->id.'/edit/pin' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.lang') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->lang }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.join_fees') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->join_fees }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Category') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->category->name }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Country') }}</strong>
                        </th>
                        <td class="d-flex">{{ $data->country->name }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Image') }}</strong>
                        </th>
                        <td class="d-flex">
                            @if($data->main_image == NULL)
                                <i class="fa fa-fw fa-image"> </i>
                            @else
                                <a href="#" data-toggle="modal" data-target="#img_modal_{{$data->id}}" title="Photo">
                                    <i class="fa fa-fw fa-image text-primary"> </i>
                                </a>
                                @include('dashboard.components.imageModal', ['id' => $data->id,'img' => $data->getImageAttribute($data->main_image)])
                            @endif
                        </td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/rooms/'.$data->id.'/edit/image' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning d-flex"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong class="d-flex">{{   __('dashboard.Background') }}</strong>
                        </th>
                        <td class="d-flex">
                            @if($data->background == NULL)
                                <i class="fa fa-fw fa-image"> </i>
                            @else
                                <a href="#" data-toggle="modal" data-target="#img_modal_{{$data->id}}" title="Photo">
                                    <i class="fa fa-fw fa-image text-primary"> </i>
                                </a>
                                @include('dashboard.components.imageModal', ['id' => $data->id,'img' => $data->getImageAttribute($data->background)])
                            @endif
                        </td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit d-flex"></i></a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
