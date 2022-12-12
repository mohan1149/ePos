@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary d-flex align-items-align-center">
                <h4 class="card-title">{{ __('t.tags') }}</h4>
                <a class="btn btn-info" href="/tags/create">{{__("t.add_tag")}}</a>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="tagsTable">
                  <thead>
                    <th>{{ __("t.tag_name")}}</th>
                    <th>{{ __("t.branch")}}</th>
                    <th>{{ __("t.actions")}}</th>
                  </thead>
                  <tbody>
                    @foreach ($tags as $tag)
                      <tr>

                        <td>{{$tag->tag_name}}</td>
                        <td>{{$tag->branch}}</td>
                        <td><a href="/tags/{{$tag->id}}/edit" rel="noopener noreferrer">{{__("t.edit")}}</a></td>
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
            $('#tagsTable').DataTable();
        });
    </script>
@endsection