<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Tec LMS, Education and Course Theme</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="gya.tec.edu.pk">
    <meta name="description" content="Tec LMS, Education and Course Theme">

    <!-- Dark mode -->
    <script>
        const storedTheme = localStorage.getItem('theme')

        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'light'
        }

        const setTheme = function(theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }

        setTheme(getPreferredTheme())

        window.addEventListener('DOMContentLoaded', () => {
            var el = document.querySelector('.theme-icon-active');
            if (el != 'undefined' && el != null) {
                const showActiveTheme = theme => {
                    const activeThemeIcon = document.querySelector('.theme-icon-active use')
                    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                    const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

                    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                        element.classList.remove('active')
                    })

                    btnToActive.classList.add('active')
                    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                }

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (storedTheme !== 'light' || storedTheme !== 'dark') {
                        setTheme(getPreferredTheme())
                    }
                })

                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })

            }
        })
    </script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('lms/assets/images/JDkDBCmZyOdi.ico') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&amp;family=Roboto:wght@400;500;700&amp;display=swap">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lms/assets/vendor/font-awesome/css/1utjsqbNCPCd.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lms/assets/vendor/bootstrap-icons/1cXNoEpPUL8Z.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lms/assets/vendor/tiny-slider/WtOjf6ReNLhO.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lms/assets/vendor/glightbox/css/tkEtAThajl30.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/css/Qyl6XstUgIVe.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('lms/assets/css/Qyl6XstUgIVe.css') }}">

    <link rel="stylesheet" href="{{ asset('slider/jquery.jdSlider.css') }}">



</head>

<body>

    <!-- Header START -->
    <header class="navbar-light navbar-sticky header-static">
        <!-- Nav START -->
        <nav class="navbar navbar-expand-xl">
            <div class="container-fluid px-3 px-xl-5">
                <!-- Logo START -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="light-mode-item" src="{{ route('school.logo') }}" alt="logo" width="60px">
                </a>
                <!-- Logo END -->

                <!-- Responsive navbar toggler -->
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-animation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- Main navbar START -->
                <div class="navbar-collapse w-100 collapse" id="navbarCollapse">



                    <!-- Nav Main menu START -->
                    <ul class="navbar-nav navbar-nav-scroll me-auto">
                        <!-- Nav item 1 Demos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link active" href="{{ route('home') }}" id="demoMenu">Home</a>
                        </li>

                        <!-- Nav item 2 Pages -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesMenu" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Board</a>
                            <ul class="dropdown-menu" aria-labelledby="pagesMenu">

                                <li> <a class="dropdown-item" href="/board/1/Sindh%20Board">Sindh Board</a></li>
                                <li> <a class="dropdown-item" href="/board/2/Federal%20Board">Federal Board</a></li>
                                <li> <a class="dropdown-item" href="/board/3/Punjab%20Board">Punjab Board</a></li>
                                <li> <a class="dropdown-item" href="/board/4/Aga%20Khan%20Board">Agha Board</a></li>


                            </ul>
                        </li>




                    </ul>
                    <!-- Nav Main menu END -->


                    <!-- Nav Search END -->
                </div>
                <!-- Main navbar END -->

                <!-- Profile START -->
                <div class="dropdown ms-1 ms-lg-0">
                    @if (session('admin') || session('user'))
                        <a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button"
                            data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img class="avatar-img rounded-circle"
                                src="{{ asset('lms/assets/images/avatar/vhDtUJ9wGeOu.jpg') }}" alt="avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3"
                            aria-labelledby="profileDropdown">
                            <!-- Profile info -->
                            <li class="px-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <div class="avatar me-3">
                                        <img class="avatar-img rounded-circle shadow"
                                            src="{{ asset('lms/assets/images/avatar/vhDtUJ9wGeOu.jpg') }}"
                                            alt="avatar">
                                    </div>
                                    <div>
                                        <a class="h6" href="#">{{ session('user')['name'] }}</a>
                                        <p class="small m-0">
                                            {{ session('user')['super_admin'] == 1 ? 'SUPER ADMIN' : (session('admin') ? 'ADMIN' : 'TEACHER') }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Links -->
                            <li><a class="dropdown-item" href="{{ route('auth.login') }}"><i
                                        class="bi bi-person fa-fw me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear fa-fw me-2"></i>Account
                                    Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i
                                        class="bi bi-info-circle fa-fw me-2"></i>Help</a></li>
                            <li><a class="dropdown-item bg-danger-soft-hover" href="{{ route('auth.logout') }}"><i
                                        class="bi bi-power fa-fw me-2"></i>Sign Out</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Dark mode options START -->
                            <li>
                                <div
                                    class="bg-light dark-mode-switch theme-icon-active d-flex align-items-center p-1 rounded mt-2">
                                    <button type="button" class="btn btn-sm mb-0 active"
                                        data-bs-theme-value="light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-sun fa-fw mode-switch"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                            </path>
                                            <use href="#"></use>
                                        </svg> Light
                                    </button>
                                    <button type="button" class="btn btn-sm mb-0" data-bs-theme-value="dark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-moon-stars fa-fw mode-switch"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z">
                                            </path>
                                            <path
                                                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
                                            </path>
                                            <use href="#"></use>
                                        </svg> Dark
                                    </button>
                                    <button type="button" class="btn btn-sm mb-0" data-bs-theme-value="auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-circle-half fa-fw mode-switch"
                                            viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
                                            <use href="#"></use>
                                        </svg> Auto
                                    </button>
                                </div>
                            </li>
                            <!-- Dark mode options END-->
                        </ul>
                    @else
                        <a href="{{ route('auth.login') }}"
                            class="btn btn-lg btn-danger-soft me-2 mb-4 mb-sm-0">login</a>
                    @endif
                </div>
                <!-- Profile START -->
            </div>
        </nav>
        <!-- Nav END -->
    </header>
    <!-- Header END -->

    @yield('content')

    {{-- <div style="width: 100%; height: 0; padding-bottom: 36.25%; position: relative;">
        <img src="{{ asset('/images/footer.jpg') }}"
            style="position: absolute; width: 100%; height: 100%; object-fit: contain;">
    </div> --}}


    <!-- Back to top -->
    <div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('lms/assets/vendor/bootstrap/dist/js/9AkJyAqWe8qi.js') }}"></script>

    <!-- Vendors -->
    <script src="{{ asset('lms/assets/vendor/tiny-slider/VioBmmDY1QgE.js') }}"></script>
    <script src="{{ asset('lms/assets/vendor/glightbox/js/SPTn9k4E7g5b.js') }}"></script>
    <script src="{{ asset('lms/assets/vendor/purecounterjs/dist/XYMUxNlPXCJa.js') }}"></script>
    <!-- Template Functions -->
    <script src="{{ asset('lms/assets/js/W0S2RQhtno3D.js') }}"></script>

    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('slider/jquery.jdSlider-latest.js') }}"></script>

    <script>
        window.onload = function() {
            //  Top Crousel
            $('.slider2').jdSlider({
                wrap: '.slide-inner',
                isAuto: true,
                isLoop: true,
                interval: 2000
            });
        }
    </script>


</body>

</html>
