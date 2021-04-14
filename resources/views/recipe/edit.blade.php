@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/recipe/edit.css') }}">
@endsection

@section('title')
    <title>Share Recipe</title>
@endsection

@section('contentContainer')
    <form action="{{ route('receipt.update') }}" method="POST" class="contentContainer my-3 mx-auto" enctype="multipart/form-data">
        @csrf
        @method('put')
        @if (session('status'))
            <div class="alert alert-success text-success mb-5">{{ session('status') }}</div>
        @endif
        @if($errors->has('partner') || $errors->has('file'))
            <div class="alert alert-danger text-danger mb-5">
                @error('partner')
                    {{ $message }}
                @enderror
                @error('file')
                    {{ $message }}
                @enderror
            </div>
        @endif
        <h4>Share Recipe</h4>
        <input class="form-control" type="file" id="formFile" required name="file">
        <button type="submit">SUBMIT</button>
    </form>
@endsection