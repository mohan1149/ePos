@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary d-flex align-items-align-center">
                <h4 class="card-title">{{ __('t.brands') }}</h4>
                <a class="btn btn-info" href="/brands/create">{{__("t.add_brand")}}</a>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="brandsTable">
                  <thead>
                    <th>{{ __("t.image") }}</th>
                    <th>{{ __("t.name")}}</th>
                    <th>{{ __("t.branch")}}</th>
                    <th>{{ __("t.actions")}}</th>
                  </thead>
                  <tbody>
                    @foreach ($brands as $brand)
                      <tr>
                        <td><img src="{{ $brand->brand_avatar }}" alt="image" width="70px" height="70px"></td>
                        <td>{{$brand->name}}</td>
                        <td>{{$brand->branch}}</td>
                        <td><a href="/brands/{{$brand->id}}/edit" rel="noopener noreferrer">{{__("t.edit")}}</a></td>
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
            $('#brandsTable').DataTable();
        });
    </script>
@endsection