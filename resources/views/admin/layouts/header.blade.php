<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../assets/img/logo_prefeitura.ico" type="image/x-icon" />
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap&subset=latin-ext" rel="stylesheet"> --}}

    <!-- Fonts and icons -->
    <script src="{{url('assets/js/core/jquery.3.2.1.min.js')}}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">

    <!-- Sweet Alert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="     sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link rel="stylesheet" href="{{url('css/__codepen_io_andytran_pen.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/atlantis.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/fonts.min.css')}}">

    <!-- DataPicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type='text/javascript' src='//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js'></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" type="text/javascript">
    </script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.6/chosen.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="/js/jquery.blockUI.js"></script>

    <script>

        function mostrarTelaCarregando(){
            $('#loading').show();
                $.blockUI({
                    message: "<img width='20%' src='{{ url('/assets/img/loadingbar.gif') }}'/>",
                    baseZ: 2000,
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: 'transparent',
                        opacity: 1, 
                        color: '#fff' 
                    },
                    overlayCSS:  { 
                    backgroundColor: '#fff', 
                    opacity: 0.6, 
                    cursor: 'wait',
                    },

                });
        }

        function ocultarTelaCarregando(){
            $.unblockUI();
        }

        function bloquearElemento(elemento){

            $(elemento).block({
                message: "<img width='80%' src='{{ url('/assets/img/loadingbar.gif') }}'/>",
                    baseZ: 2000,
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: 'transparent',
                        opacity: 1, 
                        color: '#fff' 
                    },
                    overlayCSS:  { 
                    backgroundColor: '#fff', 
                    opacity: 0.6, 
                    cursor: 'wait',
                    },

                });


            

        }
    </script>

    <style>

    .main-panel>.content {
    background-color: #f7f7f7 !important;
    }
    .container {
    padding: 20px !important;
    }  


    .card, .card-light {
    -webkit-box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
    -moz-box-shadow: 1px 1px 5px 0 rgba(69, 65, 78, .1) !important;
    box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
    }

    .footer {
        -webkit-box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
    -moz-box-shadow: 1px 1px 5px 0 rgba(69, 65, 78, .1) !important;
    box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
    }

    .sidebar, .sidebar[data-background-color=white] {
        -webkit-box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
    -moz-box-shadow: 1px 1px 5px 0 rgba(69, 65, 78, .1) !important;
    box-shadow: 1px 1px 5px 0 rgb(69 65 78 / 10%) !important;
}


.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
    color: #495057;
    border-color: #ced4da;
}

.btn:not(:disabled):not(.disabled) {
    border-color: #ced4da;
}

    </style>
 <!-- multiple select -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
</head>

<body data-background-color="bg4">

    <!-- multiple select -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="white">
                <button class="navbar-toggler sidenav-toggler" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->
