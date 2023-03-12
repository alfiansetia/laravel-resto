@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <h2 class="section-title">Hi, {{ auth()->user()->name }}!</h2>
    <p class="section-lead">
        Change information about yourself on this page.
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card card-primary">
                <form method="POST" action="{{ route('user.profileUpdate') }}" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="type" value="profile">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" minlength="3" maxlength="25" placeholder="Please Input Name" required>
                                <div class="invalid-feedback">
                                    Please fill in the full name
                                </div>
                                @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7 col-12">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="Please Input Email" disabled>
                                <div class="invalid-feedback">
                                    Please fill in the email
                                </div>
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <label for="wa">WA</label>
                                <input type="tel" name="wa" id="wa" class="form-control" value="{{ auth()->user()->wa }}" minlength="3" maxlength="15" placeholder="Please Input WA" required>
                                <div class="invalid-feedback">
                                    Please fill in the WA
                                </div>
                                @error('wa')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="10" maxlength="150" required>{{ auth()->user()->address }}</textarea>
                                <div class="invalid-feedback">
                                    Please fill in the Address
                                </div>
                                @error('address')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card card-danger">
                <form method="POST" action="{{ route('user.profile') }}" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="type" value="password">
                    <div class="card-header">
                        <h4>Password</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-12 col-lg-6">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control pwstrength @error('password') is-invalid @enderror" data-indicator="pwindicator" minlength="8" placeholder="Please Input Password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="invalid-feedback">
                                    Please fill in the New Password
                                </div>
                                <div id="pwindicator" class="pwindicator">
                                    <div class="bar"></div>
                                    <div class="label"></div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="password2">Confirm Password</label>
                                <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror" value="" minlength="8" placeholder="Please Input Confirm" required>
                                @error('password2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="invalid-feedback">
                                    Please fill in the Confirm Password
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('jslib')
@endpush

@push('js')
@endpush