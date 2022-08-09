<!-- header -->
@include('backend.layouts.inc.header')


<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('backend.layouts.inc.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">


            <!-- Topbar -->
            @include('backend.layouts.inc.navbar')
            <!-- End of Topbar -->


            <!-- Begin Page Content -->
            <div class="container-fluid">
                @include('frontend.partials.flash')
                @yield('content')
            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; {{ config('app.name') }} 2022</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<!-- footer -->
@include('backend.layouts.inc.footer')
