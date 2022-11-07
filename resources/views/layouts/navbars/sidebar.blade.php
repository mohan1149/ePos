<div class="sidebar" data-color="orange" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <div class="logo">
        <a href="/home" class="simple-text logo-normal">
            {{ __('ePOs') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
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
                            <li class="nav-item{{ Request::segment(1) == 'add-user' ? ' active' : '' }}">
                                <a class="nav-link" href="/add-user">
                                    <i class="material-icons">person_add</i>
                                    <span class="sidebar-normal">{{ __('t.add_user') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'users' ? ' active' : '' }}">
                                <a class="nav-link" href="/users">
                                    <i class="material-icons">person</i>
                                    <span class="sidebar-normal"> {{ __('t.users') }} </span>
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
                            <li class="nav-item{{ Request::segment(1) == 'branches' ? ' active' : '' }}">
                                <a class="nav-link" href="/branches/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_branch') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'sliders' ? ' active' : '' }}">
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
                </li>
                <li class="nav-item {{ Request::segment(1) == 'tags' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#tags" aria-expanded="true">
                        <i class="material-icons">sell</i>
                        <p>{{ __('t.tags') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'tags' ? ' show' : '' }}" id="tags">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'tags' ? ' active' : '' }}">
                                <a class="nav-link" href="/tags">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_tags') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'tags' ? ' active' : '' }}">
                                <a class="nav-link" href="/tags/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_tag') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'promotions' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#promotions" aria-expanded="true">
                        <i class="material-icons">rocket_launch</i>
                        <p>{{ __('t.promotions') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'promotions' ? ' show' : '' }}" id="promotions">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'promotions' ? ' active' : '' }}">
                                <a class="nav-link" href="/promotions">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_promotions') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'promotions' ? ' active' : '' }}">
                                <a class="nav-link" href="/promotions/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_promotion') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'brands' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#brands" aria-expanded="true">
                        <i class="material-icons">diamond</i>
                        <p>{{ __('t.brands') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'brands' ? ' show' : '' }}" id="brands">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'brands' ? ' active' : '' }}">
                                <a class="nav-link" href="/brands">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_brands') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'brands' ? ' active' : '' }}">
                                <a class="nav-link" href="/brands/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_brand') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'categories' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#categories" aria-expanded="true">
                        <i class="material-icons">category</i>
                        <p>{{ __('t.categories') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'categories' ? ' show' : '' }}" id="categories">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'categories' ? ' active' : '' }}">
                                <a class="nav-link" href="/categories">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_categories') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'categories' ? ' active' : '' }}">
                                <a class="nav-link" href="/categories/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_category') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'products' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="true">
                        <i class="material-icons">shopping_cart</i>
                        <p>{{ __('t.products') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ Request::segment(1) == 'products' ? ' show' : '' }}" id="products">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'products' ? ' active' : '' }}">
                                <a class="nav-link" href="/products">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_products') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'products' ? ' active' : '' }}">
                                <a class="nav-link" href="/products/create">
                                    <i class="material-icons">add_circle</i>
                                    <span class="sidebar-normal"> {{ __('t.add_product') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
				<li class="nav-item {{ Request::segment(1) == 'orders' ? ' active' : '' }}">
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
                </li>
                <li class="nav-item {{ Request::segment(1) == 'sales' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#sales" aria-expanded="true">
                        <i class="material-icons">payments</i>
                        <p>{{ __('t.sales') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="sales">
                        <ul class="nav">
                            <li class="nav-item{{ Request::segment(1) == 'sales' ? ' active' : '' }}">
                                <a class="nav-link" href="/sales">
                                    <i class="material-icons">list</i>
                                    <span class="sidebar-normal">{{ __('t.list_orders') }} </span>
                                </a>
                            </li>
							<li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/sales/completed">
                                    <i class="material-icons">sync</i>
                                    <span class="sidebar-normal"> {{ __('t.arrived') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ Request::segment(1) == 'orders' ? ' active' : '' }}">
                                <a class="nav-link" href="/sales/completed">
                                    <i class="material-icons">task_alt</i>
                                    <span class="sidebar-normal"> {{ __('t.completed') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item{{ Request::segment(1) == 'settings' ? ' active' : '' }}">
                    <a class="nav-link" href="/settings">
                        <i class="material-icons">settings_suggest</i>
                        <p>{{ __('t.settings') }}</p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
