@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary d-flex align-items-align-center">
                    <h4 class="card-title">{{ __('t.services') }}</h4>
                    <a class="btn btn-info" href="/services/create">{{__("t.add_service")}}</a>
                </div>
                <div class="card-body">
                    @php
                    $settings = session('settings');
                @endphp
                    <div class="table-responsive">
                        <table class="table" id="servicesTable">
                            <thead>
                                <th>{{ __('t.image') }}</th>
                                <th>{{ __('t.name') }}</th>
                                <th>{{ __('t.price') }}</th>
                                <th>{{ __('t.branch') }}</th>
                                <th>{{ __('t.category') }}</th>
                                <th>{{ __('t.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td><img src="{{ $service->service_image }}" alt="image" width="70px"
                                                height="70px"></td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ number_format($service->price,$settings->decimal_points) }}</td>
                                        <td>{{ $service->branch }}</td>
                                        <td>{{ $service->category }}</td>

                                        <td>
                                            <a href="/services/{{ $service->id }}/edit" rel="noopener noreferrer">
                                                <i class="material-icons">edit</i>
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
            $('#servicesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [    
                {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                ]
            });
        });
    </script>
@endsection
