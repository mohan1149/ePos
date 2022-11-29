@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_tag') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/tags" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tag_name">{{ __('t.tag_name') }}</label>
                                    <input type="text" id="tag_name" name="tag_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('branch', $branches, null, ['class' => 'form-control branch', 'required']) }}
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
