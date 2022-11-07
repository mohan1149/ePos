@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_brand') }}</h4>
                </div>
                <div class="card-body">
                        {!! Form::open(['url'=>'brands/'.$brand->id,'method'=>'PUT','files'=>true]) !!}
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="brand_name">{{ __('t.brand_name') }}</label>
                                    <input value="{{ $brand->name }}" type="text" id="brand_name" name="brand_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brand_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('brand_branch', $branches, $brand->branch, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('t.update') }}">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
