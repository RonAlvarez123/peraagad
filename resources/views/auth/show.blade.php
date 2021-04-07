@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/auth/show.css') }}">
@endsection

@section('title')
    <title>Register</title>
@endsection

@section('contentContainer')
    <form action="{{ route('auth.store') }}" method="POST" class="contentContainer">
        @csrf
        <h4>Sign Up</h4>
        <h5>
            Sign up now and experience earning money like never before. <br>
            Enjoy the cool and exciting offers that we have in store for you!
        </h5>
        <div class="mb-3">
            <label class="form-label">Firstname</label>
            <input type="text" class="form-control" required name="firstname" value="{{ old('firstname') }}">
            @error('firstname')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Middlename</label>
            <input type="text" class="form-control" required name="middlename" value="{{ old('middlename') }}">
            @error('middlename')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Lastname</label>
            <input type="text" class="form-control" required name="lastname" value="{{ old('lastname') }}">
            @error('lastname')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="number" class="form-control" required name="phone_number" value="{{ old('phone_number') }}">
            @error('phone_number')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>


        {{-- <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" aria-label="Default select example" name="role">
                <option value="user">User</option>
                <option value="moderator">Moderator</option>
                <option value="admin">Admin</option>
            </select>
        </div> --}}


        <h6 class="address-label">Address*</h6>
        <div class="mb-3">
            <label class="form-label">Home/Street/Barangay</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">City/Municipality</label>
            <input type="text" class="form-control" required name="city" value="{{ old('city') }}">
            @error('city')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Province</label>
            <input type="text" class="form-control" required name="province" value="{{ old('province') }}">
            @error('province')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Account Code</label>
            <input type="text" class="form-control" name="account_code" value="{{ old('account_code') }}">
            @error('account_code')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" required name="password">
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <h6 class="disclaimer">
            By Creating an Account, you agree to our policies. <br>
            You may recieve SMS Notifications from us and can opt out any time.
        </h6>
        <div class="buttonGreenContainer">
            <button type="submit" class="buttonGreen">Create Account</button>
        </div>
    </form>
@endsection