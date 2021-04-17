<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('profile.index') }}"><img class="navLogo" src="{{ asset('svg/navlogo.svg') }}" alt=""></a>
        @if (Request::path() === 'register')
            <ul class="navbar-nav">
                <p class="mb-1">Already a Member?</p>
                <li class="nav-item">
                    <a class="nav-link login-link" aria-current="page" href="{{ route('auth.index') }}">LOGIN</a>
                </li>
            </ul>
        @else
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    @if ($account->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                VIEW ALL REQUESTS
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'coderequest.index' ? 'active' : '' }}" href="{{ route('coderequest.index') }}">CODE REQUESTS</a></li>
                                <li><a class="dropdown-item" href="#">CASHOUT REQUESTS</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                ADD
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'admincaptcha.create' ? 'active' : '' }}" href="{{ route('admincaptcha.create') }}">CAPTCHA</a></li>
                                <li><a class="dropdown-item" href="#">SPELLING BEE</a></li>
                            </ul>
                        </li>
                        <form action="{{ route('auth.logout') }}" method="POST" class="nav-item">
                            @csrf
                            <button type="submit" class="nav-link stand-alone" aria-current="page">LOG OUT</button>
                        </form>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                MY ACCOUNT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'profile.index' ? 'active' : '' }}" href="{{ route('profile.index') }}">PROFILE</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item" href="">LOG OUT</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                WAYS TO EARN
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'receipt.edit' ? 'active' : '' }}" href="{{ route('receipt.edit') }}">UPLOAD RECEIPT</a></li>
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'usercaptcha.edit' ? 'active' : '' }}" href="{{ route('usercaptcha.edit') }}">CAPTCHA</a></li>
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'colorgame.edit' ? 'active' : '' }}" href="{{ route('colorgame.edit') }}">COLOR GAME</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                GET CODE
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'getcode.create' ? 'active' : '' }}" href="{{ route('getcode.create') }}">REQUEST CODE</a></li>
                                <li><a class="dropdown-item {{ Route::currentRouteName() === 'getcode.index' ? 'active' : '' }}" href="{{ route('getcode.index') }}">MY VALID CODES</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('about.index') }}">ABOUT</a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
</nav>
{{-- <div>{{ print_r(session()->all()) }}</div>
<div>{{ print_r(auth()->user()) }}</div> --}}