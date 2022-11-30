@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('t.promotions') }}</h4>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="promotionstable">
                  <thead>
                    <th>{{ __("t.image") }}</th>
                    <th>{{ __("t.promo_code")}}</th>
                    <th>{{ __("t.promo_discount")}}</th>
                    <th>{{ __("t.promo_expires_in")}}</th>
                    <th>{{ __("t.branch")}}</th>
                    <th>{{ __("t.actions")}}</th>
                  </thead>
                  <tbody>
                    @foreach ($promotions as $promotion)
                      <tr>
                        <td><img src="{{ $promotion->promotion_banner }}" alt="image" width="70px" height="70px"></td>
                        <td>{{$promotion->promotion_code}}</td>
                        <td>{{$promotion->promotion_discount}}</td>
                        <td>{{$promotion->promotion_expiry}}</td>
                        <td>{{$promotion->branch}}</td>
                        <td><a href="/promotions/{{$promotion->id}}/edit" rel="noopener noreferrer">{{__("t.edit")}}</a></td>
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
            $('#promotionstable').DataTable();
        });
    </script>
@endsection