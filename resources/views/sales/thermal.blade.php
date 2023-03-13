<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Receipt</title>
</head>

<body>
    <div class="logo">
        <img src="http://127.0.0.1:8000/material/img/cash.png" alt="">
    </div>
    <div class="dFlex">
        <p>{{ date('Y-m-d H:s') }}</p>
        <p>INV 000965</p>
    </div>
    <hr>
    <div class="dFlex">
        <p>Order For</p>
        <p>67661149</p>
    </div>
    <div class="dFlex">
        <p>Payment Type</p>
        <p>{{ $request['payment_type'] }}</p>
    </div>
    <div class="dFlex">
        <p>Order Type</p>
        <p>{{ $request['sale_type'] }}</p>
    </div>
    @if ($request['sale_type'] == 'delivery')
    <div class="dFlex">
        <p>Delivery Notes</p>
        <p>{{ $request['sale_type'] }}</p>
    </div>
    @endif
    <hr>
    <h1 class="heading">Sale Items</h1>
    <hr>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Item</th>
                <th>QUN</th>
                <th>PRC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request['line_items'] as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] }}</td>
                </tr>
            @endforeach
        </tbody>


    </table>
    <hr>
</body>

</html>
<style>
    @media print {
        .logo {
            text-align: center;
        }

        .logo img {
            width: 40mm;
            height: 40mm;
        }

        .dFlex {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        hr {
            border: 2px dashed black;
        }

        .heading {
            text-align: center;
        }

        table {
            width: 100%;
            text-align: center;
        }

        tr {
            border: 1px solid black;
        }

        .th {
            border: 1px solid black;
        }

    }
</style>
