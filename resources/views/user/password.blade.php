@extends('layouts.template')

@push('csslib')
@endpush

@push('css')
@endpush

@section('content')
<div class="section-header">
    <h1>Profile </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Hi, {{ auth()->user()->name }}!</h2>
    <p class="section-lead">
        Change your password on this page.
    </p>

    <div class="row mt-sm-4">
        <div class="col-6">
            <div class="card">
                <form method="POST" action="{{ route('user.passwordUpdate') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-12 col-lg-6">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control pwstrength @error('password') is-invalid @enderror" data-indicator="pwindicator" minlength="8" placeholder="Please Input Password" required>
                                <div id="pwindicator" class="pwindicator">
                                    <div class="bar"></div>
                                    <div class="label"></div>
                                </div>
                                @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="password2">Confirm Password</label>
                                <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror" value="" minlength="8" placeholder="Please Input Confirm" required>
                                <div class="invalid-feedback">
                                    Please fill in the Confirm Password
                                </div>
                                @error('password2')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jslib')
<script src="{{ asset('library/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $("#password").pwstrength();
    })
</script>
@endpush