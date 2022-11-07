@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('t.branches') }}</h4>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="branchesTable">
                  <thead>
                    <th>{{ __("t.image") }}</th>
                    <th>{{ __("t.name")}}</th>
                    <th>{{ __("t.phone")}}</th>
                    <th>{{ __("t.email")}}</th>
                    <th>{{ __("t.whatsapp")}}</th>
                    <th>{{ __("t.instagram")}}</th>
                    <th>{{ __("t.address")}}</th>
                    <th>{{ __("t.actions")}}</th>
                  </thead>
                  <tbody>
                    @foreach ($branches as $branch)
                      <tr>
                        <td><img src="{{ $branch->logo }}" alt="image" width="70px" height="70px"></td>
                        <td>{{$branch->branch}}</td>
                        <td>{{$branch->phone}}</td>
                        <td>{{$branch->email}}</td>
                        <td>{{$branch->whatsapp}}</td>
                        <td>{{$branch->instagram}}</td>
                        <td>{{$branch->address}}</td>
                        <td><a href="/branches/{{$branch->id}}/edit" rel="noopener noreferrer">{{__("t.edit")}}</a></td>
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
            $('#branchesTable').DataTable();
        });
    </script>
@endsection