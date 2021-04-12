@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/admincaptcha/create.css') }}">
@endsection

@section('title')
    <title>Add Captcha</title>
@endsection

@section('adminContent')
    <section class="content">
        <form action="{{ route('admincaptcha.store') }}" method="POST" class="contentContainer" enctype="multipart/form-data">
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
        </form>
    </section>
@endsection