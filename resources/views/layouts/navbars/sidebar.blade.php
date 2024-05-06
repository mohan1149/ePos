<div class="sidebar" data-color="danger" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <div class="logo">
        <a href="/home" class="simple-text logo-normal">
            {{ __('ePOs') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ Request::segment(1) == 'home' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('t.dashboard') }}</p>
                </a>
            </li>
            @if (auth()->user()->role == 3)
                <li
                    class="nav-item {{ Request::segment(1) == 'profile' || Request::segment(1) == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#user_management" aria-expanded="true">
                        <i class="material-icons">person</i>
                        <p>{{ __('t.user_management') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse show" id="user_management">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'admins' ? ' active' : '' }}">
                                <a class="nav-link" href="/admins">
                                    <i class="material-icons">person</i>
                                    <span class="sidebar-normal"> {{ __('t.admins') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'admins' ? ' active' : '' }}">
                                <a class="nav-link" href="/add-admin">
                                    <i class="material-icons">person_add</i>
                                    <span class="sidebar-normal">{{ __('t.add_admin') }} </span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->role == 1)
                <li class="nav-item {{ Request::segment(1) == 'branches' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#branches" aria-expanded="true">
                        <i class="material-icons">pin_drop</i>
                        <p>{{ __('t.branches') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'branches' ? ' show' : '' }}" id="branches">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'branches' ? ' active' : '' }}">
                                <a class="nav-link" href="/branches">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_branches') }} </span>
                                </a>
                            </li>
                            @if (auth()->user()->multi_branch == 1)
                                <li class="nav-item{{ Request::segment(1) == 'branches' ? ' active' : '' }}">
                                    <a class="nav-link" href="/branches/create">
                                        <i class="material-icons">add_circle</i>
                                        <span class="sidebar-normal"> {{ __('t.add_branch') }} </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'users' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="true">
                        <i class="material-icons">people</i>
                        <p>{{ __('t.users') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'users' ? ' show' : '' }}" id="users">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'users' ? ' active' : '' }}">
                                <a class="nav-link" href="/users">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_users') }} </span>
                                </a>
                            </li>

                                <li class="nav-item{{ Request::segment(1) == 'users' ? ' active' : '' }}">
                                    <a class="nav-link" href="/users/create">
                                        <i class="material-icons">add_circle</i>
                                        <span class="sidebar-normal"> {{ __('t.add_user') }} </span>
                                    </a>
                                </li>

                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item {{ Request::segment(1) == 'sliders' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#sliders" aria-expanded="true">
                        <i class="material-icons">images</i>
                        <p>{{ __('t.sliders') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'sliders' ? ' show' : '' }}" id="sliders">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'sliders' ? ' active' : '' }}">
                                <a class="nav-link" href="/sliders">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_sliders') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'sliders' ? ' active' : '' }}">
                                <a class="nav-link" href="/sliders/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_slider') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item {{  in_array(Request::segment(1),['products','tags','categories','brands','promotions'])  ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="true">
                        <i class="material-icons">shopping_cart</i>
                        <p>{{ __('t.products') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{  in_array(Request::segment(1),['products','tags','categories','brands','promotions']) ? ' show' : '' }}" id="products">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'products' ? ' active' : '' }}">
                                <a class="nav-link" href="/products">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_products') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'tags' ? ' active' : '' }}">
                                <a class="nav-link" href="/tags">
                                    <i class="material-icons">sell</i>
                                    <span class="sidebar-normal"> {{ __('t.tags') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'categories' ? ' active' : '' }}">
                                <a class="nav-link" href="/categories">
                                    <i class="material-icons">category</i>
                                    <span class="sidebar-normal"> {{ __('t.categories') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'brands' ? ' active' : '' }}">
                                <a class="nav-link" href="/brands">
                                    <i class="material-icons">diamond</i>
                                    <span class="sidebar-normal"> {{ __('t.brands') }} </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item{{ Request::segment(1) == 'promotions' ? ' active' : '' }}">
                                <a class="nav-link" href="/promotions">
                                    <i class="material-icons">rocket_launch</i>
                                    <span class="sidebar-normal"> {{ __('t.promotions') }} </span>
                                </a>
                            </li> --}}
                            
                            
                        </ul>
                    </div>
                </li>

                {{-- <li class="nav-item {{ Request::segment(1) == 'services' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#services" aria-expanded="true">
                        <i class="material-icons">favorite</i>
                        <p>{{ __('t.services') }}
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse {{ Request::segment(1) == 'services' ? ' show' : '' }}" id="services">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'services' ? ' active' : '' }}">
                                <a class="nav-link" href="/services">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_services') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'services' ? ' active' : '' }}">
                                <a class="nav-link" href="/services/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_service') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="nav-item {{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#orders" aria-expanded="true">
                        <i class="material-icons">shopping_bag</i>
                        <p>{{ __('t.orders') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="orders">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/orders">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_orders') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/orders/completed">
                                    <i class="material-icons">sync</i>
                                    <span class="sidebar-normal"> {{ __('t.arrived') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/orders/completed">
                                    <i class="material-icons">task_alt</i>
                                    <span class="sidebar-normal"> {{ __('t.completed') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                
                {{-- <li class="nav-item {{ Request::segment(1) == 'business' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#business" aria-expanded="true">
                        <i class="material-icons">business_center</i>
                        <p>{{ __('t.business') }}
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="business">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'business' ? ' active' : '' }}">
                                <a class="nav-link" href="/business/orders">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.business_orders') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/business/clients">
                                    <i class="material-icons">account_box</i>
                                    <span class="sidebar-normal"> {{ __('t.business_clients') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/business/reports">
                                    <i class="material-icons">receipt</i>
                                    <span class="sidebar-normal"> {{ __('t.reports') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item{{ Request::segment(1) == 'sales' ? ' active' : '' }}">
                    <a class="nav-link" href="/sales">
                        <i class="material-icons">payments</i>
                        <p>{{ __('t.sales') }}</p>
                    </a>
                </li>
                {{-- <li class="nav-item{{ Request::segment(1) == 'settings' ? ' active' : '' }}">
                    <a class="nav-link" href="/settings">
                        <i class="material-icons">settings_suggest</i>
                        <p>{{ __('t.settings') }}</p>
                    </a>
                </li> --}}
            @endif
        </ul>
    </div>
</div>
