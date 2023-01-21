@extends('layouts.app',['title'=>__("t.monthly_sales")])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.sales') }}</h4>
                    <p><strong>{{__("t.monthly_sales")}}</strong></p>
                </div>
                <div class="card-body">
                    <div class="filters"> 
                        {!! Form::open(['url'=>'/sales','method'=>'GET']) !!}
                            <div class="row">
                                @php
                                    $settings = session('settings');
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="branch">{{__("t.branch")}}</label>
                                        {!! Form::select('branch',$branches,request('branch'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="staff">{{__("t.staff")}}</label>
                                        {!! Form::select('staff',$users,request('staff'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">{{__("t.month")}}</label>
                                        {!! Form::selectMonth('month', request('month'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        {!! Form::submit(__("t.apply"), ['class'=>"btn btn-success"]) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="salesTable">
                            <thead>
                                <th>{{ __('t.order_for') }}</th>
                                <th>{{ __('t.branch') }}</th>
                                <th>{{ __('t.staff') }}</th>
                                <th>{{ __('t.total') }}</th>
                                <th>{{ __('t.discount_percent') }}</th>
                                <th>{{ __('t.discount_amount') }}</th>
                                <th>{{ __('t.final_total') }}</th>
                                <th>{{ __('t.date') }}</th>
                                <th>{{ __('t.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->order_for }}</td>
                                        <td>{{ $sale->branch }}</td>
                                        <td>{{ $sale->name }}</td>
                                        <td>{{  number_format($sale->total,$settings->decimal_points) }}</td>
                                        <td>{{ $sale->discount }}</td>
                                        <td>{{  number_format($sale->discount_amount,$settings->decimal_points) }}</td>
                                        <td>{{  number_format($sale->final_total,$settings->decimal_points) }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                        <td>
                                            <a href="/sales/{{ $sale->id }}" rel="noopener noreferrer">
                                                <i class="material-icons">receipt_long</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#salesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [    
                {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]

                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]

                        }
                    },

                ]
            });
        });
    </script>
@endsection
