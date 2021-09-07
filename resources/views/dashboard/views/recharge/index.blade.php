@php
        $headers = [
                $resource['header'] => '#'
            ];
        $tableCols = [
             __('dashboard.total_charging'),
             __('dashboard.total_chargingMonth'),
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
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">
                @if(count($data) == 0)
                    <div class="col-xs-12">
                        <h4> {{ __('dashboard.No Data') }}</h4>
                        <p>{{ __('dashboard.Add Link') }}  <b><a href="{{route($resource['route'].'.create', App::getLocale())}}">{{ __('dashboard.here') }}</a></b>.</p>
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
                        <tr class="tr">
                            <td>{{ $item->all }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
@endsection
