@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/usercaptcha/edit.css') }}">
@endsection

@section('title')
    <title>Captcha</title>
@endsection

@section('contentContainer')
    <form action="{{ route('usercaptcha.update') }}" method="POST" class="contentContainer">
        @csrf
        @method('put')
        <div class="captcha-badge">
            <span class="badge bg-secondary">{{ $account->userCaptcha->number_of_captcha }} of 25</span>
        </div>
        <h4 class="mb-4">Captcha</h4>
        @if ($account->userCaptcha->canUseCaptcha())
            @if ($captcha)
                <div class="captcha my-3">
                    <img src="{{ asset('storage/public/captcha/'. $captcha->path) }}" alt="Captcha Image" class="unselectable">
                </div>
                <div class="valueContainer">
                    <label class="form-label">Captcha Value</label>
                    <input type="text" class="form-control mb-1 {{ $errors->has('value') ? 'border-danger' : '' }}" required name="value">
                    @error('value')
                        <p class="text-danger error-message">{{ $message }}</p>
                    @else
                        <p class="instructions">
                            Enter all numbers and letters that you see in the image with their corresponding order.
                        </p>
                    @enderror
                </div>
                <input type="text" hidden value="{{ $captcha->id }}" name="id">
                <button type="submit" class="mt-3 button-submit">SUBMIT</button>
            @else
                <h6 class="alert alert-secondary text-secondary text-center mb-5">There's no available captcha currently.</h6>
            @endif
        @else
            <h6 class="alert alert-secondary text-secondary text-center mb-5">You already submitted a captcha. Please wait for {{ $account->userCaptcha->getRemainingTime() }} seconds to submit again.</h6>
            <div>
                <a href="" class="btn btn-secondary text-light fw-bold col-12">RELOAD</a>
            </div>
        @endif
     
    </form>
@endsection