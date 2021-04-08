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
        @foreach ($coderequests as $coderequest)
            <div>
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $coderequest->user->account_code }}<span class="badge bg-primary rounded-pill">{{ $coderequest->number_of_codes }}</span></h5>
                        <small class="text-muted">3 days ago</small>
                    </div>
                    <div class="user-details">
                        <small class="text-muted">{{ $coderequest->user->phone_number }}</small>
                        <p class="m-0">{{ $coderequest->user->firstname . ' ' . $coderequest->user->middlename . ' ' . $coderequest->user->lastname }}</p>
                    </div>
                    <small class="text-muted">{{ $coderequest->user->city . ' ' . $coderequest->user->province }}</small>
                </div>
                <div class="formContainer">
                    <form action="{{ route('coderequest.accept') }}" method="POST" class="formAccept">
                        @csrf
                        <input type="text" name="coderequest_id" value="{{ $coderequest->id }}" hidden>
                        <input type="text" name="number_of_codes" value="{{ $coderequest->number_of_codes }}" hidden>
                        <input type="text" name="user_id" value="{{ $coderequest->user_id }}" hidden>
                        <button type="submit">Accept</button>
                    </form>
                    <form action="{{ route('coderequest.decline') }}" method="POST" class="formDecline">
                        @csrf
                        @method('delete')
                        <input type="text" name="coderequest_id" value="{{ $coderequest->id }}" hidden>
                        <button type="submit">Decline</button>
                    </form>
                </div>
            </div>
        @endforeach
    </section>
@endsection

    