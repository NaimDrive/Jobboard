@extends('layouts.master')

@section('content')

    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger"  style="margin-top: 2rem">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            @if(Request::get('errorMessage') !== null)
                <div class="alert alert-danger"  style="margin-top: 2rem">
                    <ul>
                        <li>{{ Request::get('errorMessage') }}</li>
                    </ul>
                </div>
            @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Modifier mon mot de passe</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('storeEditPassword') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="oldPassword" class="col-md-4 col-form-label text-md-right">Ancien mot de passe</label>

                                <div class="col-md-6">
                                    <input id="oldPassword" type="password" class="form-control" name="oldPassword" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newPassword" class="col-md-4 col-form-label text-md-right">Nouveau mot de passe</label>

                                <div class="col-md-6">
                                    <input id="newPassword" type="password" class="form-control" name="newPassword" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmPassword" class="col-md-4 col-form-label text-md-right">Confirmation mot de passe</label>

                                <div class="col-md-6">
                                    <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        Modifier mon mot de passe
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
