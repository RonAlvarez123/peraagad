@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/getcode/create.css') }}">
@endsection

@section('title')
    <title>Request Code</title>
@endsection

@section('contentContainer')
    @if (session('status'))
        <h6 class="alert alert-info text-secondary text-center mx-auto">{{ session('status') }}</h6>
    @endif
    <form action="{{ route('getcode.store') }}" method="POST" class="contentContainer">
        @csrf
        <h4>Request Account Codes</h4>
        <h6>How many account codes would you like to buy?</h6>
        <div class="mb-3">
            <label class="form-label">Number of Codes: <span>(1 - 9)</span></label>
            <input type="number" class="form-control {{ $errors->has('number_of_codes') ? 'border-danger' : '' }}" min="0" max="9" required name="number_of_codes" value="{{ old('number_of_codes') }}">
            @error('number_of_codes')
                <p class="text-danger error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" required name="password">
            @error('password')
                <p class="text-danger error-message">{{ $message }}</p>
            @else
                <article class="text-secondary fw-bold">
                    Please type your password to confirm that it is you who is performing the code request.
                </article>
            @enderror
        </div>
        <p class="instructions text-secondary fw-bold">
            Click Submit to process your request. <br>
            <span class="text-danger">And send the proof of your payment to our Facebook Page.</span>
        </p>
        <div>
            <button type="submit" class="button-submit">SUBMIT</button>
        </div>
        
    </form>
@endsection
        
