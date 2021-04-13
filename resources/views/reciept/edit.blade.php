@extends('layouts.layout')

@section('customStyle')
    <link rel="stylesheet" href="{{ asset('css/reciept/edit.css') }}">
@endsection

@section('title')
    <title>Upload Reciept</title>
@endsection

@section('contentContainer')
    <form action="{{ route() }}" method="POST" class="contentContainer my-3 mx-auto" enctype="multipart/form-data">
        @csrf
        @if (session('status'))
            <div class="alert alert-success text-success mb-5">{{ session('status') }}</div>
        @endif
        <h4>Upload Reciept</h4>
        <input class="form-control" type="file" id="formFile" required name="file">
        <select class="form-select" aria-label="Default select example" required name="partner">
            @foreach ($partners as $partner)
                <option value="{{ $partner }}">{{ ucwords($partner) }}</option>
            @endforeach
        </select>
        <button type="submit">SUBMIT</button>
    </form>
@endsection