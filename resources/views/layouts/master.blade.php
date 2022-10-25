<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="base_url" content="{{url('')}}">
    <title>@yield('title') |  پنل مدیریت {{$titleSeo}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{fav_icon()}}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

{{--    @include('layouts.customizer')--}}

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

            <script>
                @if(session()->has('err_message'))
                $(document).ready(function () {
                    Swal.fire({
                        title: "ناموفق",
                        text: "{{ session('err_message') }}",
                        icon: "warning",
                        timer: 6000,
                        timerProgressBar: true,
                    })
                });
                @endif
                @if(session()->has('flash_message'))
                $(document).ready(function () {
                    Swal.fire({
                        title: "موفق",
                        text: "{{ session('flash_message') }}",
                        icon: "success",
                        timer: 6000,
                        timerProgressBar: true,
                    })
                })
                ;@endif
                @if (count($errors) > 0)
                $(document).ready(function () {
                    Swal.fire({
                        title: "ناموفق",
                        icon: "warning",
                        html:
                                @foreach ($errors->all() as $key => $error)
                                    '<p class="text-right mt-2 ml-5" dir="rtl"> {{$key+1}} : ' +
                            '{{ $error }}' +
                            '</p>' +
                                @endforeach
                                    '<p class="text-right mt-2 ml-5" dir="rtl">' +
                            '</p>',
                        timer: @if(count($errors)>3)parseInt('{{count($errors)}}') * 1500 @else 6000 @endif,
                        timerProgressBar: true,
                    })
                });
                @endif
            </script>
</body>

</html>
