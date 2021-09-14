@php
    use Illuminate\Pagination\Paginator;
       $headers = [
               $resource['header'] => '#'
           ];
       $tableCols = [
            __('dashboard.Id'),
            __('dashboard.Name'),
            __('dashboard.Image'),
            __('dashboard.Mute'),

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
            </div>
        </div>
        <div class="card-body">
            @if(count($data) == 0)
                <div class="col-xs-12">
                    <h4> {{ __('dashboard.No Data') }}</h4>
                </div>
            @else
                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">
                    <thead>
                    <tr>
                        @foreach($tableCols as $col)
                            <td><strong>{{ $col }}</strong></td>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr class="tr-{{ $item->user_id }}">
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($item->image == NULL)
                                        <i class="fa fa-fw fa-image"> </i>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#img_modal_{{$item->user_id}}" title="Photo">
                                            <i class="fa fa-fw fa-image text-primary"> </i>
                                        </a>
                                        @include('dashboard.components.imageModal', ['id' => $item->user_id,'img' => $item->image])
                                    @endif
                                </td>
                                <td>
                                    @if($item->mute == false)
                                        {{ __('dashboard.notMute')}}
                                    @else
                                        {{ __('dashboard.Mute'),}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection
