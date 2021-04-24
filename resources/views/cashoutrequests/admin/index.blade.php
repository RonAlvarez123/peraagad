@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/cashoutrequests/admin/index.css') }}">
@endsection

@section('title')
    <title>Cashout Requests</title>
@endsection

@section('adminContent')

    <section class="adminContent">
        @if (session()->has('acceptMessage'))
            <h6 class="alert alert-success text-secondary text-center my-3">{{ session('acceptMessage') }}</h6>
        @elseif (session()->has('declineMessage'))
            <h6 class="alert alert-warning text-secondary text-center my-3">{{ session('declineMessage') }}</h6>
        @elseif (session()->has('errorMessage'))
            <h6 class="alert alert-danger text-danger text-center my-3">{{ session('errorMessage') }}</h6>
        @endif
        <form class="search">
            <h4>Sort Cashout Requests</h4>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select {{ $errors->has('type') ? 'border-danger' : '' }}" aria-label="Default select example" name="type" required value="{{ old('type') }}">
                    <option value="gcash">Gcash</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="remit">Money Remittance</option>
                </select>
                @error('type')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Order by</label>
                <select class="form-select {{ $errors->has('order') ? 'border-danger' : '' }}" aria-label="Default select example" name="order" required value="{{ old('order') }}">
                    <option value="new">Newest First</option>
                    <option value="old">Oldest First</option>
                </select>
                @error('order')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="button-submit">SORT</button>
        </form>

        <div class="content">
            <div class="links">
                @forelse ($cashoutrequests as $cashoutrequest)
                    <a href="/admin/cashoutrequests/{{ $cashoutrequest->id }}">
                        <section class="number">
                            <span>PHP {{ number_format($cashoutrequest->deducted_amount) }}</span>
                        </section>
                        <section class="details">
                            <div class="detailsHeader">
                                <h6>{{ $cashoutrequest->user->firstname . ' ' . $cashoutrequest->user->lastname }}</h6>
                                <aside>{{ \Carbon\Carbon::parse($cashoutrequest->requested_at)->diffForHumans() }}</aside>
                            </div>
                            <div class="nameContainer">{{ strtoupper($cashoutrequest->type) }}</div>
                        </section>
                    </a>
                @empty
                    <h5 class="text-center">No code requests found.</h5>
                @endforelse
            </div>
        </div>
    </section>
@endsection

    