<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img class="navLogo" src="{{ asset('svg/navlogo.svg') }}" alt=""></a>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            MY ACCOUNT
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item active" href="profile.html">PROFILE</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">LOG OUT</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            WAYS TO EARN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">UPLOAD RECEIPT</a></li>
                            <li><a class="dropdown-item" href="#">CAPTCHA</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">SIGN UP BONUS</a></li>
                            <li><a class="dropdown-item" href="#">MONTHLY BONUS</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">MATH SOLVER</a></li>
                            <li><a class="dropdown-item" href="#">ROULLETE</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            GET CODE
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="requestcode.html">REQUEST CODE</a></li>
                            <li><a class="dropdown-item" href="myvalidcodes.html">MY VALID CODES</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">ABOUT</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>