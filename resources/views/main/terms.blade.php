@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('css')
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>
@endsection

@section('background-color', 'bg-container')

@section('content')

    <div class="container w-50 m-auto">
        <div class="my-5">
            <h1 class="fw-bolder">Terms & Conditions</h1>
        </div>
        <h3 class="mb-3">Effective date: {!! $terms->effective_date !!}</h3>
        <hr class="mb-3">
        <div class="terms card p-5">
            {!! $terms->terms_and_conditions !!}
        </div>

    </div>

@endsection
