<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Teste</title>
    <link rel="shortcut icon" href="/assets/images/webvendas/webvendas_logo_tab.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/assets/images/webvendas/webvendas_logo_tab.png" type="image/png"/>

    <link rel="stylesheet" href="/assets/css/main/app.css">
    <link rel="stylesheet" href="/assets/css/pages/auth.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo d-flex">
                        <a class="text-center" href="/">
                            <img class="w-75 h-100" src="/img/logo_empresa.png" alt="Logo"/>
                        </a>
                    </div>
                    <p class="auth-subtitle mb-4 text-center">
                        Faça seu login
                    </p>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror @error('password') is-invalid @enderror" placeholder="Usuário" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl @error('email') is-invalid @enderror @error('password') is-invalid @enderror" placeholder="Senha" required autocomplete="current-password"/>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                            <label class="form-check-label text-gray-600" for="flexCheckDefault" >
                                Lembrar de Mim
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            Entrar
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="auth-right d-flex justify-content-center align-items-start">
                    <img class="w-75 pt-5" src="/img/logo_teste.png" alt="">
                </div>
            </div>
        </div>
    </div>

</body>
</html>
