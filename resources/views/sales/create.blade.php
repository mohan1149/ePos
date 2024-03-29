@extends('layouts.terminal')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>POS</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- modal --}}
                    <div class="modal fade" id="createSaleModal" tabindex="-1" role="dialog"
                        aria-labelledby="createSaleModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createSaleModalTitle">{{ __('t.create_sale') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>{{ __('t.payment_type') }}</h4>
                                    <div class="d-flex">
                                        <button class="btn btn-secondary sale-pay-type active" id="sale-btn-cash">
                                            <img src="{{'/material/img/cash.png'}}" class="sale-modal-img"/>
                                        </button>
                                        <button class="btn btn-secondary sale-pay-type" id="sale-btn-knet">
                                            <img src="{{'/material/img/knet.png'}}" class="sale-modal-img"/>
                                        </button>
                                    </div>
                                    <h4>{{ __('t.sale_type') }}</h4>
                                    <div class="d-flex">
                                        <button class="btn btn-secondary sale-type active" id="sale-btn-pickup">
                                            <img src="{{'/material/img/pickup.png'}}" class="sale-modal-img"/>
                                        </button>
                                        <button class="btn btn-secondary sale-type" id="sale-btn-delivery">
                                            <img src="{{'/material/img/delivery.png'}}" class="sale-modal-img"/>
                                        </button>
                                    </div>
                                    <div class="hidden" id="sale-delivery-notes">
                                        <h5>{{ __('t.delivery_notes') }}</h5>
                                        <textarea style="width:100%"  cols="30" rows="10"></textarea>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('t.close') }}</button>
                                    <button type="button" class="btn btn-primary" id="cofirm-order">{{ __('t.create_order') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end modal --}}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-barcode"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search here...">
                    </div>
                    <div class="mt-3">
                        <ul class="nav nav-pills nav-pills-icons" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-all" role="tab" data-toggle="tab">
                                    <img src="/material/img/all.png" alt="" class="category_avatar" width="35px"
                                        height="35px">
                                    {{ __('t.all') }}
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="#product_category_id_{{ $category->id }}" role="tab"
                                        data-toggle="tab">
                                        <img src="{{ $category->category_avatar }}" alt="" class="category_avatar"
                                            width="35px" height="35px">
                                        {{ $category->category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="tab-content tab-space mt-3" style="height: 65vh !important;overflow:scroll;">

                                <div class="tab-pane active" id="tab-all">
                                    <div class="container">
                                        <div class="card p-2">
                                            <div class="row card-body">
                                                @foreach ($products as $product)
                                                    <div class="col-md-2 col-lg-2" style="padding:5px">
                                                        <div class="card" style="margin: 0px !important">
                                                            <div class="card-header" style="padding: 0px">
                                                                <strong
                                                                    class="badge badge-primary">{{ number_format($product->price, $settings->decimal_points) }}</strong>
                                                            </div>
                                                            <button data="{{ base64_encode($product) }}"
                                                                class="btn btn-primary btn-link add-item-to-cart-btn"
                                                                style="padding: 0px"><img
                                                                    src="{{ $product->product_image }}" alt=""
                                                                    width="100%"></button>
                                                            <div class="card-footer" style="padding: 0px">
                                                                <strong>{{ $product->name }}</strong>
                                                            </div>
                                                            @if ($product->stock_item)
                                                                @if ($product->stock < 1)
                                                                    <h6 class="text-red">{{ __('t.outofstock') }}</h6>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($categories as $category)
                                    <div class="tab-pane" id="product_category_id_{{ $category->id }}">
                                        <div class="container">
                                            <div class="card p-2">
                                                <div class="row card-body">
                                                    @foreach ($products as $product)
                                                        @if ($product->category == $category->id)
                                                            <div class="col-md-2 col-lg-2" style="padding:5px">
                                                                <div class="card" style="margin: 0px !important">
                                                                    <div class="card-header" style="padding: 0px">
                                                                        <strong
                                                                            class="badge badge-primary">{{ number_format($product->price, $settings->decimal_points) }}</strong>
                                                                    </div>
                                                                    <button data="{{ base64_encode($product) }}"
                                                                        class="btn btn-primary btn-link add-item-to-cart-btn"
                                                                        style="padding: 0px"><img
                                                                            src="{{ $product->product_image }}"
                                                                            alt="" width="100%"></button>
                                                                    <div class="card-footer" style="padding: 0px">
                                                                        <strong>{{ $product->name }}</strong>
                                                                    </div>
                                                                    @if ($product->stock_item)
                                                                        @if ($product->stock < 1)
                                                                            <h6 class="text-red">{{ __('t.outofstock') }}
                                                                            </h6>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="card p-3" style="height:50vh;overflow:scroll;">
                                <div>
                                    <ol id="cart-items">
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="order-for" required
                                        placeholder="{{ __('t.order_for') }}">

                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="discount" required
                                        placeholder="{{ __('t.discount') }}">
                                </div>
                            </div>
                            <div>

                                <button class="btn btn-success" data-toggle="modal"
                                    data-target="#createSaleModal">Confirm
                                    <strong id="grand-total">
                                        [{{ number_format(0, $settings->decimal_points) }}]
                                    </strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        let cart_items = [];
        let total = 0;
        let discount = 0;
        let order_for = "Walkin Customer";
        let decimal_points = {{ $settings->decimal_points }};
        let payment_type = "cash";
        let sale_type = "pickup";
        // let products = {!! json_encode($products) !!};
        // let filtered = products;
        $(document).ready(function() {
            $('#sale-btn-cash').on('click',(e)=>{
                payment_type = 'cash';
                $('#sale-btn-cash').addClass('active');
                $('#sale-btn-knet').removeClass('active');
            })
            $('#sale-btn-knet').on('click',(e)=>{
                payment_type = 'knet';
                $('#sale-btn-cash').removeClass('active');
                $('#sale-btn-knet').addClass('active');
            })
            $('#sale-btn-pickup').on('click',(e)=>{
                sale_type = 'pickup';
                $('#sale-btn-pickup').addClass('active');
                $('#sale-btn-delivery').removeClass('active');
                $('#sale-delivery-notes').addClass('hidden');
            })
            $('#sale-btn-delivery').on('click',(e)=>{
                sale_type = 'delivery';
                $('#sale-btn-pickup').removeClass('active');
                $('#sale-btn-delivery').addClass('active');
                $('#sale-delivery-notes').removeClass('hidden');
            })
            $('.add-item-to-cart-btn').on('click', (element) => {
                let product = atob($(element.currentTarget).attr('data'));
                product = JSON.parse(product);
                let index = cart_items.findIndex((item) => item.id === product.id);
                if (index === -1) {
                    if (product.stock_item === 1) {
                        if (product.stock > 0) {
                            product.quantity = 1;
                            let list = "<li id='list_item_" + product.id + "'>";
                            list += "<div class='d-flex justify-content-between align-items-center'>";
                            list += "<div style='width:61%'>";
                            list += "<img width='50px' src='" + product.product_image + "'>";
                            list += "<span>" + product.name + "</span>";
                            list += "</div>";
                            list += "<div>";
                            list += "<button onclick='decreaseItem(" + product.id +
                                ")' class='btn btn-primary btn-fab btn-fab-mini btn-round'><i class='material-icons'>remove</i></button>";
                            list += "<span class='m-3' id='prduct_" + product.id + "_quantity'>" + product
                                .quantity + "</span>";
                            list += "<button onclick='increaseItem(" + product.id +
                                ")' class='btn btn-success btn-fab btn-fab-mini btn-round'><i class='material-icons'>add</i></button>";
                            list += "<button onclick='removeItem(" + product.id +
                                ")' class='btn btn-danger btn-fab btn-fab-mini btn-round remove_item_from_cart'><i class='material-icons'>close</i></button>";
                            list += "</div>";
                            list += "</div></li>";
                            $('#cart-items').append(list);
                            cart_items.push(product);
                        } else {
                            alert('Out of Stock');
                        }
                    } else {
                        product.quantity = 1;
                        let list = "<li id='list_item_" + product.id + "'>";
                        list += "<div class='d-flex justify-content-between align-items-center'>";
                        list += "<div style='width:61%'>";
                        list += "<img width='50px' src='" + product.product_image + "'>";
                        list += "<span>" + product.name + "</span>";
                        list += "</div>";
                        list += "<div>";
                        list += "<button onclick='decreaseItem(" + product.id +
                            ")' class='btn btn-primary btn-fab btn-fab-mini btn-round'><i class='material-icons'>remove</i></button>";
                        list += "<span class='m-3' id='prduct_" + product.id + "_quantity'>" + product
                            .quantity + "</span>";
                        list += "<button onclick='increaseItem(" + product.id +
                            ")' class='btn btn-success btn-fab btn-fab-mini btn-round'><i class='material-icons'>add</i></button>";
                        list += "<button onclick='removeItem(" + product.id +
                            ")' class='btn btn-danger btn-fab btn-fab-mini btn-round remove_item_from_cart'><i class='material-icons'>close</i></button>";
                        list += "</div>";
                        list += "</div></li>";
                        $('#cart-items').append(list);
                        cart_items.push(product);
                    }
                } else {
                    if (product.stock_item) {
                        let stock = product.stock;
                        product = cart_items[index];
                        if (product.quantity < stock) {
                            product.quantity += 1;
                            cart_items[index] = product;
                            $('#prduct_' + product.id + '_quantity').text(product.quantity);
                        } else {
                            alert('Out of Stock');
                        }
                    } else {
                        product = cart_items[index];
                        product.quantity += 1;
                        cart_items[index] = product;
                        $('#prduct_' + product.id + '_quantity').text(product.quantity);
                    }
                }
                const sum = cart_items.reduce((previousValue, currentValue) => previousValue + (currentValue
                    .price * currentValue.quantity), 0);
                $('#grand-total').text("[" + sum.toFixed(decimal_points) + "]");
            });
            $("#cofirm-order").on('click', () => {
                let url = "/create/order";
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        line_items: cart_items,
                        discount: discount,
                        order_for: order_for,
                        order_type:sale_type,
                        total:100,
                        discount:0,
                        discount_amount:0,
                        final_total:100,
                        pay_type:payment_type,
                        delivery_address:'',
                    },
                    success: (res) => {
                        printReceipt(res);
                    }
                });
            });
        });

        function removeItem(id) {
            $('#list_item_' + id).remove();
            let index = cart_items.findIndex((item) => item.id === id);
            cart_items.splice(index, 1);
            const sum = cart_items.reduce((previousValue, currentValue) => previousValue + (currentValue.price *
                currentValue.quantity), 0);
            $('#grand-total').text("[" + sum.toFixed(decimal_points) + "]");
        };

        function decreaseItem(id) {
            let index = cart_items.findIndex((item) => item.id === id);
            let product = cart_items[index];
            if (product.quantity > 1) {
                product.quantity -= 1;
                cart_items[index] = product;
                $('#prduct_' + id + '_quantity').text(product.quantity);
            }
            const sum = cart_items.reduce((previousValue, currentValue) => previousValue + (currentValue.price *
                currentValue.quantity), 0);
            $('#grand-total').text("[" + sum.toFixed(decimal_points) + "]");
        }

        function increaseItem(id) {
            let index = cart_items.findIndex((item) => item.id === id);
            let product = cart_items[index];
            if (product.stock_item === 1) {
                if (product.quantity < product.stock) {
                    product.quantity += 1;
                    cart_items[index] = product;
                    $('#prduct_' + id + '_quantity').text(product.quantity);
                } else {
                    alert('Out of Stock');
                }
            } else {
                product.quantity += 1;
                cart_items[index] = product;
                $('#prduct_' + id + '_quantity').text(product.quantity);
            }
            const sum = cart_items.reduce((previousValue, currentValue) => previousValue + (currentValue.price *
                currentValue.quantity), 0);
            $('#grand-total').text("[" + sum.toFixed(decimal_points) + "]");
        }

        function printReceipt(html) {
            var myWindow = window.open('', '');
            myWindow.document.write(html);
            myWindow.document.close();
            myWindow.focus();
            myWindow.print();
            myWindow.close();
        }
    </script>
@endsection
