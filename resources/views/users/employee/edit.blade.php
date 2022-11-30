@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.edit_user') }}</h4>
                    <p class="card-category">{{ __('t.all_are_mandatory') }}</p>
                </div>
                <div class="card-body">
                        {!! Form::open(['url'=>'users/'.$user->id,'method'=>'PUT','files'=>true]) !!}
                        <div class="row p-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('t.name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" required value="{{$user->name}}">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">{{ __('t.phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required value="{{$user->phone}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="branch">{{ __('t.branch') }}</label>
                                    {!! Form::select('branch', $branches, $user->branch, ['class'=>'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="driver">{{ __('t.driver') }}</label>
                                    {{ Form::checkbox('driver', null, $user->role == '2' ? true : false, ['class' => 'driver']) }}

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
