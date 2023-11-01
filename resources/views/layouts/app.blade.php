<!doctype html>
<html>
<head>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('hyper/saas/assets/images/favicon.ico')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Theme Config Js -->
    <script src="{{asset('hyper/saas/assets/js/hyper-config.js')}}"></script>

    <!-- App css -->
    <link href="{{asset('hyper/saas/assets/css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- Icons css -->
    <link href="{{asset('hyper/saas/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Datatable -->
    <link href="{{asset('hyper/saas/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('hyper/saas/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @include('includes.head')

</head>
<body>

@include('includes.header')
<div class="content-page">
    <div class="content">
    </div>
    <div id="content" class="col page">
        <div class="page-title-box">
            <span class="page-title"> @yield('tittle','Default')</span>
        </div>
        @yield('content')
    </div>
</div>

{{--<!-- Vendor js -->--}}
<script src="{{asset('hyper/saas/assets/js/vendor.min.js')}}"></script>

<!-- Code Highlight js -->
<script src="{{asset('hyper/saas/assets/vendor/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('hyper/saas/assets/js/hyper-syntax.js')}}"></script>

<!-- App js -->
<script src="{{asset('hyper/saas/assets/js/app.min.js')}}"></script>

<!-- Datatables js -->
<script src="{{asset('hyper/saas/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('hyper/saas/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('hyper/saas/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script
    src="{{asset('hyper/saas/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<!-- Datatable Init js -->
<script src="{{asset('hyper/saas/assets/js/pages/demo.datatable-init.js')}}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<script>
    function exibirMensagensToast() {
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
        @endif

        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif
    }

</script>
<script>
    $(document).ready(function () {
        exibirMensagensToast();
    });
</script>
</body>

</html>
