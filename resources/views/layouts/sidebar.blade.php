<!-- Sidebar -->
<head>
    <style>
            
        .sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a {
            background: #006400 !important;
        }
        .btn-outline-secondary, a .btn-outline-secondary{
            color: #006400 !important;;
            border: 1px solid #006400 !important;;
        }
        .btn-outline-secondary:hover, a .btn-outline-secondary:hover{
            background-color: #006400 !important;;
            border: #006400 !important;;
            color: #fff !important;;
        }
        .page-item.active .page-link {
            background-color: #006400 !important;
            border-color: #006400 !important;
        }
        .modal-header {
            background-color: #006400 !important;
        }
        .form-control:focus {
            border-color: rgb(167, 21, 246) !important;
        }

    </style>
    <head>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
             
                @if (auth()->check())
                    <li class="nav-item">
                    <hr style="margin-top: 0px; margin-bottom: 0px; margin: 0px">
                    <a style="margin-top: 0px !important;">
                    <i class="fas fa-user"></i>

                    <p> @if (strlen(Auth::user()->name) > 19)
                            {{ substr(Auth::user()->name, 0, 16).'...'}}
                        @else
                            {{ Auth::user()->name }}
                        @endif
                    </p>
                    </a>  
                @endif

               <hr style="margin-top: 0px; margin-bottom: 5px;"> --}}
                </li>  

                <li class="nav-item {{ (request()->Is('/')) ? 'active' : '' }}" class="sr-only" >
                    <a href="/">
                        <i class="fas fa-home"></i>
                        <p>Menu Incial</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('Candidato_Create')) || (request()->is('Candidato_Listar'))  ? 'active' : '' }}">
                    <a data-toggle="collapse"  aria-controls="collapseOne" href="#base">
                        <i class="fas fa-users"></i>
                        <p>Candidatos</p>
                        <span class="caret"></span>
                    </a>
                    <div class="expandable collapse {{ (request()->routeIs('')) || (request()->routeIs('')) || (request()->routeIs('Candidato_Create')) ? 'show' : '' }}"
                        aria-controls="collapseOne" id="base">
                        <ul class="nav nav-collapse ">
                            <a href="{{ route('Candidato_Index') }}">
                                <i class="fas fa-plus"></i>
                                <span class="sub-item">Inscrição de Candidato</span>
                            </a>
                            <a href="{{ route('Candidato_Listar') }}">
                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                               <span class="sub-item">Manutenção de Candidato</span>
                            </a>
 
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sidebarLayouts">
                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                        <p>Votação CIPA</p>
                        <span class="caret"></span>
                    </a>
                    <div class="expandable collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                                <a href="{{ route('Votacao_Index') }}">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    <span class="sub-item">Votação</span>
                                </a>
                                <a href="{{ route('acompanhamento.votacao') }}">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    <span class="sub-item">Votar</span>
                                </a>
                                <a href="{{ route('Votacao_Resultados') }}">
                                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                                    <span class="sub-item">Resultados</span>
                                </a>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sidebarLayouts2">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                        <p>Comissão Eleitoral</p>
                        <span class="caret"></span>
                    </a>
                    <div class="expandable collapse" id="sidebarLayouts2">
                        <ul class="nav nav-collapse">
                                <a href="{{ route('Eleicoes_Create') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span class="sub-item">Cadastrar Dados de Eleições</span>
                                </a>
                                <a href="{{ route('Eleicoes_Listar') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span class="sub-item">Manutenção de Dados de Eleições</span>
                                </a>
                                <a href="{{ route('Usuarios_registeruser') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span class="sub-item">Registrar Usuários</span>
                                </a>
                         
                                <a href="{{ route('Usuarios_listUser') }}">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                    <span class="sub-item">Manutenção de Usuários</span>
                                </a>
                            
                               <a href="{{ route('Audits_listAll') }}">
                                <i class="fa fa-archive" aria-hidden="true"></i>
                                    <span class="sub-item">Auditoria de Operações</span>
                                </a>
                            
                                <a href="{{ route('Access_listAll') }}">
                                    <i class="fa fa-archive" aria-hidden="true"></i>
                                        <span class="sub-item">Auditoria de Acessos</span>
                                </a>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Sair</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->