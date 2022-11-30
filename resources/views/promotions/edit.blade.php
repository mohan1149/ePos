@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_promotion') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['url'=>'promotions/'.$promotion->id,'files'=>true,'method'=>'PUT']) !!}
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="promotion_code">{{ __('t.promo_code') }}</label>
                                    <input type="text" value="{{ $promotion->promotion_code }}" id="promotion_code"
                                        name="promotion_code" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="slider_caption">{{ __('t.promo_discount') }}</label>
                                    <input type="text" value="{{ $promotion->promotion_discount }}"
                                        id="promotion_discount" name="promotion_discount" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="promotion_expiry">{{ __('t.promo_expires_in') }}</label>
                                    <input type="date" value="{{ $promotion->promotion_expiry }}" id="promotion_expiry"
                                        name="promotion_expiry" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('branch', $branches, $promotion->branch, ['class' => 'form-control branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="promo_image" class="form-control">
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
