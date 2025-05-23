<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{'/admin'}}" class="logo d-flex align-items-center">
            <img src="{{asset('assets/images/logo.png')}}" alt="" style="width: 50px;height: 50px;max-height: 50px">
            <h5>Hebi</h5>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

{{--    <div class="search-bar">--}}
{{--        <form class="search-form d-flex align-items-center" method="POST" action="#">--}}
{{--            <input type="text" name="query" placeholder="Search" title="Enter search keyword">--}}
{{--            <button type="submit" title="Search"><i class="bi bi-search"></i></button>--}}
{{--        </form>--}}
{{--    </div><!-- End Search Bar -->--}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>


            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
{{--                    <img src="{{auth()->user()->avatar??asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">--}}
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{auth()->user()->name}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
{{--                    <li class="dropdown-header">--}}
{{--                        <h6>Kevin Anderson</h6>--}}
{{--                        <span>Web Designer</span>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">--}}
{{--                            <i class="bi bi-person"></i>--}}
{{--                            <span>My Profile</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">--}}
{{--                            <i class="bi bi-gear"></i>--}}
{{--                            <span>Account Settings</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">--}}
{{--                            <i class="bi bi-question-circle"></i>--}}
{{--                            <span>Need Help?</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('admin.logout')}}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>

</header>
