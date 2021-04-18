<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/colorgame/edit.css') }}">
    <title>Color Game</title>
</head>

<body>

    @include('layouts.nav')

    <main>
        <div class="sectionContainer">
            <section class="content">
                @if (session('status'))
                    <h6 class="alert alert-info text-secondary text-center my-3">{{ session('status') }}</h6>
                @endif
                @error('reward')
                    <h6 class="alert alert-danger text-danger text-center my-3" role="alert">{{ $message }}</h6>
                @enderror
                <h4>Color Game</h4>
                @if ($account->colorGame->canPlay())
                    <h6 class="fw-bold text-secondary">Pick a color to win points.</h6>
                    <form action="{{ route('colorgame.update') }}" method="POST" class="colorsContainer">
                        @csrf
                        @method('put')
                        <button type="submit"></button>
                        <button type="submit"></button>
                        <button type="submit"></button>
                        <button type="submit"></button>
                        <button type="submit"></button>
                        <button type="submit"></button>
                    </form>
                @else
                    <h6 class="alert alert-secondary text-secondary text-center my-3">You already played. Please come back after {{ $account->colorGame->getRemainingTime() }} to play again.</h6>
                    <div>
                        <a href="" class="btn btn-secondary text-light fw-bold col-12 my-3">RELOAD</a>
                    </div>
                @endif
            </section>
            <section class="stats">
                <p>Total Points: <span>{{ number_format($account->colorGame->points) }}</span></p>
                <p>Multiplier: <span>{{ $account->colorGame->multiplier }}x</span></p>
            </section>
            <section class="rewards">
                <h5>Rewards</h5>
                <div class="container tableContainer">
                    <div class="row headerContainer">
                        <div class="col-4 col-sm-4">Points</div>
                        <div class="col-4 col-sm-4">PHP</div>
                    </div>
                    @foreach ($rewards as $reward)
                        <form action="{{ route('colorgame.claim') }}" method="POST" class="row dataContainer">
                            @csrf
                            <div class="col-4 col-sm-4 fw-bold text-secondary">{{ number_format($reward['points']) }}</div>
                            <div class="col-4 col-sm-4 fw-bold text-secondary">{{ number_format($reward['money']) }}</div>
                            <input type="hidden" name="reward" value="{{ $reward['id'] }}">
                            <div class="col-4 col-sm-4"><button class="btn btn-success fw-bold {{ $reward['points'] > $account->colorGame->points ? 'disabled' : '' }}">Claim</button></div>
                        </form>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>

</html>