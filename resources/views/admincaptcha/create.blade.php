@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/admincaptcha/create.css') }}">
    <script defer src="{{ asset('js/receipt/fileUpload.js') }}"></script>
@endsection

@section('title')
    <title>Add Captcha</title>
@endsection

@section('adminContent')
    <section class="content">
        {{-- <form action="{{ route('admincaptcha.store') }}" method="POST" class="contentContainer" enctype="multipart/form-data">
            @csrf
            @if (session('status'))
                <div class="alert alert-success text-success mb-5">{{ session('status') }}</div>
            @endif
            @if($errors->has('value') || $errors->has('file'))
                <div class="alert alert-danger text-danger mb-5">
                    @error('value')
                        {{ $message }}
                    @enderror
                    @error('file')
                        {{ $message }}
                    @enderror
                </div>
            @endif
            <h4>Add Captcha</h4>
            <input type="text" class="form-control" placeholder="Captcha Value" required name="value">
            <input class="form-control" type="file" id="formFile" required name="file">
            <button type="submit">SUBMIT</button>
        </form> --}}

        @if (session('status'))
            <h6 class="alert alert-info text-secondary text-center mb-3">{{ session('status') }}</h6>
        @endif

        <form action="{{ route('admincaptcha.store') }}" method="POST" enctype="multipart/form-data" class="contentContainer mt-5">
            @csrf
            <h4>Add Captcha</h4>
            <div class="file-upload-container">
                <input type="file" name="file" required>
                <div class="file-upload">
                    <p class="{{ $errors->has('file') ? 'border-danger text-danger' : '' }}">NO FILE SELECTED</p>
                    <button type="button">CHOOSE FILE</button>
                </div>
                @error('file')
                    <p class="text-danger error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Captcha Value</label>
                <input type="text" class="form-control" required name="value">
            </div>
            <div class="mt-4">
                <button type="submit" class="button-submit">SUBMIT</button>
            </div>        
        </form>
    </section>
@endsection