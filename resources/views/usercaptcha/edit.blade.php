@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/usercaptcha/create.css') }}">
@endsection

@section('title')
    <title>Captcha</title>
@endsection

@section('contentContainer')
    <form action="{{ route('usercaptcha.update') }}" method="POST" class="contentContainer">
        @csrf
        @method('put')
        <div class="m-0 d-flex justify-content-start">
            <h5>Captcha No. <span class="badge bg-secondary">{{ $account->userCaptcha->number_of_captcha }} of 25</span></h5>
        </div>

        @error('value')
            <div class="alert alert-danger text-danger text-center">{{ $message }}</div>
        @enderror
        <h4>Captcha</h4>
        @if ($account->userCaptcha->canUseCaptcha())
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
                <h6 class="alert alert-secondary text-secondary mb-5">There's no available captcha currently.</h6>
            @endif
        @else
            <h6 class="alert alert-secondary text-secondary mb-5">You already submitted a captcha. Please wait the 15 second captcha interval to submit again.</h6>
        @endif
    </form>
@endsection