<!DOCTYPE html>
<html lang="en">

<head>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/meo-store-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
    

    <!-- Style css -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <style>
        .title-header {
            padding: 0rem 0rem 0rem 1rem;
        }

        .button-header {
            padding: 0rem 1rem 0rem 0rem;
        }

        tfoot {
            display: table-row-group;
        }
    </style>
</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="" class="brand-logo">
                <img src="{{ asset('assets/images/vet-logo.jpeg') }}" style="width: 75px; height: 55px; border-radius: 8px;"  alt="">
                <div class="brand-title">
                    <h4 class="text-primary ms-2">MEO STORE</h4>
                </div>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->



        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">

                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                                    <i id="icon-light" class="fas fa-sun"></i>
                                    <i id="icon-dark" class="fas fa-moon"></i>
                                </a>
                            </li>

                            <li class="nav-item dropdown  header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="{{ asset('assets/images/logout.png') }}" width="56" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item ai-icon" type="submit">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                                width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12"></line>
                                            </svg>
                                            <span class="ms-2">Logout </span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('customers.index') }}" aria-expanded="false">
                            <i class="fa fa-users"></i>
                            <span class="nav-text">CUSTOMERS</span>
                        </a>
                    </li>
                </ul>
                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('sales.index') }}" aria-expanded="false">
                            <i class="fa fa-cart-shopping"></i>
                            <span class="nav-text">SALES</span>
                        </a>
                    </li>
                </ul>

                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('medicines.index') }}" aria-expanded="false">
                            <i class="fa fa-capsules"></i>
                            <span class="nav-text">MEDICINES</span>
                        </a>
                    </li>
                </ul>                
                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('suppliers.index') }}" aria-expanded="false">
                            <i class="fa fa-user-tie"></i>
                            <span class="nav-text">SUPPLIERS</span>
                        </a>
                    </li>
                </ul>
                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('stock_in.index') }}" aria-expanded="false">
                            <i class="fa-solid fa-cubes"></i>
                            <span class="nav-text">STOCK-IN</span>
                        </a>
                    </li>
                </ul>
                <ul class="metismenu" id="menu">
                    <li><a href="{{ route('stock_available.index') }}" aria-expanded="false">
                            <i class="fa-solid fa-cubes"></i>
                            <span class="nav-text">STOCK-AVAILABLE</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->


        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body default-height">
            <div class="app-hero-header d-flex justify-content-between pb-2 mt-2">
                <h5 class="d-flex align-items-center mb-0 pb-2 mt-0 title-header">@yield('title')</h5>
                <h5 class="button-header">@yield('button')</h5>
            </div>
            @include('includes.errors')
            @include('includes.success')
            <div class="container mt-0 pt-0">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a
                        href="https://www.linkedin.com/in/syed-mubashir-hussain-4aa01b330/" target="_blank">Mubashir</a>
                    2026</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/js/dlabnav-init.js')}}"></script>
    @stack('scripts')
    <script>
        function cardsCenter() {
            /*  testimonial one function by = owl.carousel.js */
            jQuery('.card-slider').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                //center:true,
                slideSpeed: 3000,
                paginationSpeed: 3000,
                dots: true,
                navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 1
                    },
                    800: {
                        items: 1
                    },
                    991: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1600: {
                        items: 1
                    }
                }
            })
        }


        function confirmDelete(action, successMessage = "Your file has been deleted.") {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#8449b5ff",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof action === 'function') {
                        action();
                    } else if (action instanceof HTMLFormElement) {
                        action.submit();
                    }
                }
            });
        }



        jQuery(window).on('load', function () {
            setTimeout(function () {
                cardsCenter();
            }, 1000);
        });
    </script>

</body>

</html>