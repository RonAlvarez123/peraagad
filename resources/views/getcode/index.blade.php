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
        <h6>THESE ARE ALL YOUR AVAILABLE ACCOUNT CODES THAT YOU CAN SELL</h6>
        <ul class="list-group">
            @foreach ($codes as $code)
                <li class="list-group-item">{{ $code->account_code }}</li>
            @endforeach
        </ul>
    </div>
    <h6 class="text-center text-danger">YOUR CUSTOMERS SHOULD PAY YOU FIRST BEFORE YOU GIVE THEM THEIR CODES</h6>
@endsection
        
