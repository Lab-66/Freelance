<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="#">
            @if($user_data->user_avatar)
                <img src="{!! url('/').'/uploads/avatar/'.$user_data->user_avatar !!}" alt="img"
                     class="img-rounded"/>
            @else
                <img src="{{ url('uploads/avatar/user.png') }}" alt="img" class="img-rounded" />
            @endif
        </a>
        <div class="content-profile">
            <h4 class="media-heading">{{ $user_data->full_name }}</h4>
            <ul class="icon-list">
                <li>
                    <a href="{{ url('customers/mailbox') }}" title="Email">
                        <i class="fa fa-fw fa-envelope"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('customers/sales_order') }}" title="Sales Order">
                        <i class="fa fa-fw fa-usd"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('customers/invoice') }}" title="Invoices">
                        <i class="fa fa-fw fa-file-text"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<ul class="navigation">
    <li {!! (Request::is('customers') ? 'class="active"' : '') !!}>
        <a href="{{url('customers')}}">
        <span class="nav-icon">
         <i class="material-icons text-primary">dashboard</i>
        </span>
            <span class="nav-text">{{trans('left_menu.dashboard')}}</span>
        </a>
    </li>
    <li {!! (Request::is('customers/quotation/*') || Request::is('customers/quotation') ? 'class="active"' : '') !!}>
        <a href="{{url('customers/quotation')}}">
        <span class="nav-icon">
            <i class="material-icons text-info">assignment</i>
        </span>
            <span class="nav-text">{{trans('left_menu.quotations')}}</span>
        </a>
    </li>
    <li {!! (Request::is('customers/sales_order/*') || Request::is('customers/sales_order') ? 'class="active"' : '') !!}>
        <a href="{{url('customers/sales_order')}}">
        <span class="nav-icon">
         <i class="material-icons text-warning">attach_money</i>
        </span>
            <span class="nav-text">{{trans('left_menu.sales_order')}}</span>
        </a>
    </li>
    <li {!! (Request::is('customers/invoice/*') || Request::is('customers/invoice') ? 'class="active"' : '') !!}>
        <a href="{{url('customers/invoice')}}">
        <span class="nav-icon">
           <i class="material-icons text-success">web</i>
        </span>
            <span class="nav-text">{{trans('left_menu.invoices')}}</span>
        </a>
    </li>
    <li {!! (Request::is('customers/contract/*') || Request::is('customers/contract') ? 'class="active"' : '') !!}>
        <a href="{{url('customers/contract')}}">
        <span class="nav-icon">
         <i class="material-icons text-danger">satellite</i>
        </span>
            <span class="nav-text">{{trans('left_menu.contracts')}}</span>
        </a>
    </li>
</ul>
