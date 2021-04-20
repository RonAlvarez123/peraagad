<form action="{{ route('remit.store') }}" method="POST" class="cashoutContent">
    @csrf

    <h4>Money Remittance</h4>
    <div class="mb-3">
        <label class="form-label">Firstname</label>
        <input type="text" class="form-control {{ $errors->has('firstname') ? 'border-danger' : '' }}"
            name="firstname" required value="{{ old('firstname') }}">
        @error('firstname')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Middlename</label>
        <input type="text" class="form-control {{ $errors->has('middlename') ? 'border-danger' : '' }}"
            name="middlename" required value="{{ old('middlename') }}">
        @error('middlename')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Lastname</label>
        <input type="text" class="form-control {{ $errors->has('lastname') ? 'border-danger' : '' }}"
            name="lastname" required value="{{ old('lastname') }}">
        @error('lastname')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control {{ $errors->has('phone_number') ? 'border-danger' : '' }}"
            name="phone_number" required value="{{ old('phone_number') }}">
        @error('phone_number')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Municipality</label>
        <input type="text" class="form-control {{ $errors->has('municipality') ? 'border-danger' : '' }}"
            name="municipality" required value="{{ old('municipality') }}">
        @error('municipality')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Province</label>
        <input type="text" class="form-control {{ $errors->has('province') ? 'border-danger' : '' }}"
            name="province" required value="{{ old('province') }}">
        @error('province')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Home Address</label>
        <input type="text" class="form-control {{ $errors->has('address') ? 'border-danger' : '' }}"
            name="address" required value="{{ old('address') }}">
        @error('address')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    @include('cashoutrequests.partial')
</form>