<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/auth/index.css') }}">
    <title>Login</title>
</head>

<body>
    <main>
        @error('login_limit')
            <div class="alert-container">
                <div class="alert alert-danger">{{ $message }}</div>
            </div>
        @enderror
        @if (session()->has('status'))
            <div class="alert-container">
                <div class="alert alert-success">{{ session('status') }}</div>
            </div>
        @endif
        @error('account_code')
            <div class="alert-container">
                <div class="alert alert-danger">{{ $message }}</div>
            </div>
        @enderror

        @error('password')
            <div class="alert-container">
                <div class="alert alert-danger">{{ $message }}</div>
            </div>
        @enderror
        <div class="sectionContainer {{ session()->has('status') ? 'has-alert' : '' }} {{ $errors->has('account_code') ? 'has-alert' : '' }} {{ $errors->has('password') ? 'has-alert' : '' }}"> 

            <section class="sectionLogin1">
                <h4 class="loginHeader">
                    Being financially free is one step away
                    <br>
                    Login now and start making money!
                </h4>
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    <div class="inputContainer">
                        <input type="text" name="account_code" placeholder="Enter Account Code" required value="{{ old('account_code') }}">
                    </div>
                    <div class="inputContainer">
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="buttonGreenContainer"><button type="submit" class="buttonGreen">Login</button></div>
                </form>
                <h4>Not a member yet? <a href="{{ route('auth.create') }}" class="normalLink">Sign Up Now!</a></h4>
            </section>

            <section class="sectionLogin2">
                <div class="logoContainer">
                    <img class="logoLogin" src="{{ asset('svg/logo.svg') }}" alt="">
                </div>
                <p>Follow us on these social networks:</p>
                <div class="socialMedia">
                    <a href=""><img src="{{ asset('svg/insta.svg') }}" alt=""></a>
                    <a href=""><img src="{{ asset('svg/fb.svg') }}" alt=""></a>
                </div>
                <div class="linkGreenContainer">
                    <a href="{{ route('getcode.create') }}" class="linkGreen">Get Code</a>
                    <a href="" class="linkGreen">Cash Out</a>
                </div>
                <div class="extraDetails">
                    <span>For concerns and suggestions</span>
                    <span>Email us at:</span>
                    <span>peraagadcustomercare@gmail.com</span>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>