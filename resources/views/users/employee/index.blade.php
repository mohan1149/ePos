@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.users') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="usersTable">
                            <thead>
                                <th>{{ __('t.image') }}</th>
                                <th>{{ __('t.name') }}</th>
                                <th>{{ __('t.email') }}</th>
                                <th>{{ __('t.phone') }}</th>
                                <th>{{ __('t.type') }}</th>
                                <th>{{ __('t.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td><img src="{{ $user->avatar }}" alt="image" width="50px" height="50px"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if ($user->role == 0)
                                                <span>{{__("t.service_staff")}}</span>
                                            @endif
                                            @if ($user->role == 2)
                                            <span>{{__("t.driver")}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/users/{{ $user->id }}/edit">{{ __('t.edit') }}</a>
                                        </td>
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
@section('js')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });
    </script>
@endsection
