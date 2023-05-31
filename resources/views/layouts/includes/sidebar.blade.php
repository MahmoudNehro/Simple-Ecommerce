<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">Ecommerce</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle" data-toggle="collapse">
                
            <i data-feather="disc"></i>
            </a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class=" navigation-header"><span>Data</span>
            </li>
            <li class=" nav-item"><a href="{{route('admin.orders')}}"><i data-feather="shopping-bag"></i>
                    <span class="menu-title" data-i18n="Orders">Orders</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('admin.notifications')}}"><i data-feather="bell"></i>
                    <span class="menu-title" data-i18n="notify">All Notifications</span></a>
            </li>


        </ul>
    </div>
</div>
