@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_slider') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/sliders/{{ $slider->id }}/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_caption">{{ __('t.slider_caption') }}</label>
                                    <input value="{{ $slider->slider_caption }}" type="text" id="slider_caption"
                                        name="slider_caption" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_text">{{ __('t.slider_text') }}</label>
                                    <input value="{{ $slider->slider_text }}" type="text" id="slider_text"
                                        name="slider_text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slider_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('slider_branch', $branches, $slider->branch, ['class' => 'form-control slider_branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category">{{ __('t.category') }}</label>
                                    {{ Form::select('category', $categories, $slider->category_id, ['class' => 'form-control product_category', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('published', __('t.published')) }}
                                    {{ Form::checkbox('published',null, $slider->published == 1 ? true : false) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="slider_image" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('t.update') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            $(".slider_branch").on('change', () => {
                let bid = $(".slider_branch").val();
                let url = '/api/categories-and-brands-by-branch/' + bid;
                $.ajax({
                    url: url,
                    success: function(result) {
                        $('.product_category').empty();
                        let categories = "";
                        let brands = "";
                        result.categories.forEach((category) => {
                            categories += "<option value=" + category.id + ">" +
                                category.category + "</option>";
                        });
                        $('.product_category').append(categories);
                    }
                });

            });
        });
    </script>
@endsection