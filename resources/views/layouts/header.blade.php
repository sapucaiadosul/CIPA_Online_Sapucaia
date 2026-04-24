<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <link rel="icon" href="../assets/img/logo_prefeitura.ico" type="image/x-icon" />


    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap&subset=latin-ext" rel="stylesheet"> -->

   
    <!-- Fonts and icons -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">

    <!-- Sweet Alert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="     sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- CSS Files -->
    <!-- <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}"> -->
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link rel="stylesheet" href="{{url('css/__codepen_io_andytran_pen.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/atlantis.min.css')}}">
    
    <link rel="stylesheet" href="{{url('assets/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/fonts.min.css')}}">

    <!-- DataPicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    
    <link rel="stylesheet" href="{{url('assets/fontawesome_6.3.0/css/all.min.css')}}">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type='text/javascript' src='//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js'></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" type="text/javascript">
    </script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.6/chosen.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="{{url('assets/js/atlantis.min.js')}}"></script>
    <script src="{{url('assets/js/atlantis2.js')}}"></script>

    <script src="{{url('assets/fontawesome_6.3.0/js/all.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="/js/jquery.blockUI.js"></script>

    <script>
        function mostrarTelaCarregando() {
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
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.6,
                    cursor: 'wait',
                },
            });
        }

        function ocultarTelaCarregando() {
            $.unblockUI();
        }

        function bloquearElemento(elemento) {
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
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.6,
                    cursor: 'wait',
                },

            });
        }
    </script>
    <style>

body{
background: #f7f7f7;

}
#preview {
  overflow: hidden;
  width: 50px; 
  height: 50px;
}

img {
  display: block;

  /* This rule is very important, please don't ignore this */
  max-width: 100%;
}
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

        .bootstrap-select>.dropdown-toggle.bs-placeholder,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
            color: #495057;
            border-color: #ced4da;
        }

.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
    color: #495057;
    border-color: #ced4da;
}

.card .card-header:first-child, .card-light .card-header:first-child {
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
}
.botao{
    background: #e57373 !important;
    border:0px  !important;
    border-radius: 20px !important;
    min-width: 150px !important;
}

.botao:hover{
    background: #e57a7a !important;

}

.degrade_login {
/* fallback for old browsers */
background: #1abc9c;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgb(67, 206, 162), #1abc9c) !important;

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgb(67, 206, 162), #1abc9c) !important;


border-top-left-radius: .9rem;
border-bottom-left-radius: .9rem;
width: 30%;

}

.secao_login{

    display: flex;
   align-items: center;
   justify-content: center;
   position: relative;
   width: 100%;
   height: 100vh;
   background-color: #eee;
}

#tabela_dados td{
    height: 25px !important;
    border: 0px !important;
    font-size: 14px !important;
    color: #606060;

}

.foto_candidato{

   
    width: 100%;
}

.coluna_foto{
    width: 15%;
    padding: 0px !important;
}

.botao_nulo{
    width: 40%;
    height: 35px;
    float: left;
}


   

.botao_branco{
    width: 40%;
    height: 35px;
    float: right;
}

.table td{
    border:0px !important;
}


</style>
 <!-- multiple select -->

</head>

<body data-background-color="bg4">
    @yield('content')
</body>

</html>