@extends('cashoutrequests.layout')

@section('cashoutContent')
    <section class="cashoutContent summary">

        <header>
            <h5>We're now processing your request...</h5>
        </header>
        <section class="container px-4 px-md-5">
            <div class="amountContainer mb-2">
                <label>First Name</label>
                <h6>{{ $remit->firstname }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Middle Name</label>
                <h6>{{ $remit->middlename }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Last Name</label>
                <h6>{{ $remit->lastname }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Phone Number</label>
                <h6>{{ $remit->phone_number }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Municipality</label>
                <h6>{{ $remit->municipality }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Province</label>
                <h6>{{ $remit->province }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Home/Street/Barangay</label>
                <h6>{{ $remit->address }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Cashout Type</label>
                <h6>Money Remittance</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Remittance Outlet</label>
                <h6>{{ ucwords($remit->remittance_outlet) }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Previous Wallet Balance</label>
                <h6><span>PHP</span> {{ $account->getPreviousBalance() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Transfer Fee</label>
                <h6><span>PHP</span> {{ $account->getCashoutFee() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Withholding Tax</label>
                <h6><span>PHP</span> {{ $account->getCashoutTax() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Amount to be Recieved</label>
                <h6 class="text-danger"><span>PHP</span> {{ $account->getDeductedCashout() }}</h6>
            </div>
            <div class="balance my-4">
                <label>Your balance now is</label>
                <h6>{{ $account->getBalance() }} <span>PHP</span></h6>
            </div>
            <a href="{{ route('profile.index') }}" class="button-submit">DONE</a>
        </section>
    </section>
@endsection