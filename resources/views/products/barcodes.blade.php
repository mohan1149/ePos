<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Barcods</h2>
    <table border="1"> 
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <p>{{$product->name}}</p>
                        <p class="barcodecell"><barcode code={{$product->sku}} type="MSI" class="barcode"></p>
                    </td>
                    
                </tr>
                <br>
                <br>
            @endforeach
        </tbody>
    </table>
</body>
</html>