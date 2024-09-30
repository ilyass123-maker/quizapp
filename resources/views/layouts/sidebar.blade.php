<!-- Sidebar -->
<div class="col-xl-3 col-lg-4 col-md-12 theiaStickySidebar">
    <div class="settings-widget dash-profile">
        <div class="settings-menu p-0">
            <div class="profile-bg">
                
                <img src="{{ asset('assets/img/instructor-profile-bg.jpg') }}" alt="">
                <div class="profile-img">
                    <a href="#">
                        <img src="{{ asset('assets/img/user/user15.jpg') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="profile-group">
                <div class="profile-name text-center">
                    <!-- Show logged-in user's name and type (teacher or student) -->
                    <h4><a href="#">{{ Auth::user()->name }}</a></h4>
                    <p>{{ Auth::user()->type == 'teacher' ? 'Teacher' : 'Student' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="settings-widget account-settings">
        <div class="settings-menu">
            <h3>DASHBOARD</h3>
            <ul>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-home"></i> My Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-book"></i> My Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-star"></i> Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-pie-chart"></i> Earnings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-shopping-bag"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-users"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-dollar-sign"></i> Payouts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="feather-server"></i> Support Tickets
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
