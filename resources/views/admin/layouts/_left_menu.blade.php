<ul id="menu" class="nav-main">
   <!--  <li>
        <a{!! (\Request::is('admin/dashboard'))?' class="active"':'' !!} href="{{ URL::to('admin') }}"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
    </li> -->
    @if(Sentinel::inRole('admin'))
     <li{!! (\Request::is('admin/page*'))?' class="open"':'' !!}>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-pagelines"></i><span class="sidebar-mini-hide">Pages</span></a>
        <ul>
            <li>
                <a{!! (\Request::is('admin/pages'))?' class="active"':'' !!} href="{{ URL::to('/admin/pages') }}">Pages</a>
            </li>
            <li>
                <a{!! (\Request::is('admin/page/create'))?' class="active"':'' !!} href="{{ URL::to('/admin/page/create') }}">New Page</a>
            </li>
        </ul>
    </li>


     <li {!! (Request::is('admin/product') || Request::is('admin/product/*') || Request::is('admin/category') ?'class="open"' : '') !!}>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-cart-plus"></i><span class="sidebar-mini-hide">Products</span></a>
        <ul>
            <li {!! (Request::is('admin/product') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/product') }}">
                    Products
                </a>
            </li>
            <!-- <li {{-- (Request::is('admin/category') ? 'class="active"' : '') --}}>
                <a href="{{ URL::to('admin/category') }}">
                    Product Categories
                </a>
            </li> -->
           
        </ul>
    </li>
    @endif
    <li {!! (Request::is('admin/order') || Request::is('admin/order/*') ?'class="open"' : '') !!}>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-cart-plus"></i><span class="sidebar-mini-hide">Orders</span></a>
        <ul>
            @if(Sentinel::inRole('admin') || Sentinel::inRole('delivery'))
            <li {!! (Request::is('admin/order') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/order') }}">
                    Quick Delivery
                </a>
            </li>
            @endif
            @if(Sentinel::inRole('admin') || Sentinel::inRole('invoice'))
            <li {!! (Request::is('admin/order') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/order/quickinvoice') }}">
                    Quick Invoice
                </a>
            </li>
            @endif
            <!-- <li {{-- (Request::is('admin/category') ? 'class="active"' : '') --}}>
                <a href="{{ URL::to('admin/category') }}">
                    Product Categories
                </a>
            </li> -->
           
        </ul>
    </li>

    @if(Sentinel::inRole('admin'))
   
    <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="open"' : '') !!}>
       <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-user"></i><span class="sidebar-mini-hide">Users</span></a>
        <ul>
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                   
                    Users
                </a>
            </li>
           <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    
                    Add New User
                </a>
            </li>
             <!-- <li {!! ((Request::is('admin/users/*')) && !(Request::is('admin/users/create')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::route('users.show',Sentinel::getUser()->id) }}">
                    
                    View Profile
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_users') }}">
                    
                    Deleted Users
                </a>
            </li> -->
        </ul>
    </li>
    <li {!! (Request::is('admin/groups') || Request::is('admin/groups/create') || Request::is('admin/groups/*') ? 'class="open"' : '') !!}>
        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-users"></i><span class="sidebar-mini-hide">Groups</span></a>
        <ul >
            <li {!! (Request::is('admin/groups') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Groups
                </a>
            </li>
            <li {!! (Request::is('admin/groups/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New Group
                </a>
            </li>
        </ul>
    </li>
    @endif
    <!-- Menus generated by CRUD generator -->
    @include('admin/layouts/menu')
</ul>