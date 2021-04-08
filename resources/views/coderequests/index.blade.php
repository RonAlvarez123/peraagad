@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/coderequests/index.css') }}">
@endsection

@section('title')
    <title>Code Requests</title>
@endsection

@section('adminContent')
    <section class="search">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="User Account Code" aria-label="User Account Code"
                aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
        </div>
    </section>

    <section class="list-group content">
        <div>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Account Code <span class="badge bg-primary rounded-pill">14</span></h5>
                    <small class="text-muted">3 days ago</small>
                </div>
                <div class="user-details">
                    <small class="text-muted">Phone Number</small>
                    <p class="m-0">User Full Name</p>
                </div>
                <small class="text-muted">Address</small>
            </div>
            <div class="formContainer">
                <form action="" class="formAccept">
                    <input type="text" value="1" hidden>
                    <button type="submit">Accept</button>
                </form>
                <form action="" class="formDecline">
                    <input type="text" value="1" hidden>
                    <button type="button">Decline</button>
                </form>
            </div>
        </div>
    </section>
@endsection

    