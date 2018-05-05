<header class="header">
    <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
        <div class="navigation-trigger__inner">
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
        </div>
    </div>

    <div class="header__logo hidden-sm-down">
        <h1><a href="/home"> Department Of Agriculture</a></h1>
    </div>
    <ul class="top-nav">
        <li class="hidden-xl-up"><a href="#" data-ma-action="search-open"><i class="zmdi zmdi-search"></i></a></li>
        <li class="dropdown hidden-xs-down">
            <a href="#" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-item theme-switch">
                    Theme Switch
                    <div class="btn-group btn-group--colors mt-2" data-toggle="buttons">
                        <label class="btn bg-green active"><input type="radio" value="green" autocomplete="off" checked></label>
                        <label class="btn bg-blue"><input type="radio" value="blue" autocomplete="off"></label>
                        <label class="btn bg-red"><input type="radio" value="red" autocomplete="off"></label>
                        <label class="btn bg-orange"><input type="radio" value="orange" autocomplete="off"></label>
                        <label class="btn bg-teal"><input type="radio" value="teal" autocomplete="off"></label>
                        <br>
                        <label class="btn bg-cyan"><input type="radio" value="cyan" autocomplete="off"></label>
                        <label class="btn bg-blue-grey"><input type="radio" value="blue-grey" autocomplete="off"></label>
                        <label class="btn bg-purple"><input type="radio" value="purple" autocomplete="off"></label>
                        <label class="btn bg-indigo"><input type="radio" value="indigo" autocomplete="off"></label>
                        <label class="btn bg-lime"><input type="radio" value="lime" autocomplete="off"></label>
                    </div>
                </div>
            </div>
        </li>
        <li class="hidden-xs-down">
             <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                 <i class="zmdi zmdi-power"></i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</header>