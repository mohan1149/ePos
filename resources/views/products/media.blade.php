@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.product_images') }}</h4>
                </div>
                <div class="card-body">
                    @php
                        $images = json_decode($product->product_images);
                        $images = $images === null ? [] : $images;
                    @endphp
                    <form action="/products/{{ $product->id }}/media" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p2">
                            <input type="hidden" id="existing_media" name="existing_media"
                                value="{{ $product->product_images }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product_images">{{ __('t.product_images') }}</label>
                                    {{ Form::file('product_images[]', ['class' => 'form-control', 'multiple']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('append', __('t.append_images')) }}
                                    {{ Form::checkbox('append', 1, true, ['class' => 'append']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit(__('t.update'), ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                    <h5>{{ __('t.existing_images') }}</h5>
                    <div class="row p-4">
                        @foreach ($images as $key => $item)
                            <div class="col-md-2 media-image-{{ $key }}">
                                <div class="product_media_conatiner">
                                    <button id="media-close-{{ $key }}" accessKey="{{ $key }}" url="{{ $item }}"
                                        class="btn btn-danger media-close">x</button>
                                    <img src="{{ $item }}" alt="image" width="100%">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.media-close').on('click', (e) => {
                let accessKey = e.target.accessKey;
                $('.media-image-' + accessKey).remove();
                let existing_images = $('#existing_media').val();
                existing_images = existing_images === null ? [] : JSON.parse(existing_images);
                let current_source = $(e.target).attr('url');
                existing_images = existing_images.filter((item) => item !== current_source);
                $('#existing_media').val(JSON.stringify(existing_images));
            });
        });
    </script>
@endsection
