@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('title')
    <title>Register</title>
@endsection

@section('contentContainer')
    <form class="contentContainer">
        <h4>Sign Up</h4>
        <h5>
            Sign up now and experience earning money like never before. <br>
            Enjoy the cool and exciting offers that we have in store for you!
        </h5>
        <div class="mb-3">
            <label class="form-label">Firstname</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Middlename</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Lastname</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="number" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control">
        </div>
        <h6 class="address-label">Address*</h6>
        <div class="mb-3">
            <label class="form-label">Home/Street/Barangay</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">City/Municipality</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Province</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Account Code</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control">
        </div>
        <h6 class="disclaimer">
            By Creating an Account, you agree to our policies. <br>
            You may recieve SMS Notifications from us and can opt out any time.
        </h6>
        <div class="buttonGreenContainer">
            <button class="buttonGreen">Create Account</button>
        </div>
    </form>
@endsection