@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_service') }}</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('t.name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{$service->name}}"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="price">{{ __('t.price') }}</label>
                                    <input type="price" id="price" name="price" class="form-control" required value="{{ $service->price }}"> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('branch', $branches, $service->branch, ['class' => 'form-control branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category">{{ __('t.category') }}</label>
                                    {{ Form::select('category', $categories, $service->category, ['class' => 'form-control category', 'required ']) }}

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="service_image" class="form-control">
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

            $(".branch").on('change', () => {
                let bid = $(".branch").val();
                let url = '/api/service-categories-by-branch';
                $.ajax({
                    url: url,
                    method:'POST',
                    data:{
                        bid:bid,
                    },
                    success: function(result) {
                        $('.category').empty();
                        let categories = "";
                        let brands = "";
                        result.categories.forEach((category) => {
                            categories += "<option value=" + category.id + ">" +
                                category.category + "</option>";
                        });
                        $('.category').append(categories);
                    }
                });

            });
        });
    </script>
@endsection
