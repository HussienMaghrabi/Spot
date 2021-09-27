@php
    $tableCols = [
         __('dashboard.status'),
         __('dashboard.amount'),
         __('dashboard.date'),
       ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.DIAMOND_HISTORY'))
@section('content')
    <div class="card card-custom">

        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="box-title"><i class="fa fa-fw fa-university"> </i> {{__('dashboard.DiamondHistory')}}</h3>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            @if(count($data) == 0)
                <div class="col-xs-12 d-flex">
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
                        <tr class="tr">
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->date_of_purchase }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif
        </div>
    </div>


@endsection
