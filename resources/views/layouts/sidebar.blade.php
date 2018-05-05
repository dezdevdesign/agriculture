<aside class="sidebar" {{-- style="background-color: #ececec" --}}>
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="{{ asset('images/logo.png') }}" alt="">
                <div>
                    <div class="user__name">{{ auth()->user()->name }}</div>
                    <div class="user__email">{{ auth()->user()->position }}</div>
                </div>
            </div>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="">View Profile</a>
                <a class="dropdown-item" href="">Settings</a>
                <a class="dropdown-item" href="">Logout</a>
            </div>
        </div>
        <ul class="navigation">
            <li class="{{ Request::is('home') ? 'navigation__active' : '' }}">
                <a href="/home"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a>
            </li>
            <li class="navigation__sub {{ Request::is('croppings/*') ? 'navigation__sub--active navigation__sub--toggled' : '' }}">
                <a href=""><i class="zmdi zmdi-landscape"></i> Croppings</a>
                <ul>
                    <li class="{{ Request::is('croppings/add') ? 'navigation__active' : '' }}">
                        <a href="/croppings/add"> Add Cropping</a>
                    </li>
                    <li class="{{ Request::is('croppings/list') ? 'navigation__active' : '' }}">
                        <a href="/croppings/list"> Cropping List</a>
                    </li>
                    <li class="{{ Request::is('croppings/harvests') ? 'navigation__active' : '' }}">
                        <a href="/croppings/harvests"> Harvest List</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('maps') ? 'navigation__active' : '' }}">
                <a href="/maps"><i class="zmdi zmdi-map"></i> Map</a>
            </li>
            <li class="{{ Request::is('farmers') ? 'navigation__active' : '' }}">
                <a href="/farmers"><i class="zmdi zmdi-walk"></i> Farmers</a>
            </li>
            <li class="{{ Request::is('crops') ? 'navigation__active' : '' }}">
                <a href="/crops"><i class="zmdi zmdi-flower-alt"></i> Crops</a>
            </li>
            <li class="{{ Request::is('users') ? 'navigation__active' : '' }}">
                <a href="/users"><i class="zmdi zmdi-account"></i> Users</a>
            </li>
        </ul>
    </div>
</aside>