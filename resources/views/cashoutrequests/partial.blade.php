<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" class="form-control mb-1 {{ $errors->has('password') ? 'border-danger' : '' }}" name="password" required>
    @error('password')
        <p class="text-danger">{{ $message }}</p>
    @else
        <label class="instructions">
            Please type your password to verify that it is you that wants to perform a cash out.
        </label>
    @enderror
</div>
<p class="text-danger my-3">
    Note: Before you submit, please check that the details you entered are accurate and correct to avoid any problems and inconvinience. Your fault is not our fault.
</p>
<button type="submit" class="button-submit">CONFIRM CASHOUT</button>