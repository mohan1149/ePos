@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('t.users_list') }}</h4>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <th>{{ __("t.id") }}</th>
                    <th>{{ __("t.image") }}</th>
                    <th>{{ __("t.name")}}</th>
                    <th>{{ __("t.email") }}</th>
                    <th>{{ __("t.phone") }}</th>
                    <th>{{ __("t.active") }}</th>
                    <th>{{ __("t.actions") }}</th>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td>{{ $user->id }}</td>
                        <td><img src="{{ $user->avatar }}" alt="image" width="50px" height="50px"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->active }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection