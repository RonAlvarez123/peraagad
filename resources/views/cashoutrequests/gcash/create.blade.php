@extends('cashoutrequests.layout')

@section('cashoutContent')
    <form action="{{ route('gcash.store') }}" method="POST" class="cashoutContent">
        @csrf

        <h4>Gcash</h4>
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

        @include('cashoutrequests.partial')
    </form>
@endsection