@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/cashoutrequests/admin/show.css') }}">
@endsection

@section('title')
    <title>Cashout Request Details</title>
@endsection

@section('adminContent')

    @forelse ($errors->all() as $error)
        <h6 class="alert alert-danger text-danger text-center my-3">{{ $error }}</h6>
    @empty
        
    @endforelse

    <section class="adminContent">
        <header>
            Cashout Request Details
        </header>
        <section class="container px-4 px-md-5">
            <div class="mb-2">
                <label>User Firstname</label>
                <h6>{{ $user->firstname }}</h6>
            </div>
            <div class="mb-2">
                <label>User Middlename</label>
                <h6>{{ $user->middlename }}</h6>
            </div>
            <div class="mb-2">
                <label>User Lastname</label>
                <h6>{{ $user->lastname }}</h6>
            </div>
            <div class="mb-2">
                <label>User Phone</label>
                <h6>{{ $user->phone_number }}</h6>
            </div>
            <div class="mb-2">
                <label>Account Code</label>
                <h6>{{ $user->account_code }}</h6>
            </div>
            <hr>
            <div class="mb-2">
                <label>Cashout Type</label>
                <h6>{{ strtoupper($cashoutrequest->type) }}</h6>
            </div>
            @if ($cashoutrequest->type === 'gcash')
                <div class="mb-2">
                    <label>Account Name</label>
                    <h6>{{ ucwords($cashoutDetails->account_name) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Account Number</label>
                    <h6>{{ $cashoutDetails->account_number }}</h6>
                </div>
            @elseif ($cashoutrequest->type === 'bank')
                <div class="mb-2">
                    <label>Account Name</label>
                    <h6>{{ ucwords($cashoutDetails->account_name) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Account Number</label>
                    <h6>{{ $cashoutDetails->account_number }}</h6>
                </div>
                <div class="mb-2">
                    <label>Bank Name</label>
                    <h6>{{ ucwords($cashoutDetails->bank_partner) }}</h6>
                </div>
            @elseif ($cashoutrequest->type === 'remit')
                <div class="mb-2">
                    <label>Recipient Firstname</label>
                    <h6>{{ ucwords($cashoutDetails->firstname) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Recipient Middlename</label>
                    <h6>{{ ucwords($cashoutDetails->middlename) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Recipient Lastname</label>
                    <h6>{{ ucwords($cashoutDetails->lastname) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Recipient Phone</label>
                    <h6>{{ $cashoutDetails->phone_number }}</h6>
                </div>
                <div class="mb-2">
                    <label>Home/Street/Barangay</label>
                    <h6>{{ ucwords($cashoutDetails->address) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Municipality</label>
                    <h6>{{ ucwords($cashoutDetails->municipality) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Province</label>
                    <h6>{{ ucwords($cashoutDetails->province) }}</h6>
                </div>
                <div class="mb-2">
                    <label>Province</label>
                    <h6>{{ ucwords($cashoutDetails->remittance_outlet) }}</h6>
                </div>
            @endif
            <hr>
            <div class="mb-2">
                <label>Total Amount To Be Sent</label>
                <h6 class="text-danger"><span>PHP</span> {{ number_format($cashoutrequest->deducted_amount) }}</h6>
            </div>
            <div class="buttonsContainer">
                <a href="{{ route('cashoutrequest.index') }}" class="btn btn-secondary fw-bold">GO BACK</a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#decline">DECLINE</button>
            </div>
            <h6 class="my-3 text-center">or</h6>
            <button class="button-submit mb-4" data-bs-toggle="modal" data-bs-target="#approve">APPROVE</button>
        </section>

        <!-- APPROVE MODAL -->
        <div class="modal fade" id="approve" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="approveLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('coderequest.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveLabel">You are about to approve this cashout request worth of PHP {{ number_format($cashoutrequest->deducted_amount) }}.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                            <p class="instructions">Please type your password to verify that it is really you
                                performing this cashout request approval.</p>
                        </div>
                        {{-- <input type="text" name="coderequest_id" value="{{ $coderequest->id }}" hidden>
                        <input type="text" name="number_of_codes" value="{{ $coderequest->number_of_codes }}" hidden>
                        <input type="text" name="user_id" value="{{ $coderequest->user_id }}" hidden> --}}
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
                <form action="{{ route('coderequest.destroy') }}" method="POST" class="modal-content">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="declineLabel">You are about to decline this cashout request.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                            <p class="instructions">Please type your password to verify that it is really you
                                performing this decline and deletion of this cashout request.</p>
                        </div>
                        {{-- <input type="text" name="coderequest_id" value="{{ $coderequest->id }}" hidden>
                        <input type="text" name="number_of_codes" value="{{ $coderequest->number_of_codes }}" hidden>
                        <input type="text" name="user_id" value="{{ $coderequest->user_id }}" hidden> --}}
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