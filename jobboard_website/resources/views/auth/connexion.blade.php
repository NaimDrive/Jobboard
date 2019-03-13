@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 border-right">
            <div class="mt-5">
                @include('auth.login')
            </div>

        </div>
        <div class="col-md-6 border-left">
            <div class="mt-5">
                @include('auth.register')
            </div>
        </div>
    </div>
@endsection
