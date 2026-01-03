<aside>
    <div class="flex-shrink-0 sidebar">
        <div class="nav col-md-11">
            <a href="{{ route('dashboard') }}" class="mx-auto"><img src="{{ asset('assets/images/logo.png') }}" alt="" height="50px" class="mx-auto"></a>
        </div>
        <ul class="list-unstyled mt-5 ps-0">

            <li class="mb-1" id="dashboard-dropdown">
                <a href="{{ route('dashboard') }}">
                    <button class="btn0 bn1 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse1"
                        aria-expanded="false">
                        <div class="btnname">
                            <i class="bx bxs-dashboard"></i> &nbsp;Dashboard
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="employee-dropdown">
                <a href="{{ route('employee') }}">
                    <button class="btn0 bn2 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse2"
                        aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-user"></i> &nbsp;Employee
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="project-dropdown">
                <a href="{{ route('project') }}">
                    <button class="btn0 bn3 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse3"
                        aria-expanded="true">
                        <div class="btnname">
                            <i class="fa-solid fa-clipboard-list"></i> &nbsp;Project
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="labour-dropdown">
                <a href="{{ route('labour') }}">
                    <button class="btn0 bn4 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="true">
                        <div class="btnname">
                            <i class="fa-solid fa-user-group"></i> &nbsp;Labour
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="labour-dropdown">
                <a href="{{ route('bulk.upload') }}">
                    <button class="btn0 bn8 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse8"
                        aria-expanded="true">
                        <div class="btnname">
                            <i class="fa-solid fa-upload"></i> &nbsp;Bulk Upload
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="contractor-dropdown">
                <a href="{{ route('contractor') }}">
                    <button class="btn0 bn5 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="true">
                        <div class="btnname">
                            <i class="fa-solid fa-users"></i> &nbsp;Contractor
                        </div>
                    </button>
                </a>
            </li>
            <li class="mb-1" id="attendance-dropdown">
                <a href="{{ route('attendence') }}">
                    <button class="btn0 bn6 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse6"
                        aria-expanded="true">
                        <div class="btnname">
                            <i class="fa-solid fa-calendar-check"></i> &nbsp;Attendance
                        </div>
                    </button>
                </a>
            </li>

            <li class="mb-1" id="reports-dropdown">
                <button class="btn0 bn7 btn-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collapse7"
                    aria-expanded="true">
                    <div class="btnname">
                        <i class="fa-solid fa-chart-simple"></i> &nbsp;Reports
                    </div>
                    <div class="righticon">
                        <i class="fa-solid fa-angle-down toggle-icon"></i>
                    </div>
                </button>
                <div class="collapse" id="collapse7" style="">
                    <ul class="btn-toggle-nav list-unstyled text-center ps-5 pb-3 mt-0 mb-2">
                        <li class="text-start pt-2"><a href="{{ route('labour_strength') }}" class="li1" style="color: var(--gray); font-size: 13px"
                                class="d-inline-flex text-decoration-none">Projectwise Labour Strength</a>
                        </li>
                        <li class="text-start pt-2"><a href="{{ route('nmr_labour') }}" class="li1" style="color: var(--gray); font-size: 13px"
                                class="d-inline-flex text-decoration-none">NMR Labour Bill</a>
                        </li>
                        <li class="text-start pt-2"><a href="{{ route('contractor.report') }}" class="li1" style="color: var(--gray); font-size: 13px"
                                class="d-inline-flex text-decoration-none">Contractor Report</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>

        <ul class="list-unstyled">
            <li class="mb-1">
                <a href="./logout.php">
                    <button class="btn0 btn-toggle collapsed" aria-expanded="false">
                        <div class="btnname">
                            <i class="fa-solid fa-right-from-bracket" style="color: red;"></i> &nbsp;Logout
                        </div>
                    </button>
                </a>
            </li>
        </ul>
    </div>
</aside>
