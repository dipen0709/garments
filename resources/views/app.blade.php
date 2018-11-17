<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Star Admin</title>
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" type="text/css" />  
        <link rel="stylesheet" href="{{ asset('node_modules/font-awesome/css/font-awesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
        <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('/css/toaster.css') }}" type="text/css" />
        
     
        <script type="text/javascript">
            var base_url = "{{URL::to('/').'/'}}";
            var langauge_var = {!! json_encode(trans('javascript')); !!};
         </script>

  
        <script src="{{ asset('/js/jquery.min.js') }}"></script>  
        <script src="{{ asset('/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/js/additional-methods.js') }}"></script>
        <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('/js/toaster.js') }}"></script>
    </head>
    <body>

        <div class=" container-scroller">
            <!--Navbar-->
            @include('includes/header')
            <!--End navbar-->


            <div class="container-fluid">
                <div class="row row-offcanvas row-offcanvas-right">

                    <!-- SIDEBAR Start -->
                    @include('includes/sidebar')
                    <!-- SIDEBAR ENDS -->
                    <div id="content" class="content-wrapper">
                        @yield('content')
                    </div>

                    @include('includes/footer')
                </div>
            </div>

        </div>

<script src="{{ asset('/js/common.js') }}"></script>
</body>
</html>
