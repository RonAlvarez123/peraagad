@extends('cashoutrequests.layout')

@section('cashoutContent')
    <form action="{{ route('bank.store') }}" method="POST" class="cashoutContent">
        @csrf

        <h4>Bank Transfer</h4>
        <div class="mb-3">
            <label class="form-label">Account Name</label>
            <input type="text" class="form-control {{ $errors->has('account_name') ? 'border-danger' : '' }}"
                name="account_name" required value="{{ old('account_name') }}">
            @error('account_name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Account Number</label>
            <input type="number" class="form-control {{ $errors->has('account_number') ? 'border-danger' : '' }}"
                name="account_number" required value="{{ old('account_number') }}">
            @error('account_number')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Bank Partner</label>
            <select class="form-select {{ $errors->has('bank_partner') ? 'border-danger' : '' }}" aria-label="Default select example"
                name="bank_partner" required value="{{ old('bank_partner') }}">
                @foreach ($partners as $partner)
                    <option value="{{ $partner }}">{{ ucwords($partner) }}</option>
                @endforeach
              </select>
            @error('bank_partner')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        @include('cashoutrequests.partial')
    </form>
@endsection