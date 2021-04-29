@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/coderequests/show.css') }}">
@endsection

@section('title')
    <title>Code Request Details</title>
@endsection

@section('adminContent')

    @forelse ($errors->all() as $error)
        <h6 class="alert alert-danger text-danger text-center my-3">{{ $error }}</h6>
    @empty
        
    @endforelse

    <section class="adminContent">
        <header>
            Code Request Details
        </header>
        <section class="container px-4 px-md-5">
            <div class="mb-2">
                <label>Firstname</label>
                <h6>{{ $user->firstname }}</h6>
            </div>
            <div class="mb-2">
                <label>Middlename</label>
                <h6>{{ $user->middlename }}</h6>
            </div>
            <div class="mb-2">
                <label>Lastname</label>
                <h6>{{ $user->lastname }}</h6>
            </div>
            <div class="mb-2">
                <label>Phone Number</label>
                <h6>{{ $user->phone_number }}</h6>
            </div>
            <div class="mb-2">
                <label>City</label>
                <h6>{{ $user->city }}</h6>
            </div>
            <div class="mb-2">
                <label>Province</label>
                <h6>{{ $user->province }}</h6>
            </div>
            <div class="mb-2">
                <label>Account Code</label>
                <h6>{{ $user->account_code }}</h6>
            </div>
            <div class="mb-2">
                <label>Number Of Codes</label>
                <h6>{{ $coderequest->number_of_codes }}</h6>
            </div>
            <hr>
            <div class="mb-2">
                <label>Total Amount To Be Payed</label>
                <h6 class="text-danger"><span>PHP</span> {{ $coderequest->getTotalPrice() }}</h6>
            </div>
            <div class="buttonsContainer">
                <a href="{{ route('coderequest.index') }}" class="btn btn-secondary fw-bold">GO BACK</a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#decline">DECLINE</button>
            </div>
            <h6 class="my-3 text-center">or</h6>
            <button class="button-submit mb-4" data-bs-toggle="modal" data-bs-target="#approve">APPROVE</button>
        </section>

        <!-- APPROVE MODAL -->
        <div class="modal fade" id="approve" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="approveLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('coderequest.store', ['codeRequest' => $coderequest->id]) }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveLabel">You are about to create {{ $coderequest->number_of_codes }} codes.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                            <p class="instructions">Please type your password to verify that it is really you
                                performing this code request approval.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Confirm Approval</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- DECLINE MODAL -->
        <div class="modal fade" id="decline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="declineLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('coderequest.destroy', ['codeRequest' => $coderequest->id]) }}" method="POST" class="modal-content">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="declineLabel">Decline {{ $coderequest->number_of_codes }} code request.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                            <p class="instructions">Please type your password to verify that it is really you
                                performing this decline and deletion of this code request</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection