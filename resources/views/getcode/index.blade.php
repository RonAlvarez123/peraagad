@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/getcode/index.css') }}">
    <script defer src="{{ asset('js/getcode/copyToClipboard.js') }}"></script>
@endsection
   
@section('title')
    <title>My Valid Codes</title>
@endsection

@section('contentContainer')
    <div class="contentContainer">
        <div class="headerContainer">
            <h4>My Valid Codes</h4>
            @if ($account->totalCodeRequests() < 1)
                <h6 class="mx-auto text-secondary">Tip: You can go to <span class="text-success">GET CODE &gt; REQUEST CODE</span> tab to get a code.</h6>
            @else
                <h6 class="mx-auto text-secondary">Tip: You have <span class="text-info">{{ $account->totalCodeRequests() }}</span> pending code requests for a total worth of <span class="text-info">{{ $account->totalCodeRequests() * 300 }} Pesos</span>. Complete your payments to process your pending code requests.</h6>
            @endif
        </div>
   
        <div class="stats stats-mobile">
            <p>Account Codes:<span>{{ $account->totalCodes() }}</span></p>
            <p>Pending Requests:<span>{{ $account->totalCodeRequests() }}</span></p>
        </div>

        <div class="stats stats-desktop">
            <p>Available Account Codes: <span>{{ $account->totalCodes() }}</span></p>
            <p>Pending Code Requests: <span>{{ $account->totalCodeRequests() }}</span></p>
        </div>

        @if ($account->hasCodes())
            <section class="codes">
                <h5>Your Codes</h5>
                <div class="container tableContainer">

                @foreach ($account->codes as $code)
                    <div class="row dataContainer">
                        <div class="col-6 col-sm-6 text-secondary fw-bold">{{ $code->account_code }}</div>
                        <div class="col-6 col-sm-6 tool-tip-container">
                            <button class="btn btn-secondary fw-bold">Copy</button>
                            <p class="tool-tip-text">Copied!</p>
                        </div>
                    </div>
                @endforeach
        
                </div>
            </section>
        @endif

        <div class="instructions">Your customers should pay you first before you give them their codes.</div>
    </div>
@endsection
        
