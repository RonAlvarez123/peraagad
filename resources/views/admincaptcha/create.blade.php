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
            @if($errors->has('captcha_value') || $errors->has('file'))
                <div class="alert alert-danger text-danger mb-5">
                    @error('capthca_value')
                        {{ $message }}
                    @enderror
                    @error('file')
                        {{ $message }}
                    @enderror
                </div>
            @endif
            <h4>Add Captcha</h4>
            <input type="text" class="form-control" placeholder="Captcha Value" required name="captcha_value">
            <input class="form-control" type="file" id="formFile" required name="file">
            <button type="submit">SUBMIT</button>
        </form>
    </section>
@endsection