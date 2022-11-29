@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.sliders') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="slidersTable">
                            <thead>
                                <th>{{ __('t.image') }}</th>
                                <th>{{ __('t.slider_caption') }}</th>
                                <th>{{ __('t.slider_text') }}</th>
                                <th>{{ __('t.branch') }}</th>
                                <th>{{ __('t.category') }}</th>
                                <th>{{ __('t.published') }}</th>
                                <th>{{ __('t.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                        <td><img src="{{ $slider->slider_image }}" alt="image" width="70px"
                                                height="70px"></td>
                                        <td>{{ $slider->slider_caption }}</td>
                                        <td>{{ $slider->slider_text }}</td>
                                        <td>{{ $slider->branch }}</td>
                                        <td>{{ $slider->category }}</td>
                                        <td>
                                            @if ($slider->published == 1)
                                                <span class="badge badge-primary">{{ __('t.yes') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('t.no') }}</span>
                                            @endif
                                        </td>

                                        <td><a href="/sliders/{{ $slider->id }}/edit"
                                                rel="noopener noreferrer">{{ __('t.edit') }}</a></td>
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
            $('#slidersTable').DataTable();
        });
    </script>
@endsection
