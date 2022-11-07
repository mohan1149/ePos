@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_branch') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/branches/{{ $branch->id }}/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name">{{ __('t.branch_name') }}</label>
                                    <input value="{{ $branch->branch }}" type="text" id="branch_name" name="branch_name"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_email">{{ __('t.email') }}</label>
                                    <input value="{{ $branch->email }}" type="text" id="branch_email" name="branch_email" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_phone">{{ __('t.phone') }}</label>
                                    <input value="{{ $branch->phone }}" type="text" id="branch_phone" name="branch_phone" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="whatsapp">{{ __('t.whatsapp') }}</label>
                                    <input value="{{ $branch->whatsapp }}" type="text" id="whatsapp" name="whatsapp" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instagram">{{ __('t.instagram') }}</label>
                                    <input value="{{ $branch->instagram }}" type="text" id="instagram" name="instagram" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">{{ __('t.address') }}</label>
                                    <input value="{{ $branch->address }}" type="text" id="address" name="address" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="branch_image" class="form-control">
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
