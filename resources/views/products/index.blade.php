@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary d-flex align-items-align-center">
                    <h4 class="card-title">{{ __('t.products') }}</h4>
                    <a class="btn btn-info" href="/products/create">{{__("t.add_product")}}</a>
                </div>
                <div class="card-body">
                    @php
                    $settings = session('settings');
                @endphp
                    <div class="table-responsive">
                        <table class="table" id="productsTable">
                            <thead>
                                <th>{{ __('t.image') }}</th>
                                <th>{{ __('t.name') }}</th>
                                <th>{{ __('t.sku') }}</th>
                                <th>{{ __('t.price') }}</th>
                                <th>{{ __('t.cost_price') }}</th>
                                <th>{{ __('t.stock_item') }}</th>
                                <th>{{ __('t.stock') }}</th>
                                <th>{{ __('t.featured') }}</th>
                                <th>{{ __('t.sale_count') }}</th>
                                <th>{{ __('t.branch') }}</th>
                                <th>{{ __('t.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><img src="{{ $product->product_image }}" alt="image" width="70px"
                                                height="70px"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ number_format($product->price,$settings->decimal_points) }}</td>
                                        <td>{{ number_format($product->cost_price,$settings->decimal_points) }}</td>
                                        <td>
                                            @if ($product->stock_item == 1)
                                                <span class="badge badge-primary">{{ __('t.yes') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('t.no') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            @if ($product->featured == 1)
                                                <span class="badge badge-primary">{{ __('t.yes') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('t.no') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->sale_count }}</td>
                                        <td>{{ $product->product_branch }}</td>

                                        <td>
                                            <a href="/products/{{ $product->id }}/edit" rel="noopener noreferrer">
                                                <i class="material-icons">edit</i>

                                            </a>
                                            <a href="/products/{{ $product->id }}/media" rel="noopener noreferrer">
                                                <i class="material-icons">perm_media</i>

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
            $('#productsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [    
                {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 9]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                ]
            });
        });
    </script>
@endsection
