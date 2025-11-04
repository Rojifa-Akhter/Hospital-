<div class="navbar navbar-default" id="navbar-second">
    <ul class="nav navbar-nav no-border visible-xs-block">
        <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i
            class="icon-menu7"></i></a></li>
        </ul>
        <div class="navbar-collapse collapse" id="navbar-second-toggle">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('dashboard') }}" rel="tab" title="Dashboard"><i
                    class="icon-display4 position-left"></i> Dashboard</a></li>
                    <li class="dropdown mega-menu mega-menu-wide">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown_"
                        title="Transactions"><i class="icon-gear position-left"></i> Transactions <span class="caret"></span></a>
                        <div class="dropdown-menu dropdown-content">
                            <div class="dropdown-content-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="menu-heading underlined"><i class="icon-grid position-left"></i>  Accounts Module</span>
                                        <ul class="menu-list">
                                            <li><a href="{{ route('chartOfAcc') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Chart of Account</a>
                                            </li>
                                            <li><a href="{{ route('paymentVoucher') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Payment Voucher</a>
                                            </li>
                                            <li><a href="{{ route('receiveVoucher') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Recieve Voucher</a>
                                            </li>
                                            <li><a href="{{ route('journalVoucher') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Journal Voucher</a>
                                            </li>
                                            <li><a href="{{ route('bankInfo') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Bank Information</a>
                                            </li>
                                            <li><a href="{{ route('supplierInfo') }}" rel="tab"><i
                                                class="icon-arrow-right14 position-left"></i> Supplier
                                                Information</a></li>
                                                <li><a href="{{ route('partyInfo') }}" rel="tab"><i
                                                    class="icon-arrow-right14 position-left"></i> Party Information</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown mega-menu mega-menu-wide">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown_"
                            title="Manage Security & Access"><i class="icon-gear position-left"></i> Security & Access <span
                            class="caret"></span></a>
                            <div class="dropdown-menu dropdown-content">
                                <div class="dropdown-content-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="menu-heading underlined"><i class="icon-grid position-left"></i>  Module Management</span>
                                            <ul class="menu-list">
                                                <li><a href="{{ route('modules') }}" rel="tab"><i
                                                    class="icon-arrow-right14 position-left"></i> Modules </a></li>
                                                    <li><a href="{{ route('orgModules') }}" rel="tab"><i
                                                        class="icon-arrow-right14 position-left"></i> Organization
                                                        Modules</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="menu-heading underlined"><i class="icon-user position-left"></i>  Group Management</span>
                                                    <ul class="menu-list">
                                                        <li><a href="{{ route('groupLevel') }}" rel="tab"><i
                                                            class="icon-arrow-right14 position-left"></i> User Group </a></li>
                                                            <li><a href="{{ route('systemUser') }}" rel="tab"><i
                                                                class="icon-arrow-right14 position-left"></i> System User </a></li>
                                                                <li><a href="{{ route('manageUserAccess') }}" rel="tab"><i
                                                                    class="icon-arrow-right14 position-left"></i> Manage System User
                                                                    Access </a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" rel="tab" title="Reports"><i class="icon-file-spreadsheet position-left"></i> Reports</a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" rel="tab" title="Help"><i class="icon-help position-left"></i> Help</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>