@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_promotion') }}</h4>
                </div>
                <div class="card-body">
                    <form action="/promotions" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="promotion_code">{{ __('t.promo_code') }}</label>
                                    <input type="text" id="promotion_code" name="promotion_code" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_caption">{{ __('t.promo_discount') }}</label>
                                    <input type="text" id="promotion_discount" name="promotion_discount" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="promotion_expiry">{{ __('t.promo_expires_in') }}</label>
                                    <input type="date" id="promotion_expiry" name="promotion_expiry" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('branch', $branches, null, ['class' => 'form-control branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="promo_image" class="form-control">
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
