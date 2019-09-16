<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <li class="nav-item pushconfig-menu" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link active" href="{{ route('config.push') }}">
            <i class="fa fa-fw fa-cog"></i>
            <span class="nav-link-text">Push Config</span>
        </a>
    </li>
    <li class="nav-item pushsend-menu" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link active" href="{{ route('config.send_create') }}">
            <i class="fa fa-fw fa-paper-plane"></i>
            <span class="nav-link-text"> Send Push </span>
        </a>
    </li>
    <li class="nav-item trans-menu" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link active" href="{{ route('config.translation') }}">
            <i class="fa fa-fw fa-language"></i>
            <span class="nav-link-text"> Comments </span>
        </a>
    </li>
</ul>