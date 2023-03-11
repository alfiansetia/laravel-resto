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
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Posts</div>
                            <div class="profile-widget-item-value">187</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Followers</div>
                            <div class="profile-widget-item-value">6,8K</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Following</div>
                            <div class="profile-widget-item-value">2,1K</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">{{ auth()->user()->name }}
                        <div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> @role('admin') Admin @else Kasir @endrole
                        </div>
                    </div>
                    {{ auth()->user()->address }}
                </div>
                <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Follow {{ $comp->name }} On</div>
                    <a href="https://facebook.com/{{ $comp->fb }}" target="_blank" class="btn btn-social-icon btn-facebook mr-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send/?phone={{ $comp->wa }}&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-social-icon btn-success mr-1">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com/{{ $comp->ig }}" target="_blank" class="btn btn-social-icon btn-instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form method="POST" action="{{ route('user.profileUpdate') }}" class="needs-validation" novalidate="">
                    @csrf
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
                    <div class="card-footer text-right">
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