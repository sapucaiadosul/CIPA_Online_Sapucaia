<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Exemplo') }}</title>
  <script src="{{ asset('js/app.js') }}" defer></script>
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <style>
    div.input button:hover {
      color: white !important; 
    }
    div.input input:not([type='checkbox']):focus {
      border-color: rgb(61, 199, 237);
    }
  </style>
</head>
<body style="background-color: rgb(239, 239, 239)">
<div class="container" style="display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 80%;
                        padding-top: 150px">
    <div class="card" style="width: 25%">
        
        <div class="form">
          <div class="text-center" style="display: flex;
          justify-content: center;
          align-items: center;">
            <img style="width: 40%;
            height: 20%;
            padding-top: 30px"
              class="mx-auto w-40"
              src="{{url('assets/img/logo_cipa.png')}}"
              alt="logo"
            />
            <h4 class="text-xl font-semibold mt-1 mb-6 pb-1"></h4>
          </div>
                    
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    style="width: 85%"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    style="width: 85%" name="password" required autocomplete="current-password" placeholder="Senha">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                   
                    <button type="submit" style="
                    background: linear-gradient(
                      to right,
                      #3cbdf4,
                      #7dd4f4,
                      #93dcf1,
                      #b9e3ec
                    );
                    border-style: none;

                  ">
                        {{ __('Entrar') }}
                    </button>
                </div>
               
            </form>
        </div>
    </div>
</div>
</body>

<div style="position: absolute; bottom: 5%; text-align: center; width: 100%">
  {{ date('Y') }} &copy; Coordenadoria Geral de TIC - PMSL</li>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
integrity="sha256-Kg2zTcFO9LXOc7IwcBx1YeUBJmekycsnTsq2RuFHSZU=" crossorigin="anonymous"></script>
