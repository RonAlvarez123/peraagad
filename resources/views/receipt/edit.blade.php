@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/receipt/edit.css') }}">
    <script defer src="{{ asset('js/receipt/fileUpload.js') }}"></script>
@endsection

@section('title')
    <title>Upload Receipt</title>
@endsection

@section('contentContainer')
    @if (session('status'))
        <h6 class="alert alert-info text-secondary text-center mb-3">{{ session('status') }}</h6>
    @endif

    <form action="{{ route('receipt.update') }}" method="POST" enctype="multipart/form-data" class="contentContainer mt-5">
        @csrf
        @method('put')
        <h4>Upload Receipt</h4>
        @if ($receipt->canUploadReceipt())
            <div class="file-upload-container">
                <input type="file" name="file">
                <div class="file-upload">
                    <p class="{{ $errors->has('file') ? 'border-danger text-danger' : '' }}">NO FILE SELECTED</p>
                    <button type="button">CHOOSE FILE</button>
                </div>
                @error('file')
                    <p class="text-danger error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3 select-container">
                <label class="form-label">Category</label>
                <select class="form-select" aria-label="Default select example" name="category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}">{{ ucwords($category) }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-danger error-message">{{ $message }}</p>
                @else
                    <p class="instructions">
                        Choose the corresponding category that applies to your receipt.
                    </p>
                @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="button-submit">SUBMIT</button>
            </div>
        @else
            <h6 class="alert alert-secondary text-center text-secondary mb-5">You already uploaded. Please wait the reciept interval time for {{ $receipt->getRemainingTime() }} to upload again.</h6>
            <div>
                <a href="" class="btn btn-secondary text-light fw-bold col-12">RELOAD</a>
            </div>
        @endif
       
    </form>
@endsection