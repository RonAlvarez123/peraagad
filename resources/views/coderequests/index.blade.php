@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/coderequests/index.css') }}">
@endsection

@section('title')
    <title>Code Requests</title>
@endsection

@section('adminContent')
    {{-- <section class="search">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="User Account Code" aria-label="User Account Code"
                aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
        </div>
    </section>

    <section class="list-group content">
        @if (session()->has('acceptMessage'))
            <h5 class="alert alert-success text-success text-center">{{ session('acceptMessage') }}</h5>
        @elseif (session()->has('declineMessage'))
            <h5 class="alert alert-warning text-danger text-center">{{ session('declineMessage') }}</h5>
        @elseif (session()->has('errorMessage'))
            <h5 class="alert alert-danger text-danger text-center">{{ session('errorMessage') }}</h5>
        @endif
        @forelse ($coderequests as $coderequest)
        <div>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $coderequest->user->account_code }}<span class="badge bg-primary rounded-pill">{{ $coderequest->number_of_codes }}</span></h5>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($coderequest->requested_at)->diffForHumans() }}</small>
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
    @empty
        <h5 class="text-center">There are no code requests.</h5>
    @endforelse
    </section> --}}

    <section class="adminContent">
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
                    <a href="/admin/coderequests/{{ $coderequest->id }}">
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

    