<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Invoice</title>
    <style>
        table{
            width: 100%;
            border-collapse: collapse;
        }
        td{
            padding: 5px;
        }
        th{
            color: white;
        }
        #payment_table td.pay_label {
            text-align: left;
        }
        .order-items-table-th{
            background-color:#2196F3;
            color: #FFFFFF;
        }
        .order-items-table-th th{
            padding: 15px;
        }
        #order-items-table tbody tr td{
            padding: 10px;
            text-align: center;
        }
        #order-items-table tbody tr:nth-child(even){
            background-color: #CCC;
        }
        #payment_table tbody tr:nth-child(even){
            background-color: #CCC;
        }
        #payment_table tbody tr td{
            padding: 10px;
            text-align: center;
        }
        .text-center{
            text-align: center;
        }
        .text-left:{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .footer{
            background-color:#2196F3;
            color: #FFFFFF;
            text-align: center;
            padding: 10px;
        }
        .sign-table{
            margin-top: 70px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div>
        @php
            $items = json_decode($order->items);
        @endphp
        <table id="order-details-table">
            <tr>
                <td>
                    <h1>INV00{{ $order->id }}</h1>
                </td>
                <td>
                    <p>Client - {{ $client->name .", ".$client->address}}</p>
                </td>
                <td>
                    <h3>{{ $branch->branch }}</h3>
                    <h6>Date - {{  $order->created_at  }}</h6>
                </td>
            </tr>
        </table>
        <hr/>
        <h2>Order Items</h2>
        <table id="order-items-table">
            <thead>
                <tr
                    class="order-items-table-th"
                >
                    <th>Product</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><img width="50px" src="{{$item->product_image}}" alt="image"/></td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->sku}}</td>
                        <td>{{  number_format($item->price,$settings->decimal_points)}}</td>
                        <td>{{ $item->quantity}}</td>
                        <td>{{number_format( $item->quantity*$item->price,$settings->decimal_points)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" ></td>
                    <td >{{ number_format($order->order_total,$settings->decimal_points) }}</td>
                </tr>
            </tbody>
        </table>
        <h2>Payment Details</h2>
        <table id="payment_table">
            <tbody>
                <tr>
                    <td class="pay_label">Order Total</td>
                    <td>{{ number_format($order->order_total,$settings->decimal_points) }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Discount</td>
                    <td>{{ number_format($order->discount,$settings->decimal_points) }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Grand Total</td>
                    <td>{{ number_format($order->final_total,$settings->decimal_points) }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Total Paid</td>
                    <td>{{ number_format($order->total_paid,$settings->decimal_points) }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Order Balance</td>
                    <td>{{ number_format(($order->final_total - $order->total_paid),$settings->decimal_points) }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Payment Method</td>
                    <td>{{ $order->payment_method == 0 ? "Cash" : $order->payment_method == 1 ? "Online" : "Credit" }}</td>
                </tr>
                <tr>
                    <td class="pay_label">Payment Status</td>
                    <td>{{ $order->payment_status == 0 ? "Due" : $order->payment_status == 1 ? "Partially Paid" : "Paid" }}</td>
                </tr>
            </tbody>
        </table>
        <div class="sign-table">
            <h4 class="text-right">Signature</h4>
        </div>
    </div>
    <htmlpagefooter name="myfooter">
        <div class="footer">
            <h5>This is auto generated invoice by ePOS System. For more details please contact System Administrator.</h5>
            <h6>All rights reserved. {{ date('Y') }}</h6>
            {{-- Page {PAGENO} of {nb} --}}
        </div>
    </htmlpagefooter>
    {{-- <sethtmlpageheader name="myheader" value="on" show-this-page="all" /> --}}
    <sethtmlpagefooter name="myfooter" value="on" />
</body>
</html>