<!-- include header -->
@include('frontend.layouts.inc.header')

<!-- include navbar -->
@include('frontend.layouts.inc.navbar')

<!-- Main wrapper -->
<div class="wrapper" id="wrapper">

    <!-- Start Blog Area -->
    <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    @include('frontend.partials.flash')
                </div>

                    <!-- Start Content -->
                    @yield('content')
                    <!-- End Content -->



            </div>
        </div>
    </div>
    <!-- End Blog Area -->

</div>
<!-- //Main wrapper -->

<!-- include footer -->
@include('frontend.layouts.inc.footer')
