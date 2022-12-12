@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary d-flex align-items-align-center">
                <h4 class="card-title">{{ __('t.categories') }}</h4>
                <a class="btn btn-info" href="/categories/create">{{__("t.add_category")}}</a>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="categoriesTable">
                  <thead>
                    <th>{{ __("t.image") }}</th>
                    <th>{{ __("t.category_name")}}</th>
                    <th>{{ __("t.branch")}}</th>
                    <th>{{ __("t.type")}}</th>
                    <th>{{ __("t.actions")}}</th>
                  </thead>
                  <tbody>
                    @foreach ($categories as $category)
                      <tr>
                        <td><img src="{{ $category->category_avatar }}" alt="image" width="70px" height="70px"></td>
                        <td>{{$category->category}}</td>
                        <td>{{$category->branch}}</td>
                        <td>
                            @if ($category->type == 0)
                                <span class="cat-product badge badge-primary">{{__("t.product")}}</span>
                            @else
                            <span class="cat-product badge badge-info">{{__("t.service")}}</span>
                            @endif
                        
                        </td>
                        <td><a href="/categories/{{$category->id}}/edit" rel="noopener noreferrer">{{__("t.edit")}}</a></td>
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
            $('#categoriesTable').DataTable();
        });
    </script>
@endsection