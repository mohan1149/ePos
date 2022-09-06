@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="/terminal">
                        <div class="card">
                            <div class="card-header card-header-success">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">POS Termnial</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">add_circle</i> <strong>{{__("t.crete_new_transaction")}}</strong>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/saved">
                        <div class="card">
                            <div class="card-header card-header-warning">
                            </div>
                            <div class="card-body">
                            <h4 class="card-title">Saved Orders</h4>
                            </div>
                            <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">bookmark</i> <strong>{{ __("t.saved_transactions_for_modification")}}</strong>
                            </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                <a href="/completed">
                    <div class="card">
                        <div class="card-header card-header-danger">
                        </div>
                        <div class="card-body">
                        <h4 class="card-title">Completed Orders</h4>
                        </div>
                        <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">check_circle</i> <strong>{{__("t.transactions_completed")}}</strong>
                        </div>
                        </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </div>
@endsection