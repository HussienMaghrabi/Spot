@php
    use Illuminate\Pagination\Paginator;
       $headers = [
               $resource['header'] => '#'
           ];
       $tableCols = [
             __('dashboard.Name'),
             __('dashboard.Image'),
             __('dashboard.Price'),
             __('dashboard.Category'),
             __('dashboard.Duration'),
       ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('content')
    <div class="card card-custom">

        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="box-title"><i class="fa fa-fw fa-{{$resource['icon']}}"> </i> {{__('dashboard.'.$resource['header'])}}</h3>
            </div>
            <div class="card-toolbar">
                <form class="input-group input-group-sm"  action="#" method="post">
                    @csrf
                    <input type="text" name="text" class="form-control pull-right" placeholder="{{__('dashboard.Search')}}" style="height: 35px;width: 150px;">
                    <button type="submit" class="btn btn-default" title="Search"><i class="fa fa-search"></i></button>
                    <a  href="{{route($resource['route'].'.create', ['lang' => App::getLocale(), $value])}}" class="btn btn-default" title="New Item"><i class="fa fa-plus"></i></a>
                </form>
                @include('dashboard.components.dangerModalMulti')
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['method'=>'DELETE'])!!}
            @if(count($data) == 0)
                <div class="col-xs-12">
                    <h4 class="d-flex"> {{ __('dashboard.No Data') }}</h4>
                    <div class="d-flex">
                        <p>{{ __('dashboard.Add Link') }}  <b><a href="{{route($resource['route'].'.create', [App::getLocale(), $value])}}">{{ __('dashboard.here') }}</a></b>.</p>
                    </div>
                </div>
            @else
                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">
                    <thead>
                    <tr>
                        @foreach($tableCols as $col)
                            <td><strong>{{ $col }}</strong></td>
                        @endforeach
                        <td><strong>{{__('dashboard.Actions')}}</strong></td>
                        {{--<td><strong><input type="checkbox" id="master"></strong></td>--}}

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr class="tr-{{ $item->id }}">
                            <td>{{ $item->item->name }}</td>
                            <td>
                                @if($item->item->img_link == NULL)
                                    <i class="fa fa-fw fa-image"> </i>
                                @else
                                    <a href="#" data-toggle="modal" data-target="#img_modal_{{$item->item->id}}" title="Photo">
                                        <i class="fa fa-fw fa-image text-primary"> </i>
                                    </a>
                                    @include('dashboard.components.imageModal', ['id' => $item->item->id,'img' => $item->getImageAttribute($item->item->img_link)])
                                @endif
                            </td>
                            <td>{{ $item->item->price }}</td>
                            <td>{{ $item->item->category['name_'.App::getLocale()] }}</td>
                            <td>{{ $item->item->duration }}</td>
                            <td>
                                {{-- <a href="{{ route($resource.'.show', $item->id) }}" title="show"><i class="fa fa-fw fa-eye text-light-blue"></i></a> --}}
{{--                                <a href="{{ route($resource['route'].'.edit', [App::getLocale(), $item->id]) }}" title="edit"><i class="fa fa-fw fa-edit text-yellow"></i></a>--}}
                                <a href="#" data-toggle="modal" data-target="#danger_{{$item->id}}" title="Delete"><i class="fa fa-fw fa-trash text-danger"></i></a>

                            </td>
                        </tr>
                        @include('dashboard.components.dangerModal', ['user_name' => $item->item->name, 'id' => $item->id,'value' => $value, 'resource' => $resource['route']])
                    @endforeach

                    </tbody>
                </table>
            @endif
            {!! Form::close()!!}


        </div>
    </div>
    <div class="d-flex justify-content-center" style="margin-top: 2%;">
        {{$data->links(Paginator::useBootstrap())}}
    </div>


@endsection
