<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POS Admin</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset ('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
        <link href="{{asset ('admin/css/sb-admin-2.css')}}" rel="stylesheet">
        <link href="{{asset ('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
        
        <!-- Mobile Responsive Styles for Authentication -->
        <style>
            @media (max-width: 768px) {
                .container {
                    padding: 0.5rem;
                }
                
                .card {
                    margin: 0.5rem;
                    border-radius: 0.5rem;
                }
                
                .card-body {
                    padding: 1.5rem 1rem;
                }
                
                .form-control {
                    font-size: 16px; /* Prevents zoom on iOS */
                    padding: 0.75rem;
                }
                
                .btn {
                    padding: 0.75rem 1.5rem;
                    font-size: 1rem;
                }
                
                .btn-block {
                    width: 100%;
                }
                
                .text-center {
                    text-align: center !important;
                }
                
                .mb-4 {
                    margin-bottom: 1rem !important;
                }
                
                .mt-4 {
                    margin-top: 1rem !important;
                }
            }
            
            @media (max-width: 576px) {
                .card-body {
                    padding: 1rem 0.75rem;
                }
                
                .form-control {
                    padding: 0.5rem;
                }
                
                .btn {
                    padding: 0.5rem 1rem;
                    font-size: 0.875rem;
                }
                
                .h4 {
                    font-size: 1.25rem;
                }
                
                .h5 {
                    font-size: 1.125rem;
                }
            }
            
            /* Touch-friendly elements */
            @media (hover: none) and (pointer: coarse) {
                .btn {
                    min-height: 44px;
                    min-width: 44px;
                }
                
                .form-control {
                    min-height: 44px;
                }
            }
        </style>

</head>

<body class="" style="background: linear-gradient(135deg, darkslategray, #2a9877);">

    @yield('content')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset ('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset ('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset ('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset ('admin/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
