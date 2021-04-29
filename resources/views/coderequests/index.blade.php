@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/coderequests/index.css') }}">
@endsection

@section('title')
    <title>Code Requests</title>
@endsection

@section('adminContent')
    <section class="adminContent">
        @error('main_eror')
            <h6 class="alert alert-danger text-danger text-center my-3">{{ $message }}</h6>
        @enderror
        @if (session()->has('acceptMessage'))
            <h6 class="alert alert-success text-secondary text-center my-3">{{ session('acceptMessage') }}</h6>
        @elseif (session()->has('declineMessage'))
            <h6 class="alert alert-warning text-secondary text-center my-3">{{ session('declineMessage') }}</h6>
        @elseif (session()->has('errorMessage'))
            <h6 class="alert alert-danger text-danger text-center my-3">{{ session('errorMessage') }}</h6>
        @endif
        <form class="search">
            <h4>Search For A Code Request</h4>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select {{ $errors->has('category') ? 'border-danger' : '' }}" aria-label="Default select example" name="category" required value="{{ old('category') }}">
                    <option value="account_code">Account Code</option>
                    <option value="firstname">Firstname</option>
                    <option value="lastname">Lastname</option>
                </select>
                @error('category')
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
            <div class="mb-3">
                <label class="form-label">Value</label>
                <input type="text" class="form-control {{ $errors->has('value') ? 'border-danger' : '' }}" name="value" required value="{{ old('value') }}">
                @error('value')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="button-submit">SEARCH</button>
        </form>

        <div class="content">
            <div class="links">
                @forelse ($coderequests as $coderequest)
                    <a href="{{ route('coderequest.show', ['codeRequest' => $coderequest->id]) }}">
                        <section class="number">
                            <span>{{ $coderequest->number_of_codes }}</span>
                        </section>
                        <section class="details">
                            <div class="detailsHeader">
                                <h6>{{ $coderequest->user->account_code }}</h6>
                                <aside>{{ \Carbon\Carbon::parse($coderequest->requested_at)->diffForHumans() }}</aside>
                            </div>
                            <div class="nameContainer">{{ $coderequest->user->firstname . ' ' . $coderequest->user->lastname }}</div>
                        </section>
                    </a>
                @empty
                    <h5 class="text-center">No code requests found.</h5>
                @endforelse
            </div>
        </div>
    </section>
@endsection

    