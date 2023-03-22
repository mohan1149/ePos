@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="product_name">{{ __('t.name') }}</label>
                                    {{ Form::text('product_name', $product->name, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_sku">{{ __('t.sku') }}</label>
                                    {{ Form::number('product_sku', $product->sku, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('product_branch', $branches, $product->branch, ['class' => 'form-control product_branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">{{ __('t.category') }}</label>
                                    {{ Form::select('category', $categories, $product->category, ['class' => 'form-control product_category', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">{{ __('t.brand') }}</label>
                                    {{ Form::select('brand', $brands, $product->brand, ['class' => 'form-control product_brand', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_price">{{ __('t.price') }}</label>
                                    {{ Form::text('product_price', $product->price, ['class' => 'form-control', 'required']) }}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_price">{{ __('t.cost_price') }}</label>
                                    {{ Form::text('cost_price', $product->cost_price, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('featured', __('t.featured')) }}
                                    {{ Form::checkbox('featured',null, $product->featured == 1 ? true : false) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('stock_item', __('t.stock_item')) }}
                                    {{ Form::checkbox('stock_item', null, $product->stock_item == 1 ? true : false, ['class' => 'product_stock_item']) }}
                                </div>
                            </div>


                            <div class="col-md-4 product-stock {{ $product->stock_item != 1 ? 'hidden' : '' }}">
                                <div class="form-group">
                                    <label for="stock">{{ __('t.stock') }}</label>
                                    {{ Form::text('stock', $product->stock, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_image">{{ __('t.product_image') }}</label>
                                    {{ Form::file('product_image', ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_description">{{ __('t.product_description') }}</label>
                                    <textarea name="product_description" class="form-control" cols="30" rows="10">{{ $product->product_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit(__("t.update"), ['class'=>'btn btn-primary']) !!}
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.product_stock_item').on('change', (e) => {
                let flag = $('.product_stock_item')[0].checked;
                if (flag) {
                    $('.product-stock').removeClass('hidden');
                } else {
                    $('.product-stock').addClass('hidden');
                }
            })
            $(".product_branch").on('change', () => {
                let bid = $(".product_branch").val();
                let url = '/api/categories-and-brands-by-branch/' + bid;
                $.ajax({
                    url: url,
                    success: function(result) {
                        $('.product_category').empty();
                        $('.product_brand').empty();
                        let categories = "";
                        let brands = "";
                        result.categories.forEach((category) => {
                            categories += "<option value=" + category.id + ">" +
                                category.category + "</option>";
                        });
                        $('.product_category').append(categories);
                        result.brands.forEach((brand) => {
                            brands += "<option value=" + brand.id + ">" + brand.name +
                                "</option>";
                        });
                        $('.product_brand').append(brands);
                    }
                });

            });
        });
    </script>
@endsection
