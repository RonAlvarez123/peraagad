@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/usercaptcha/create.css') }}">
@endsection

@section('title')
    <title>Captcha</title>
@endsection

@section('contentContainer')
    <form action="{{ route('usercaptcha.store') }}" method="POST" class="contentContainer">
        @error('value')
            <div class="alert alert-danger text-danger text-center">{{ $message }}</div>
        @enderror
        @csrf
        <h4>Captcha</h4>
        @if ($captcha)
            <div class="captchaContainer">
                <img src="{{ asset('storage/captcha/'. $captcha->path) }}" alt="Captcha Image">
            </div>
            <div class="valueContainer">
                <label>Enter Captcha Value:</label>
                <input type="text" class="form-control" required name="value">
            </div>
            <input type="text" hidden value="{{ $captcha->id }}" name="id">
            <div class="buttonGreenContainer">
                <button type="submit" class="buttonGreen">SUBMIT</button>
            </div>
        @else
            <h6>There's no available captcha currently.</h6>
        @endif
    </form>
@endsection