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
        <input type="text" class="form-control {{ $errors->has('account_number') ? 'border-danger' : '' }}"
            name="account_number" required value="{{ old('account_number') }}">
        @error('account_number')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Bank Name</label>
        <input type="text" class="form-control {{ $errors->has('bank_name') ? 'border-danger' : '' }}"
            name="bank_name" required value="{{ old('bank_name') }}">
        @error('bank_name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    @include('cashoutrequests.partial')
</form>