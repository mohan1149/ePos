@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_user') }}</h4>
                    <p class="card-category">{{ __('t.all_are_mandatory') }}</p>
                </div>
                <div class="card-body">
                        {!! Form::open(['url'=>'users','methos'=>'POST','files'=>true]) !!}
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('t.name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">{{ __('t.email') }}</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">{{ __('t.phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">{{ __('t.password') }}</label>
                                    <input type="text" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {!! Form::select('branch', $branches, null, ['class'=>'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="avatar" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="checkbox" id="driver"name="driver">
                                    <label for="driver">{{ __('t.driver') }}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('t.add') }}">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
