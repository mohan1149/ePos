@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_category') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/categories/{{ $category->id }}/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category_name">{{ __('t.category_name') }}</label>
                                    <input value="{{ $category->category }}" type="text" id="category_name"
                                        name="category_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('category_branch', $branches, $category->branch, ['class' => 'form-control category_branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="category_image" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('service_category', __('t.service_category')) }}
                                    {{ Form::checkbox('service_category',null, $category->type == 1 ? true : false) }}
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
