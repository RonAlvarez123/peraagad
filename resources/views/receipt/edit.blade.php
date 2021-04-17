@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/receipt/edit.css') }}">
@endsection

@section('title')
    <title>Upload Receipt</title>
@endsection

@section('contentContainer')
    <form action="{{ route('receipt.update') }}" method="POST" class="contentContainer my-3 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('put')
        @if (session('status'))
            <div class="alert alert-success text-success mb-5">{{ session('status') }}</div>
        @endif
        @if($errors->has('category') || $errors->has('file'))
            <div class="alert alert-danger text-danger mb-5">
                @error('category')
                    {{ $message }}
                @enderror
                @error('file')
                    {{ $message }}
                @enderror
            </div>
        @endif

        <h4>Upload Receipt</h4>

        @if ($receipt->canUploadReceipt())
            <input class="form-control" type="file" id="formFile" required name="file">
            <select class="form-select" aria-label="Default select example" required name="category">
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ ucwords($category) }}</option>
                @endforeach
            </select>
            <button type="submit">SUBMIT</button>
        @else
            <div class="alert alert-secondary text-secondary mb-5">You already uploaded. Please wait the reciept interval time for {{ $receipt->getRemainingTime() }} to upload again.</div>
        @endif
    </form>
@endsection