@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/getcode/create.css') }}">
@endsection

@section('title')
    <title>Request Code</title>
@endsection

@section('contentContainer')
    <form action="{{ route('getcode.store') }}" method="POST" class="contentContainer">
        @csrf
        @if (session()->has('status'))
            <div class="alert alert-success text-success">{{ session('status') }}</div>
        @endif
        @error('number_of_codes')
            <div class="alert alert-danger text-danger">{{ $message }}</div>
        @enderror
        <h4>Request Account Codes</h4>
        <h5>HOW MANY ACCOUNT CODES WOULD YOU LIKE TO BUY?</h5>
        <div>
            <label>Enter Desired No. of Codes</label>
            <input type="number" name="number_of_codes" class="form-control" min="0" max="9" required>
            <p>1 - 9</p>
        </div>
        <h5>TO PROCESS YOUR REQUEST <br>CLICK SUBMIT </h5>
        <h5 class="text-danger">AND SEND THE PROOF OF YOUR PAYMENT <br>TO OUR FACEBOOK PAGE </h5>
        <div class="buttonGreenContainer">
            <button type="submit" class="btn btn-primary buttonGreen">SUBMIT</button>
        </div>
    </form>
@endsection
        
