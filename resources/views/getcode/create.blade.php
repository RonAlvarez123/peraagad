@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/getcode/create.css') }}">
@endsection

@section('title')
    <title>Request Code</title>
@endsection

@section('contentContainer')
    @if (session('status'))
        <div class="alert alert-success text-success text-center mx-auto">{{ session('status') }}</div>
    @endif
    <form action="{{ route('getcode.store') }}" method="POST" class="contentContainer">
        @csrf
        <h4>Request Account Codes</h4>
        <h6>How many account codes would you like to buy?</h6>
        <div class="mb-3">
            <label class="form-label">Number of Codes: <span>(1 - 9)</span></label>
            <input type="number" class="form-control {{ $errors->has('number_of_codes') ? 'border-danger' : '' }}" min="0" max="9" required name="number_of_codes">
            @error('number_of_codes')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" required name="password">
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @else
                <article>
                    Please type your password to confirm that it is you who is performing the code request.
                </article>
            @enderror
        </div>
        <p class="instructions">
            Click Submit to process your request <br>
            <span class="text-danger">and send the proof of your payment to our Facebook Page.</span>
        </p>
        <div class="buttonGreenContainer">
            <button type="submit" class="btn btn-primary buttonGreen">SUBMIT</button>
        </div>
    </form>
@endsection
        
