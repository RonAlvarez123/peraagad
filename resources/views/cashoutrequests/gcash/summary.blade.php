@extends('cashoutrequests.layout')

@section('cashoutContent')
    <section class="cashoutContent summary">

        <header>
            <h4>Cashout Summary</h4>
            <h5>We're now processing your request...</h5>
        </header>
        <section class="container px-4 px-md-5">
            <div class="amountContainer mb-2">
                <label>Account Name</label>
                <h6>{{ $gcash->account_name }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Account Number</label>
                <h6>{{ $gcash->account_number }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Cashout Type</label>
                <h6>{{ $cashoutRequest->type }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Previous Wallet Balance</label>
                <h6><span>PHP</span> {{ $account->getPreviousBalance() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Transfer Fee</label>
                <h6><span>PHP</span>{{ $account->getCashoutFee() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Withholding Tax</label>
                <h6><span>PHP</span> {{ $account->getCashoutTax() }}</h6>
            </div>
            <div class="amountContainer mb-2">
                <label>Cashout Total</label>
                <h6><span>PHP</span> {{ $account->getDeductedCashout() }}</h6>
            </div>
            <div class="balance my-4">
                <label>Your balance now is</label>
                <h6>{{ $account->getBalance() }} <span>PHP</span></h6>
            </div>
            <a href="{{ route('profile.index') }}" class="button-submit">DONE</a>
        </section>
    </section>
@endsection