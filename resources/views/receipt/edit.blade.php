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
        <div class="alert alert-success text-success text-center mb-3">{{ session('status') }}</div>
    @endif

    <form action="{{ route('receipt.update') }}" method="POST" enctype="multipart/form-data" class="contentContainer mt-5">
        @csrf
        @method('put')
        <h4>Upload Receipt</h4>
        @if ($receipt->canUploadReceipt())
            <div class="file-upload-container">
                <input type="file" name="file">
                <div class="file-upload">
                    <p>NO FILE SELECTED</p>
                    <button type="button">CHOOSE FILE</button>
                </div>
                @error('file')
                    <p class="text-danger error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" aria-label="Default select example" name="category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}">{{ ucwords($category) }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-danger error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="buttonGreenContainer">
                <button type="submit" class="btn btn-primary buttonGreen">UPLOAD</button>
            </div>
        @else
            <div class="alert mb-5 already-uploaded">You already uploaded. Please wait the reciept interval time for {{ $receipt->getRemainingTime() }} to upload again.</div>
        @endif
       
    </form>
@endsection