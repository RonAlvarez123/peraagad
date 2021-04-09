@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/getcode/index.css') }}">
@endsection
   
@section('title')
    <title>My Valid Codes</title>
@endsection

@section('contentContainer')
    <div class="contentContainer">
        <h4>My Valid Codes</h4>
        @if(count($codes) > 0)
            <h6>THESE ARE ALL YOUR AVAILABLE ACCOUNT CODES THAT YOU CAN SELL</h6>
        @else
            <h6 class="my-0">YOU HAVE NO AVAILABLE ACCOUNT CODES</h6>
        @endif
        @if ($times_requested_for_code > 0)
            <h6 class="text-primary my-2">
                AND YOU HAVE <span class="text-success fw-bold">{{ $account->totalCodeRequests() }}</span> PENDING CODE REQUESTS <br>
                PLEASE COMPLETE YOUR PAYMENTS TO PROCESS YOUR PENDING CODE REQUESTS
            </h6>
        @else
            <h6 class="my-0">PLEASE GO TO <span class="text-success fw-bold">REQUEST CODE</span> TAB TO GET A CODE</h6>
        @endif
        <ul class="list-group">
            @foreach ($codes as $code)
                <li class="list-group-item">{{ $code->account_code }}</li>
            @endforeach
        </ul>
    </div>
    <h6 class="text-center text-danger">YOUR CUSTOMERS SHOULD PAY YOU FIRST BEFORE YOU GIVE THEM THEIR CODES</h6>
@endsection
        
