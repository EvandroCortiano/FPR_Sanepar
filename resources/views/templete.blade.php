<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- TITULO DAS PAGINAS -->
    <title>@yield('title')</title>

    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <!-- TOASTR CORE STYLE  -->
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <!-- Scripts -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <!-- TOASTR SCRIPTS  -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <!-- MASK SCRIPTS  -->
    <script src="{{ asset('js/mask.js') }}"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap.min.js') }}"></script>
    <!-- CONFIRMATION -->
    <script src="{{ asset('js/confirmation/bootstrap-confirmation.min.js') }}"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    {{-- <header>
        <div class="container")
            <div class="row">
                <div class="col-md-12">
                    <strong>Email: </strong>evandrocortiano@gmail.com
                    &nbsp;&nbsp;
                    <strong>Support: </strong>(41) 99980-6992
                </div>

            </div>
        </div>
    </header> --}}
    <!-- HEADER END-->

    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../home">
                    <img src="{{ asset('img/pro-renal.png') }}" width="200" />
                </a>
            </div>
            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">

                        <li class="dropdown pull-right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    {{ Auth::user()->name }}
                                    {{-- <a class="media-left" href="#">
                                        <img src="{ { asset('img/64-64.jpg') }}" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Evandro</h4>
                                        <h5>Developer & Designer</h5>
                                    </div> --}}
                                </div>
                                <hr />
                                {{-- <h5><strong>Personal Bio : </strong></h5>
                                Anim pariatur cliche reprehen derit.
                                <hr /> --}}
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger btn-sm">
                                    Sair do Sistema
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->

    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="/pessoas/" id="pessoasMenu">Pessoas</a></li>
                            <li><a href="/doador/doadores" id="doadorMenu">Doadores</a></li>
                            {{-- <li><a class="menu-top-active" href="index.html">Dashboard</a></li>
                            <li><a href="table.html">Data Tables</a></li>
                            <li><a href="forms.html">Forms</a></li>
                            <li><a href="login.html">Login Page</a></li>
                            <li><a href="blank.html">Blank Page</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="container">
    @yield('content')
</div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2018 Fundação Pró-Renal | By : <a href="mailto:evandrocortiano@gmail.com" target="_blank">evandrocortiano@gmail.com </a> (41) 99980-6992
                </div>
            </div>
        </div>
    </footer>
</body>
</html>