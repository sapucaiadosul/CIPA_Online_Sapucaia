<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CIPA Online</title>
</head>

<body>
    @include('layouts.header')
    @yield('content')
   

    <script type="text/javascript">
        $(document).ready(function() {
            $('#registration_number').mask('000000');
        });
    </script>
    <!-- JavaScript Bundle with Popper -->


    <script src="/js/jquery.blockUI.js"></script>


    <script>
        function mostrarTelaCarregando() {

            $.blockUI({
                message: '<img width="20%" src="{{ url(' / assets / img / loadingbar.gif ')}}"/>',
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
    </script>

</body>

</html>