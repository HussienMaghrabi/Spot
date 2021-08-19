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
                            <strong>{{  __('dashboard.Name') }}</strong>
                        </th>
                        <td>{{ $data->name }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/users/'.$data->id.'/edit/name' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Email') }}</strong>
                        </th>
                        <td>{{ $data->email }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Birth') }}</strong>
                        </th>
                        <td>{{ $data->birth_date }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Special') }}</strong>
                        </th>
                        <td>{{ $data->special_id }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/users/'.$data->id.'/edit/special_id' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Description') }}</strong>
                        </th>
                        <td>{{ $data->desc }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Coins') }}</strong>
                        </th>
                        <td>{{ $data->coins }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/users/'.$data->id.'/edit/coins' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Gems') }}</strong>
                        </th>
                        <td>{{ $data->gems }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.User_level') }}</strong>
                        </th>
                        <td>{{ $data->User_level }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Karizma_level') }}</strong>
                        </th>
                        <td>{{ $data->karizma_level }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Gender') }}</strong>
                        </th>
                        <td>{{ $data->gender }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/dashboard/users/'.$data->id.'/edit/gender' ) }}" title="edit"><i class="fa fa-fw fa-edit text-warning"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Country') }}</strong>
                        </th>
                        <td>{{ $data->country->name }}</td>
                        <td>
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <strong>{{   __('dashboard.Image') }}</strong>
                        </th>
                        <td>
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
                            <a href="#" title="edit"><i class="fa fa-fw fa-edit"></i></a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
