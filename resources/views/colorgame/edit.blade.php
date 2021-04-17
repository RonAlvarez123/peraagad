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
                    <div class="alert alert-info text-success text-center" role="alert">{{ session('status') }}</div>
                @endif
                @error('reward')
                    <div class="alert alert-danger text-danger text-center" role="alert">{{ $message }}</div>
                @enderror
                <h4>Color Game</h4>
                @if ($account->colorGame->canPlay())
                    <h6>Pick a color to win points.</h6>
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
                    <div class="alert alert-secondary text-secondary text-center" role="alert">You already played. Please come back after {{ $account->colorGame->getRemainingTime() }} to play again.</div>
                    <div><a href="{{ route('colorgame.edit') }}" class="btn btn-secondary mx-auto">Refresh</a></div>
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
                            <div class="col-4 col-sm-4">{{ number_format($reward['points']) }}</div>
                            <div class="col-4 col-sm-4">{{ number_format($reward['money']) }}</div>
                            <input type="hidden" name="reward" value="{{ $reward['id'] }}">
                            <div class="col-4 col-sm-4"><button class="btn btn-success {{ $reward['points'] > $account->colorGame->points ? 'disabled' : '' }}">Claim</button></div>
                        </form>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>

</html>