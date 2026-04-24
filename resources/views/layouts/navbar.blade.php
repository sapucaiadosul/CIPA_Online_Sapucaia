<nav class="navbar navbar-header navbar-expand-s0" style="
background: linear-gradient(
  to right,
  #3cbdf4,
  #7dd4f4,
  #93dcf1,
  #b9e3ec
);
">

    <div class="container-fluid">
        <a href="/">
            <img src="{{url('assets/img/logo_prefeitura.png')}}" alt="Logo Prefeitura" class="img-navbar">
        </a>
        <img src="{{url('assets/img/logo_cipa.png')}}" alt="Logo Prefeitura" width="70px" height="70px">
            <a data-toggle="collapse" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i style="color:#fff"class="fas fa-sign-out-alt fa-2x"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    </div>
</nav>

</div>
