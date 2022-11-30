@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <strong>Total Orders</strong>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Saved Orders</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">bookmark</i>
                                <strong>{{ __('t.saved_transactions_for_modification') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <strong>Total Products</strong>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><strong>POS Termnial</strong></h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">add_circle</i>
                                <strong>{{ __('t.crete_new_transaction') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <strong>Total Sales(POPS)</strong>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Completed Orders</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">check_circle</i>
                                <strong>{{ __('t.transactions_completed') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
