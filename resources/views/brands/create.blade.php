@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_brand') }}</h4>
                    <p class="card-category">{{ __('t.all_are_mandatory') }}</p>
                </div>
                <div class="card-body">
                    <form action="/brands" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="brand_name">{{ __('t.brand_name') }}</label>
                                    <input type="text" id="brand_name" name="brand_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    <select name="branch" class="form-control" required>
                                        @foreach ($branches as $key => $branch)
                                            <option value="{{ $key }}">{{$branch}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="avatar" class="form-control" required>
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
