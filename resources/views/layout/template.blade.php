<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="shortcut icon" href="/assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/datepicker/datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/vendor/select2/select2.min.css">
</head>

<body>
    <div id="app">
        @include('layout.menu')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('title')</h3>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{date('Y')}} &copy; Yuri Ferreira</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('usuarios.modal-atualizar-senha')
    <script src="/assets/vendors/jquery/jquery.min.js"></script>
    <script src="/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>


    <script src="/assets/js/main.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/datepicker/bootstrap-datepicker.js"></script>
    <script src="/datepicker/bootstrap-datepicker.pt-BR.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>

    <script src="/js/init.js"></script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}', 'Erro!')
        </script>
        @endforeach
    @endif

    @if (session('mensagem'))
        @if(session('mensagem')['tipo'] == 'success')
        <script>
            toastr.success("{{session('mensagem')['mensagem']}}", 'Tudo Certo!')
        </script>
        @else
        <script>
            toastr.error('{{session("mensagem")["mensagem"]}}', 'Erro!')
        </script>
        @endif
    @endif

    <script>
        function deleteRegistro(url) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Deseja apagar o registro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }

        function confirmAction(url, msg, icon = 'warning') {
            Swal.fire({
                title: 'Tem certeza?',
                text: msg,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }

        $('.money').mask('000.000.000.000.000,00', {reverse: true});
        $(".datepicker-mes-ano").datepicker({
            language: 'pt-BR',
            format: "mm/yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        $('.prev i').removeClass();
        $('.prev i').addClass("fa fa-chevron-left");

        $('.next i').removeClass();
        $('.next i').addClass("fa fa-chevron-right");


        $('.isSelect2').select2();
    </script>
    @stack('js')
</body>

</html>
