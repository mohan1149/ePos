@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('t.add_product') }}</h4>
                </div>
                <div class="card-body">
                    <form class="p-3" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="product_name">{{ __('t.name') }}</label>
                                    {{ Form::text('product_name', null, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_sku">{{ __('t.sku') }}</label>
                                    {{ Form::text('product_sku', null, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_branch">{{ __('t.branch') }}</label>
                                    {{ Form::select('product_branch', $branches, null, ['class' => 'form-control product_branch', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">{{ __('t.category') }}</label>
                                    {{ Form::select('category', [], null, ['class' => 'form-control product_category', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand">{{ __('t.brand') }}</label>
                                    {{ Form::select('brand', [], null, ['class' => 'form-control product_brand', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_price">{{ __('t.price') }}</label>
                                    {{ Form::text('product_price', null, ['class' => 'form-control', 'required']) }}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_price">{{ __('t.cost_price') }}</label>
                                    {{ Form::text('cost_price', null, ['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('featured', __('t.featured')) }}
                                    {{ Form::checkbox('featured', null,  true ) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('stock_item', __('t.stock_item')) }}
                                    {{ Form::checkbox('stock_item', null, false, ['class' => 'product_stock_item']) }}
                                </div>
                            </div>


                            <div class="col-md-4 product-stock hidden">
                                <div class="form-group">
                                    <label for="stock">{{ __('t.stock') }}</label>
                                    {{ Form::text('stock', 0, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_image">{{ __('t.product_image') }}</label>
                                    {{ Form::file('product_image', ['class' => 'form-control','required']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_description">{{ __('t.product_description') }}</label>
                                    <textarea name="product_description" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit(__("t.add"), ['class'=>'btn btn-primary']) !!}
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
