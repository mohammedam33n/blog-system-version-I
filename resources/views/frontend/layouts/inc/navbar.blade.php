<!-- Main wrapper -->
<div class="wrapper" id="wrapper">

    <!-- Header -->
    <header id="wn__header" class="oth-page header__area header__absolute sticky__header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                    <div class="logo">
                        <a href="index.html">
                            <img src="{{ asset('frontend/images/logo/logo.png') }}" alt="logo images">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <nav class="mainmenu__nav">
                        <ul class="meninmenu d-flex justify-content-start">
                            <li class="drop with--one--item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="drop with--one--item"><a href="{{ route('post.show', 'about-us') }}">About
                                    Us</a></li>
                            <li class="drop with--one--item"><a href="{{ route('post.show', 'our-vision') }}">Our
                                    Vision</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                    <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                        {{-- <li class="shop_search"><a class="search__active" href="#"></a></li> --}}


                        <li class="shopcart" id="userNotification">
                            <user-notification />
                        </li>

                        <li id="app">
                            <hello-world />
                        </li>


                        @if (Route::has('login'))
                            @auth
                                <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                                    <div class="searchbar__content setting__block">
                                        <div class="content-inner">

                                            <div class="switcher-currency">

                                                <strong class="label switcher-label">
                                                    <span class="currency-trigger">
                                                        {{-- <a href="{{ route('user.show', Auth::user()->username ) }}" class="text-decoration-none">{{ Auth::user()->name }}</a> --}}
                                                        {{-- <a href="{{ route('user.index') }}" class="text-decoration-none">{{ Auth::user()->name }}</a> --}}
                                                        <a href="{{ route('dashboard') }}"
                                                            class="text-decoration-none">{{ Auth::user()->name }}</a>

                                                    </span>
                                                </strong>





                                                @role(['admin||editor'])
                                                <strong class="label switcher-label">
                                                    <span class="currency-trigger">
                                                        <a href="{{ url('/admin') }}" class="text-decoration-none">Dashboard Admin</a>
                                                    </span>
                                                </strong>
                                                @endrole


                                                <div class="switcher-options">

                                                    <div class="switcher-currency-trigger">
                                                        <span class="currency-trigger">Languages</span>
                                                        <ul class="switcher-dropdown">
                                                            <li>English</li>
                                                            <li>Arabic</li>
                                                        </ul>
                                                    </div>


                                                    {{-- <div class="switcher-currency-trigger">
                                                        <span class="currency-trigger">
                                                            <a href="{{ route('user.index') }}"
                                                                class="text-decoration-none">My Dashboard</a>
                                                        </span>
                                                    </div> --}}

                                                    <div class="switcher-currency-trigger">
                                                        <span class="currency-trigger">
                                                            <a class="text-decoration-none"
                                                                href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                Logout
                                                            </a>
                                                        </span>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                            @else
                                <span><a class="text-decoration-none text-white"
                                        href="{{ route('login') }}">Login</a></span>
                            @endauth
                        @endif

                    </ul>
                </div>
            </div>
            <!-- Start Mobile Menu -->
            <div class="row d-none">
                <div class="col-lg-12 d-none">
                    <nav class="mobilemenu__nav">
                        <ul class="meninmenu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('post.show', 'about-us') }}">About Us</a></li>
                            <li><a href="{{ route('post.show', 'our-vision') }}">Our Vision</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- End Mobile Menu -->
            <div class="mobile-menu d-block d-lg-none">
            </div>
            <!-- Mobile Menu -->
        </div>
    </header>
    <!-- //Header -->

    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--6"></div>
    <!-- End Bradcaump area -->
