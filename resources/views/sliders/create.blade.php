@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_slider') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/sliders/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_caption">{{ __('t.slider_caption') }}</label>
                                    <input type="text" id="slider_caption" name="slider_caption" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_text">{{ __('t.slider_text') }}</label>
                                    <input type="text" id="slider_text" name="slider_text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slider_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('branch', $branches, null, ['class' => 'form-control slider_branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category">{{ __('t.category') }}</label>
                                    {{ Form::select('category', [], null, ['class' => 'form-control product_category', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('featured', __('t.featured')) }}
                                    {{ Form::checkbox('published', null, true) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="slider_image" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('t.add') }}">
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
