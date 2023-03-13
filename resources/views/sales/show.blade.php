@extends('layouts.app', ['title' => __('t.view_order')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.orders') }}</h4>
                    <p><strong>{{ __('t.view_order') }}</strong></p>
                </div>
                <div class="card-body">
                    @php
                        $settings = session('settings');
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            <div class="p-2">
                                <h3>{{ __('t.order_items') }}</h3>
                                <table class="table">
                                    @php
                                        $items = json_decode($order->order_items);
                                        $settings = session('settings');
                                    @endphp
                                    <th>{{ __('t.image') }}</th>
                                    <th>{{ __('t.product') }}</th>
                                    <th>{{ __('t.price') }}</th>
                                    <th>{{ __('t.quantity') }}</th>
                                    <th>{{ __('t.total') }}</th>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <img src={{ $item->product_image }} width="70" height="70">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ number_format($item->price, $settings->decimal_points) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price * $item->quantity, $settings->decimal_points) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="p-2">
                                <h3>{{ __('t.shipping_address') }}</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.governorate') }}</h5>
                                            <h4>{{ $order->cust_governorate }}</h4>
                                        </div>
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.area') }}</h5>
                                            <h4>{{ $order->cust_area }}</h4>
                                        </div>
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.block') }}</h5>
                                            <h4>{{ $order->cust_block }}</h4>
                                        </div>
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.street') }}</h5>
                                            <h4>{{ $order->cust_street }}</h4>
                                        </div>
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.avenue') }}</h5>
                                            <h4>{{ $order->cust_avenue }}</h4>
                                        </div>
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.home_apartment') }}</h5>
                                            <h4>{{ $order->cust_house_apartment }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-centent-space-between">
                                            <h5>{{ __('t.status') }}</h5>
                                            <div>
                                                @switch($order->status)
                                                @case(0)
                                                    <span class="badge badge-danger">{{ __('t.received') }}</span>
                                                @break

                                                @case(1)
                                                    <span class="badge badge-primary">{{ __('t.processing') }}</span>
                                                @break

                                                @case(2)
                                                    <span class="badge badge-info">{{ __('t.on_develiry') }}</span>
                                                @break

                                                @case(3)
                                                    <span class="badge badge-success">{{ __('t.delivered') }}</span>
                                                @break
                                            @endswitch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="p-2">
                                <h3>{{ __('t.billing_address') }}</h3>
                                <div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.cust_name') }}</h5>
                                        <h4>{{ $order->cust_first_name . ' ' . $order->cust_last_name }}</h4>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.cust_phone') }}</h5>
                                        <h4>{{ $order->cust_phone }}</h4>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.cust_email') }}</h5>
                                        <h4>{{ $order->cust_email }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <h3>{{ __('t.payment_details') }}</h3>
                                <div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.payment_status') }}</h5>
                                        <div>
                                            @if ($order->payment_status == 0)
                                                <span class="badge badge-danger">{{ __('t.due') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('t.paid') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.payment_method') }}</h5>
                                        <h4>{{ __('t.' . $order->payment_type) }}</h4>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.total') }}</h5>
                                        <h4>{{  number_format($order->total, $settings->decimal_points) }}</h4>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.total') }}</h5>
                                        <h4>{{  number_format($order->discount, $settings->decimal_points) }}</h4>
                                    </div>
                                    <div class="d-flex justify-centent-space-between">
                                        <h5>{{ __('t.grand_total') }}</h5>
                                        <h4>{{  number_format($order->grand_total, $settings->decimal_points) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
