<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> --}}

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.css') }}" rel="stylesheet">
    
    <!-- Mobile Responsive Styles -->
    <style>
        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0 !important;
            }
            
            .navbar-nav {
                flex-direction: column;
            }
            
            .table-responsive {
                font-size: 12px;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.25rem;
            }
            
            .btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .dropdown-menu {
                position: static !important;
                float: none;
                width: 100%;
                margin-top: 0;
                background-color: #fff;
                border: 1px solid #ccc;
                box-shadow: none;
            }
        }
        
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            
            .table th, .table td {
                padding: 0.25rem;
                font-size: 11px;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .card-body {
                padding: 0.75rem;
            }
            
            .modal-body {
                padding: 1rem 0.5rem;
            }
        }
        
        /* Touch-friendly buttons */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
        }
        
        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1050;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px;
                font-size: 18px;
            }
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Mobile Menu Toggle Button -->
        <button id="sidebarToggle" class="btn bg-dark d-lg-none mobile-menu-toggle">
            <i class="fa fa-bars"></i>
        </button>
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
            style="min-height: 100vh; padding-top: 10px; background-color:darkslategray">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon">
                    <img alt="Logo" class="rounded-circle logo__image" width="50" height="50"
                        src="{{ asset('adminProfile/laravel.png') }}">
                </div>
                <span class="logo__text text-white text-lg ml-2"> POS </span>

            </a>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a href="{{ route('adminDashboard') }}" class="btn text-start mb-2">
                    <i class="fas fa-home"></i>Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('categoryList') }}">
                    <i class="fas fa-th-list"></i>Categories
                </a>
            </li>

            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('productList') }}">
                    <i class="fas fa-box"></i>Products


                </a>
            </li>
            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('orderListPage') }}">
                    <i class="fas fa-shopping-cart"></i>Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('saleInfoList') }}">
                    <i class="fas fa-chart-line"></i>Sales
                </a>
            </li>


            @if (auth()->user()->role == 'superadmin')

            <li class="nav-item flex-column">
                <!-- Main Reports Menu -->
                <a class="btn text-start mb-2 toggle-submenu" href="#">
                    <i class="fa-solid fa-users"></i>Manage Users
                </a>

                <!-- Submenu (Hidden by Default) -->
                <ul class="submenu list-unstyled ms-2" style="display: none;">
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('createAdminAccount') }}">
                            <i class="fa-solid fa-users"></i> Add New Admin
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('resetPasswordPage') }}">
                            <i class="fas fa-lock fa-sm fa-fw"></i> Reset Password
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('adminList') }}">
                            <i class="fa-solid fa-user-tie"></i> Profile Info
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Cashier Management -->
            <li class="nav-item flex-column">
                <a class="btn text-start mb-2 toggle-submenu" href="#">
                    <i class="fa-solid fa-cash-register"></i>Cashier Management
                </a>

                <!-- Submenu (Hidden by Default) -->
                <ul class="submenu list-unstyled ms-2" style="display: none;">
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('cashier.index') }}">
                            <i class="fa-solid fa-list"></i> Cashier List
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('cashier.create') }}">
                            <i class="fa-solid fa-plus"></i> Add New Cashier
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('cashier.screen') }}">
                            <i class="fa-solid fa-cash-register"></i> POS Screen
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Shop Settings -->
            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('shop.settings') }}">
                    <i class="fa-solid fa-cog"></i>Shop Settings
                </a>
            </li>

            @endif

            <!-- Repair Services -->
            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('repair.index') }}">
                    <i class="fa-solid fa-tools"></i>Repair Services
                </a>
            </li>

            <!-- Warranty Management -->
            <li class="nav-item">
                <a class="btn text-start mb-2" href="{{ route('warranty.index') }}">
                    <i class="fa-solid fa-shield-alt"></i>Warranty Management
                </a>
            </li>

            <li class="nav-item flex-column">
                <!-- Main Reports Menu -->
                <a class="btn text-start mb-2 toggle-submenu" href="#">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>Reports
                </a>

                <!-- Submenu (Hidden by Default) -->
                <ul class="submenu list-unstyled ms-3" style="display: none;">
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('salesReportPage') }}">
                            <i class="fa-solid fa-chart-bar"></i> Sales Report
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('productReportPage') }}">
                            <i class="fa-solid fa-chart-bar"></i> Products Info
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="submenu-btn" href="{{ route('profitlossreportpage') }}">
                            <i class="fa-solid fa-chart-bar"></i> Profit & Loss
                        </a>
                    </li>
                </ul>
            </li>

            <hr class="sidebar-divider my-2">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <li class="nav-item">
                    <button type="submit" class="btn text-start mb-2">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </button>
                </li>
            </form>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper"  style="background-color: #f8f9fc;">
            <!-- Main Content -->
            <div id="content" >
                <!-- Topbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow mb-4 px-3" >
                    <!-- Navbar toggler (for mobile view) -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navbarContent" >
                        <ul class="navbar-nav">
                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="mr-2 text-dark">
                                        @if (auth()->user()->name != null)
                                            {{ auth()->user()->name }}
                                        @else
                                            {{ auth()->user()->nickname }}
                                        @endif
                                    </span>
                                    <img class="rounded-circle" width="40" height="40"
                                        src="{{ auth()->user()->profile ? asset('adminProfile/' . auth()->user()->profile) : asset('admin/img/undraw_profile.svg') }}">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('profileDetails') }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i> Profile
                                    </a>
                                    @if (auth()->user()->role == 'superadmin')
                                        <a class="dropdown-item" href="{{ route('createAdminAccount') }}">
                                            <i class="fas fa-user-plus fa-sm fa-fw mr-2 text-gray-600"></i> Add Admin
                                        </a>
                                    @endif
                                    @if (auth()->user()->provider == 'simple')
                                        <a class="dropdown-item" href="{{ route('passwordChange') }}">
                                            <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-600"></i> Change Password
                                        </a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-link dropdown-item text-danger">Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End of Topbar -->

                @yield('content')
                @include('sweetalert::alert')

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#sidebarToggle").click(function () {
                $(".sidebar").toggleClass("active");
            });

            // Ensure clicking outside closes sidebar
            $(document).click(function (event) {
                if (!$(event.target).closest(".sidebar, #sidebarToggle").length) {
                    $(".sidebar").removeClass("active");
                }
            });
        });

        function loadFile(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById('output');

                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0])
        }

           // Toggle submenu Reports
            $(document).ready(function(){
            $(".toggle-submenu").click(function(e){
                e.preventDefault(); // Prevent default link action
                $(this).next(".submenu").slideToggle();
            });
            
            // Mobile menu toggle functionality
            $("#sidebarToggle").click(function(){
                $(".sidebar").toggleClass("show");
            });
            
            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if ($(window).width() <= 768) {
                    if (!$(e.target).closest('.sidebar, #sidebarToggle').length) {
                        $('.sidebar').removeClass('show');
                    }
                }
            });
            
            // Handle window resize
            $(window).resize(function() {
                if ($(window).width() > 768) {
                    $('.sidebar').removeClass('show');
                }
            });
        });
    </script>

</body>

@yield('js-section')

</html>
