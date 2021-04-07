@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">
@endsection

@section('title')
    <title>Profile</title>
@endsection

@section('contentContainer')
    <div class="contentContainer">
        <div class="mainHeader">
            <h4 class="text-center my-3">Personal Info</h4>
        </div>
        <div class="subHeader">
            <h5>Profile</h5>
            <div class="text-danger">PLEASE PROVIDE THE CORRECT AND UPDATED INFORMATIONS BELOW</div>
        </div>
        <div class="details-grid name">
            <div class="firstname">FIRST NAME</div>
            <div class="middlename">MIDDLE NAME</div>
            <div class="lastname">LAST NAME</div>
            <h6>NAME</h6>
            <p class="first">{{ $user->firstname }}</p>
            <p class="middle">{{ $user->middlename }}</p>
            <p class="last">{{ $user->lastname }}</p>
        </div>
        <div class="details-grid address">
            <div class="city">CITY/MUNICIPALITY</div>
            <div class="province">PROVINCE</div>
            <h6>ADDRESS</h6>
            <p class="c">{{ $user->city }}</p>
            <p class="p">{{ $user->province }}</p>
        </div>
        <div class="details">
            <h6>PHONE</h6>
            <p>{{ $user->phone_number }}</p>
        </div>
        <div class="details">
            <h6>EMAIL</h6>
            <p>N/A</p>
        </div>
        <div class="details">
            <h6>ACCOUNT TYPE</h6>
            <p>{{ $account->level }}</p>
        </div>
        <div class="details">
            <h6>ACCOUNT CODE</h6>
            <p>{{ $user->account_code }}</p>
        </div>
    </div>
@endsection