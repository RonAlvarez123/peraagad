<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control mb-1 {{ $errors->has('password') ? 'border-danger' : '' }}" name="password" required>
    @error('password')
        <p class="text-danger">{{ $message }}</p>
    @else
        <label class="instructions">
            Enter your password to verify that it is you that wants to perform a cash out.
        </label>
    @enderror
</div>
<p class="text-secondary mb-3 mt-4 text-center">
    Please verify the accuracy and completeness of the details you entered before you submit.
</p>
<p class="text-danger mb-3 text-center">
    By clicking 'Confirm', you hereby accept full responsibility on the information provided,
    and hold PeraAgad free and harmless from any and all liability arising from this CashOut
    Transaction done with your PeraAgad Account.
</p>
<button type="submit" class="button-submit">CONFIRM CASHOUT</button>